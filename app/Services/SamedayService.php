<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SamedayService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.sameday.base_url');
        $this->username = config('services.sameday.username');
        $this->password = config('services.sameday.password');
    }

    /**
     * Autentificare și obținere token
     */
    public function authenticate($rememberMe = true): ?string
    {
        $cacheKey = 'sameday_token';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::withHeaders([
                'X-AUTH-USERNAME' => $this->username,
                'X-AUTH-PASSWORD' => $this->password,
            ])->timeout(10)->post("{$this->baseUrl}/api/authenticate", [
                'remember_me' => $rememberMe
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['token'] ?? null;

                if ($token) {
                    Cache::put($cacheKey, $token, now()->addHours(24));
                    Log::info('Sameday authentication successful');
                    return $token;
                }
            }

            Log::error('Sameday authentication failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Sameday authentication failed');
        } catch (\Exception $e) {
            Log::error('Sameday authentication exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obține header-ele cu token
     */
    protected function getAuthHeaders(): array
    {
        if (!$this->token) {
            $this->token = $this->authenticate();

            if (!$this->token) {
                throw new \Exception('Cannot get auth token for Sameday API');
            }
        }

        return [
            'X-AUTH-TOKEN' => $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Obține județe
     */
    public function getCounties(): array
    {
        $cacheKey = 'sameday_counties';

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout(10)
                ->get("{$this->baseUrl}/api/geolocation/county");

            if ($response->successful()) {
                $data = $response->json();
                $counties = $data['data'] ?? $data;

                if (!empty($counties) && is_array($counties)) {
                    Cache::put($cacheKey, $counties, now()->addDays(30));
                    Log::info('Sameday counties cached successfully', ['count' => count($counties)]);
                    return $counties;
                }

                Log::error('Sameday getCounties returned empty data');
                throw new \Exception('No counties data received from Sameday API');
            }

            Log::error('Sameday getCounties failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Sameday API request failed with status: ' . $response->status());
        } catch (\Exception $e) {
            Log::error('Sameday getCounties exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obține orașe pentru un județ
     */
    public function getCities(int $countyId): array
    {
        $cacheKey = "sameday_cities_{$countyId}";

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $allCities = $this->getAllCities();

            $filteredCities = array_filter($allCities, function ($city) use ($countyId) {
                if (isset($city['county']) && is_array($city['county']) && isset($city['county']['id'])) {
                    return $city['county']['id'] == $countyId;
                }
                return false;
            });

            $result = array_values($filteredCities);

            if (!empty($result)) {
                Cache::put($cacheKey, $result, now()->addDays(30));
                Log::info('Sameday cities cached', ['countyId' => $countyId, 'count' => count($result)]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Sameday getCities exception', [
                'countyId' => $countyId,
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obține toate orașele (paginat)
     */
    protected function getAllCities(): array
    {
        $cacheKey = 'sameday_all_cities';

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $allCities = [];
            $page = 1;
            $perPage = 500;

            do {
                $response = Http::withHeaders($this->getAuthHeaders())
                    ->timeout(10)
                    ->get("{$this->baseUrl}/api/geolocation/city", [
                        'countPerPage' => $perPage,
                        'page' => $page
                    ]);

                if (!$response->successful()) {
                    Log::error('Sameday getAllCities page failed', [
                        'page' => $page,
                        'status' => $response->status()
                    ]);
                    break;
                }

                $data = $response->json();

                if (isset($data['data']) && is_array($data['data'])) {
                    $allCities = array_merge($allCities, $data['data']);

                    if ($page >= ($data['pages'] ?? 1)) {
                        break;
                    }

                    $page++;
                } else {
                    break;
                }
            } while (true);

            if (!empty($allCities)) {
                Cache::put($cacheKey, $allCities, now()->addDays(30));
                Log::info('Sameday getAllCities complete', [
                    'total_cities' => count($allCities),
                    'pages_fetched' => $page
                ]);
            }

            return $allCities;
        } catch (\Exception $e) {
            Log::error('Sameday getAllCities exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obține Easybox/PUDO locations
     * Structura locker din API: { "oohId": 2, "name": "easybox OMV Belu", "countyId": 1, "cityId": 4, ... }
     */
    public function getLockers(int $listingType = 0, ?int $countyId = null, ?int $cityId = null): array
    {
        $cacheKey = "sameday_lockers_{$listingType}_{$countyId}_{$cityId}";

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $allLockers = $this->getAllLockers($listingType);

            $filteredLockers = $allLockers;

            if ($countyId) {
                $filteredLockers = array_filter($filteredLockers, function ($locker) use ($countyId) {
                    return isset($locker['countyId']) && $locker['countyId'] == $countyId;
                });
            }

            if ($cityId) {
                $filteredLockers = array_filter($filteredLockers, function ($locker) use ($cityId) {
                    return isset($locker['cityId']) && $locker['cityId'] == $cityId;
                });
            }

            $result = array_values($filteredLockers);

            if (!empty($result)) {
                Cache::put($cacheKey, $result, now()->addHours(6));
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Sameday get lockers failed', [
                'countyId' => $countyId,
                'cityId' => $cityId,
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obține toate lockers-urile (paginat)
     */
    protected function getAllLockers(int $listingType = 0): array
    {
        $cacheKey = "sameday_all_lockers_{$listingType}";

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $allLockers = [];
            $page = 1;
            $perPage = 500;

            do {
                $response = Http::withHeaders($this->getAuthHeaders())
                    ->timeout(10)
                    ->get("{$this->baseUrl}/api/client/ooh-locations", [
                        'page' => $page,
                        'countPerPage' => $perPage,
                        'listingType' => $listingType,
                    ]);

                if (!$response->successful()) {
                    Log::error('Sameday get ooh-locations failed', [
                        'status' => $response->status(),
                        'page' => $page,
                        'body' => $response->body()
                    ]);
                    break;
                }

                $data = $response->json();

                if (!isset($data['data']) || empty($data['data'])) {
                    break;
                }

                $allLockers = array_merge($allLockers, $data['data']);

                $totalPages = $data['pages'] ?? 1;
                $page++;
            } while ($page <= $totalPages);

            if (!empty($allLockers)) {
                Cache::put($cacheKey, $allLockers, now()->addHours(6));
                Log::info('Sameday lockers loaded', [
                    'total' => count($allLockers),
                    'listingType' => $listingType
                ]);
            }

            return $allLockers;
        } catch (\Exception $e) {
            Log::error('Sameday get all lockers exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getServices(): array
    {
        $cacheKey = 'sameday_services';

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout(10)
                ->get("{$this->baseUrl}/api/client/services");

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data)) {
                    Cache::put($cacheKey, $data, now()->addDays(7));
                    return $data;
                }

                throw new \Exception('No services data received');
            }

            Log::error('Sameday getServices failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to fetch services');
        } catch (\Exception $e) {
            Log::error('Sameday getServices exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getPickupPoints(): array
    {
        $cacheKey = 'sameday_pickup_points';

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout(10)
                ->get("{$this->baseUrl}/api/client/pickup-points");

            if ($response->successful()) {
                $data = $response->json();

                Log::info('Sameday pickup points response', ['data_keys' => array_keys($data)]);

                $pickupPoints = [];
                if (isset($data['data']) && is_array($data['data'])) {
                    $pickupPoints = $data['data'];
                } elseif (is_array($data) && !empty($data)) {
                    $firstElement = reset($data);
                    if (is_array($firstElement) && isset($firstElement['id'])) {
                        $pickupPoints = $data;
                    }
                }

                if (!empty($pickupPoints)) {
                    Cache::put($cacheKey, $pickupPoints, now()->addDays(7));
                    Log::info('Sameday pickup points cached', ['count' => count($pickupPoints)]);
                    return $pickupPoints;
                }

                Log::error('Sameday pickup points response has unexpected structure', ['data' => $data]);
                throw new \Exception('No pickup points found');
            }

            Log::error('Sameday getPickupPoints failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to fetch pickup points');
        } catch (\Exception $e) {
            Log::error('Sameday getPickupPoints exception', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function createHomeDeliveryAwb(array $orderData): ?array
    {
        try {
            $pickupPoints = $this->getPickupPoints();

            // Verificare mai robustă
            if (empty($pickupPoints) || !is_array($pickupPoints)) {
                Log::error('No pickup points available or invalid format', [
                    'pickupPoints' => $pickupPoints
                ]);
                return null;
            }

            // Asigură-te că este un array indexat numeric
            $pickupPoints = array_values($pickupPoints);

            if (!isset($pickupPoints[0])) {
                Log::error('First pickup point not found after array_values', [
                    'pickupPoints' => $pickupPoints
                ]);
                return null;
            }

            // Get first pickup point
            $pickupPoint = $pickupPoints[0];
            $pickupPointId = $pickupPoint['id'] ?? null;

            if (!$pickupPointId) {
                Log::error('Pickup point ID not found', ['pickupPoint' => $pickupPoint]);
                return null;
            }

            // Get contact person ID safely - CÂMPUL CORECT: pickupPointContactPerson
            $contactPersonId = null;
            if (isset($pickupPoint['pickupPointContactPerson']) && is_array($pickupPoint['pickupPointContactPerson']) && !empty($pickupPoint['pickupPointContactPerson'])) {
                $contactPersons = array_values($pickupPoint['pickupPointContactPerson']);
                if (isset($contactPersons[0]['id'])) {
                    $contactPersonId = $contactPersons[0]['id'];
                }
            }

            if (!$contactPersonId) {
                Log::error('Contact person not found', [
                    'pickupPoint' => $pickupPoint,
                    'available_keys' => array_keys($pickupPoint)
                ]);
                return null;
            }

            $serviceId = 7;

            $payload = [
                'pickupPoint' => $pickupPointId,
                'contactPerson' => $contactPersonId,
                'packageType' => 0,
                'packageNumber' => 1,
                'packageWeight' => $orderData['weight'],
                'service' => $serviceId,
                'awbPayment' => 1,
                'cashOnDelivery' => $orderData['cash_on_delivery'] ?? 0,
                'insuredValue' => $orderData['insured_value'] ?? 0,
                'thirdPartyPickup' => 0,
                'observation' => $orderData['notes'] ?? '',
                'awbRecipient' => [
                    'county' => $orderData['county_id'],
                    'city' => $orderData['city_id'],
                    'address' => $orderData['address'],
                    'name' => $orderData['name'],
                    'phoneNumber' => $orderData['phone'],
                    'email' => $orderData['email'],
                    'postalCode' => $orderData['postal_code'] ?? '',
                    'personType' => $orderData['is_company'] ? 1 : 0,
                    'companyName' => $orderData['is_company'] && !empty($orderData['company_name']) ? $orderData['company_name'] : null,
                    'companyCui' => $orderData['is_company'] && !empty($orderData['company_cif']) ? $orderData['company_cif'] : null,
                ],
                'parcels' => [
                    [
                        'weight' => $orderData['weight'],
                        'width' => 10,
                        'length' => 10,
                        'height' => 10
                    ]
                ],
                'clientInternalReference' => $orderData['order_number'],
            ];

            Log::info('Creating home delivery AWB', ['payload' => $payload]);

            $response = Http::withHeaders($this->getAuthHeaders())
                ->post("{$this->baseUrl}/api/awb", $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'awb_number' => $data['awbNumber'] ?? null,
                    'awb_cost' => $data['awbCost'] ?? 0,
                    'pdf_link' => $data['pdfLink'] ?? null,
                ];
            }

            Log::error('Sameday createHomeDeliveryAwb failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Sameday createHomeDeliveryAwb exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function createLockerDeliveryAwb(array $orderData): ?array
    {
        try {
            $pickupPoints = $this->getPickupPoints();

            // Verificare mai robustă
            if (empty($pickupPoints) || !is_array($pickupPoints)) {
                Log::error('No pickup points available or invalid format', [
                    'pickupPoints' => $pickupPoints
                ]);
                return null;
            }

            // Asigură-te că este un array indexat numeric
            $pickupPoints = array_values($pickupPoints);

            if (!isset($pickupPoints[0])) {
                Log::error('First pickup point not found after array_values', [
                    'pickupPoints' => $pickupPoints
                ]);
                return null;
            }

            // Get first pickup point
            $pickupPoint = $pickupPoints[0];
            $pickupPointId = $pickupPoint['id'] ?? null;

            if (!$pickupPointId) {
                Log::error('Pickup point ID not found', ['pickupPoint' => $pickupPoint]);
                return null;
            }

            // Get contact person ID safely - CÂMPUL CORECT: pickupPointContactPerson
            $contactPersonId = null;
            if (isset($pickupPoint['pickupPointContactPerson']) && is_array($pickupPoint['pickupPointContactPerson']) && !empty($pickupPoint['pickupPointContactPerson'])) {
                $contactPersons = array_values($pickupPoint['pickupPointContactPerson']);
                if (isset($contactPersons[0]['id'])) {
                    $contactPersonId = $contactPersons[0]['id'];
                }
            }

            if (!$contactPersonId) {
                Log::error('Contact person not found', [
                    'pickupPoint' => $pickupPoint,
                    'available_keys' => array_keys($pickupPoint)
                ]);
                return null;
            }

            $serviceId = 15; // Locker Nextday service

            $payload = [
                'pickupPoint' => $pickupPointId,
                'contactPerson' => $contactPersonId,
                'packageType' => 0,
                'packageNumber' => 1,
                'packageWeight' => $orderData['weight'],
                'service' => $serviceId,
                'awbPayment' => 1,
                'cashOnDelivery' => $orderData['cash_on_delivery'] ?? 0,
                'insuredValue' => $orderData['insured_value'] ?? 0,
                'thirdPartyPickup' => 0,
                'observation' => $orderData['notes'] ?? '',
                'awbRecipient' => [
                    'name' => $orderData['name'],
                    'phoneNumber' => $orderData['phone'],
                    'email' => $orderData['email'],
                    'personType' => $orderData['is_company'] ? 1 : 0,
                    'companyName' => $orderData['is_company'] && !empty($orderData['company_name']) ? $orderData['company_name'] : null,
                    'companyCui' => $orderData['is_company'] && !empty($orderData['company_cif']) ? $orderData['company_cif'] : null,
                ],
                'parcels' => [
                    [
                        'weight' => $orderData['weight'],
                        'width' => 10,
                        'length' => 10,
                        'height' => 10
                    ]
                ],
                'clientInternalReference' => $orderData['order_number'],
                'oohLastMile' => (int) $orderData['locker_id'],
            ];

            Log::info('Creating locker delivery AWB', ['payload' => $payload]);

            $response = Http::withHeaders($this->getAuthHeaders())
                ->post("{$this->baseUrl}/api/awb", $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'awb_number' => $data['awbNumber'] ?? null,
                    'awb_cost' => $data['awbCost'] ?? 0,
                    'pdf_link' => $data['pdfLink'] ?? null,
                ];
            }

            Log::error('Sameday createLockerDeliveryAwb failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Sameday createLockerDeliveryAwb exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function syncAwbStatus(string $awbNumber): ?array
    {
        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->get("{$this->baseUrl}/api/client/awb/parcel-status-history/{$awbNumber}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Sameday syncAwbStatus failed', [
                'awbNumber' => $awbNumber,
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Sameday syncAwbStatus exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function downloadAwbPdf(string $pdfLink): ?string
    {
        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->get($pdfLink);

            if ($response->successful()) {
                return $response->body();
            }

            Log::error('Sameday downloadAwbPdf failed', [
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Sameday downloadAwbPdf exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function clearCache(): void
    {
        $keysToForget = [
            'sameday_token',
            'sameday_counties',
            'sameday_all_cities',
            'sameday_services',
            'sameday_pickup_points',
            'sameday_all_lockers_0',
            'sameday_all_lockers_1',
        ];

        foreach ($keysToForget as $key) {
            Cache::forget($key);
        }

        // Clear city caches
        for ($i = 1; $i <= 50; $i++) {
            Cache::forget("sameday_cities_{$i}");
        }

        // Clear locker caches
        for ($i = 1; $i <= 50; $i++) {
            for ($j = 1; $j <= 10000; $j += 100) {
                Cache::forget("sameday_lockers_0_{$i}_{$j}");
                Cache::forget("sameday_lockers_1_{$i}_{$j}");
            }
        }

        Log::info('Sameday cache cleared');
    }

    /**
     * Estimează costul de livrare bazat pe serviciu și greutate
     * Aceste prețuri sunt aproximative - actualizează cu tarife reale Sameday
     */
    public function estimateShippingCost(string $deliveryType, float $weight, int $countyId, ?int $lockerId = null): float
    {
        $basePrices = [
            'home' => [
                'base' => 25.00,
                'per_kg' => 2.00,
            ],
            'locker' => [
                'base' => 20.00,
                'per_kg' => 1.50,
            ]
        ];

        if (!isset($basePrices[$deliveryType])) {
            return 0.00;
        }

        $prices = $basePrices[$deliveryType];
        $cost = $prices['base'];

        if ($weight > 1) {
            $cost += ($weight - 1) * $prices['per_kg'];
        }

        if ($countyId != 1) {
            $cost += 3.00;
        }

        return round($cost, 2);
    }
}
