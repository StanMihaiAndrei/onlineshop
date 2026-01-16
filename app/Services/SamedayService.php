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
            ])->post("{$this->baseUrl}/api/authenticate", [
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
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Sameday authentication exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Obține header-ele cu token
     */
    protected function getAuthHeaders(): array
    {
        if (!$this->token) {
            $this->token = $this->authenticate();
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
        return Cache::remember('sameday_counties', now()->addDays(30), function () {
            try {
                $response = Http::withHeaders($this->getAuthHeaders())
                    ->get("{$this->baseUrl}/api/geolocation/county");

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['data'])) {
                        return $data['data'];
                    }

                    if (is_array($data)) {
                        return $data;
                    }
                }

                Log::error('Sameday getCounties failed', [
                    'status' => $response->status()
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('Sameday getCounties exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    /**
     * Obține orașe pentru un județ
     * Structura city din API: { "id": 123, "name": "Sectorul 1", "county": { "id": 1, "name": "Bucuresti" }, ... }
     */
    public function getCities(int $countyId): array
    {
        return Cache::remember("sameday_cities_{$countyId}", now()->addDays(30), function () use ($countyId) {
            try {
                $allCities = $this->getAllCities();

                // Filtrare după county.id
                $filteredCities = array_filter($allCities, function ($city) use ($countyId) {
                    // Verifică dacă există structura county->id
                    if (isset($city['county']) && is_array($city['county']) && isset($city['county']['id'])) {
                        return $city['county']['id'] == $countyId;
                    }
                    return false;
                });

                Log::info('Sameday getCities filtered', [
                    'countyId' => $countyId,
                    'filtered_count' => count($filteredCities),
                    'sample_city' => !empty($filteredCities) ? array_values($filteredCities)[0]['name'] ?? 'N/A' : 'none'
                ]);

                return array_values($filteredCities);
            } catch (\Exception $e) {
                Log::error('Sameday getCities exception', [
                    'countyId' => $countyId,
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    /**
     * Obține toate orașele (paginat)
     */
    protected function getAllCities(): array
    {
        return Cache::remember('sameday_all_cities', now()->addDays(30), function () {
            try {
                $allCities = [];
                $page = 1;
                $perPage = 500;

                do {
                    $response = Http::withHeaders($this->getAuthHeaders())
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

                Log::info('Sameday getAllCities complete', [
                    'total_cities' => count($allCities),
                    'pages_fetched' => $page
                ]);

                return $allCities;
            } catch (\Exception $e) {
                Log::error('Sameday getAllCities exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    /**
     * Obține Easybox/PUDO locations
     * Structura locker din API: { "oohId": 2, "name": "easybox OMV Belu", "countyId": 1, "cityId": 4, ... }
     */
    public function getLockers(int $listingType = 0, ?int $countyId = null, ?int $cityId = null): array
    {
        $cacheKey = "sameday_lockers_{$listingType}_{$countyId}_{$cityId}";

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($listingType, $countyId, $cityId) {
            try {
                $allLockers = $this->getAllLockers($listingType);

                $filteredLockers = $allLockers;

                // Filtrare după countyId (câmp direct în locker)
                if ($countyId) {
                    $filteredLockers = array_filter($filteredLockers, function ($locker) use ($countyId) {
                        return isset($locker['countyId']) && $locker['countyId'] == $countyId;
                    });
                }

                // Filtrare după cityId (câmp direct în locker)
                if ($cityId) {
                    $filteredLockers = array_filter($filteredLockers, function ($locker) use ($cityId) {
                        return isset($locker['cityId']) && $locker['cityId'] == $cityId;
                    });
                }

                return array_values($filteredLockers);
            } catch (\Exception $e) {
                Log::error('Sameday get lockers failed', [
                    'countyId' => $countyId,
                    'cityId' => $cityId,
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    /**
     * Obține toate lockers-urile (paginat)
     */
    protected function getAllLockers(int $listingType = 0): array
    {
        $cacheKey = "sameday_all_lockers_{$listingType}";

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($listingType) {
            try {
                $allLockers = [];
                $page = 1;
                $perPage = 500; // API returnează 500 per pagină by default

                do {
                    $response = Http::withHeaders($this->getAuthHeaders())
                        ->get("{$this->baseUrl}/api/client/ooh-locations", [
                            'page' => $page,
                            'countPerPage' => $perPage,
                            'listingType' => $listingType, // 0 = easybox, 1 = PUDO
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

                    // Adaugă lockers din pagina curentă
                    $allLockers = array_merge($allLockers, $data['data']);

                    $totalPages = $data['pages'] ?? 1;
                    $page++;
                } while ($page <= $totalPages);

                Log::info('Sameday lockers loaded', [
                    'total' => count($allLockers),
                    'listingType' => $listingType
                ]);

                return $allLockers;
            } catch (\Exception $e) {
                Log::error('Sameday get all lockers exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }
    public function getServices(): array
    {
        return Cache::remember('sameday_services', now()->addDays(7), function () {
            try {
                $response = Http::withHeaders($this->getAuthHeaders())
                    ->get("{$this->baseUrl}/api/client/services");

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error('Sameday getServices failed', [
                    'status' => $response->status()
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('Sameday getServices exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function getPickupPoints(): array
    {
        return Cache::remember('sameday_pickup_points', now()->addDays(7), function () {
            try {
                $response = Http::withHeaders($this->getAuthHeaders())
                    ->get("{$this->baseUrl}/api/client/pickup-points");

                if ($response->successful()) {
                    $data = $response->json();

                    // Log pentru debug
                    Log::info('Sameday pickup points response', [
                        'data' => $data
                    ]);

                    // Verifică dacă există cheia 'data'
                    if (isset($data['data']) && is_array($data['data'])) {
                        return $data['data'];
                    }

                    // Dacă răspunsul este direct un array de pickup points
                    if (is_array($data) && !empty($data)) {
                        // Verifică dacă primul element are structura de pickup point
                        $firstElement = reset($data);
                        if (is_array($firstElement) && isset($firstElement['id'])) {
                            return $data;
                        }
                    }

                    Log::warning('Sameday pickup points response has unexpected structure', [
                        'data' => $data
                    ]);

                    return [];
                }

                Log::error('Sameday getPickupPoints failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('Sameday getPickupPoints exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
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
                'awbRecipient' => [
                    'county' => $orderData['county_id'],
                    'city' => $orderData['city_id'],
                    'address' => $orderData['address'],
                    'name' => $orderData['name'],
                    'phoneNumber' => $orderData['phone'],
                    'email' => $orderData['email'],
                    'postalCode' => $orderData['postal_code'] ?? '',
                    'personType' => $orderData['is_company'] ? 1 : 0,
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
                'awbRecipient' => [
                    'name' => $orderData['name'],
                    'phoneNumber' => $orderData['phone'],
                    'email' => $orderData['email'],
                    'personType' => $orderData['is_company'] ? 1 : 0,
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
        Cache::forget('sameday_token');
        Cache::forget('sameday_counties');
        Cache::forget('sameday_all_cities');
        Cache::forget('sameday_services');
        Cache::forget('sameday_pickup_points');
        Cache::forget('sameday_all_lockers_0');
        Cache::forget('sameday_all_lockers_1');

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
        // Prețuri de bază estimate (în RON) - ACTUALIZEAZĂ CU TARIFE REALE
        $basePrices = [
            'home' => [
                'base' => 15.00,  // Cost de bază pentru livrare la domiciliu
                'per_kg' => 2.00, // Cost suplimentar per kg
            ],
            'locker' => [
                'base' => 10.00,  // Cost de bază pentru livrare la locker (mai ieftin)
                'per_kg' => 1.50, // Cost suplimentar per kg
            ]
        ];

        if (!isset($basePrices[$deliveryType])) {
            return 0.00;
        }

        $prices = $basePrices[$deliveryType];

        // Calculează costul de bază
        $cost = $prices['base'];

        // Adaugă cost pentru greutate (peste primul kg)
        if ($weight > 1) {
            $cost += ($weight - 1) * $prices['per_kg'];
        }

        // Majorare pentru județe mai îndepărtate
        // Județul București (ID 1) are prețul de bază
        if ($countyId != 1) {
            $cost += 3.00; // Majorare 3 RON pentru alte județe
        }

        return round($cost, 2);
    }
}
