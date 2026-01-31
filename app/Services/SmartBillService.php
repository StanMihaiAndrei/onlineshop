<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmartBillService
{
    protected $baseUrl;
    protected $username;
    protected $token;
    protected $cif;

    public function __construct()
    {
        $this->baseUrl = config('services.smartbill.base_url');
        $this->username = config('services.smartbill.username');
        $this->token = config('services.smartbill.token');
        $this->cif = config('services.smartbill.cif');
    }

    /**
     * Get authorization header (Basic Authentication)
     */
    protected function getAuthHeaders(): array
    {
        $credentials = base64_encode($this->username . ':' . $this->token);

        return [
            'Authorization' => 'Basic ' . $credentials,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Emit invoice for order
     */
    public function createInvoice(array $orderData): ?array
    {
        try {
            $url = "{$this->baseUrl}/invoice";

            $invoiceData = $this->prepareInvoiceData($orderData);

            Log::info('SmartBill Invoice Request', [
                'url' => $url,
                'data' => $invoiceData
            ]);

            $response = Http::withHeaders($this->getAuthHeaders())
                ->post($url, $invoiceData);

            if ($response->successful()) {
                $result = $response->json();

                Log::info('SmartBill Invoice Created', [
                    'series' => $result['series'] ?? null,
                    'number' => $result['number'] ?? null
                ]);

                return [
                    'series' => $result['series'] ?? null,
                    'number' => $result['number'] ?? null,
                    'url' => $result['url'] ?? null,
                ];
            }

            Log::error('SmartBill Invoice Failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('SmartBill Invoice Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Prepare invoice data from order
     */
    protected function prepareInvoiceData(array $orderData): array
    {
        $order = $orderData['order'];
        $items = $orderData['items'];

        // Prepare products array (WITHOUT TVA for non-VAT payer)
        $products = [];
        foreach ($items as $item) {
            $products[] = [
                'name' => $item['name'] ?? 'Produs',  // ✅ OBLIGATORIU - nu mai poate fi null
                'code' => $item['code'] ?? '',
                'isDiscount' => false,
                'measuringUnitName' => 'buc',
                'currency' => 'RON',
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'saveToDb' => false,
                'isService' => false
                // ✅ FĂRĂ parametrii TVA pentru firmă neplatitoare!
            ];
        }

        // Add shipping as a product if exists (WITHOUT TVA)
        if ($order['shipping_cost'] > 0) {
            $products[] = [
                'name' => 'Transport',
                'code' => 'SHIPPING',
                'isDiscount' => false,
                'measuringUnitName' => 'buc',
                'currency' => 'RON',
                'quantity' => 1,
                'price' => $order['shipping_cost'],
                'saveToDb' => false,
                'isService' => true
                // ✅ FĂRĂ parametrii TVA pentru firmă neplatitoare!
            ];
        }

        return [
            'companyVatCode' => $this->cif,  // ✅ Acum va avea valoarea corectă
            'client' => [
                'name' => $order['shipping_name'],
                'vatCode' => '',
                'address' => $order['shipping_address'] ?? '-',
                'city' => $order['shipping_city'] ?? '-',
                'county' => $order['shipping_county'] ?? '-',
                'country' => $order['shipping_country'] ?? 'Romania',
                'email' => $order['shipping_email'],
                'phone' => $order['shipping_phone'] ?? '',
                'saveToDb' => false
            ],
            'issueDate' => now()->format('Y-m-d'),
            'seriesName' => config('services.smartbill.series_name', 'TEST'),
            'isDraft' => false,
            'dueDate' => now()->addDays(30)->format('Y-m-d'),
            'currency' => 'RON',
            'products' => $products
        ];
    }

    /**
     * Get invoice PDF
     */
    public function getInvoicePdf(string $series, string $number): ?string
    {
        try {
            $url = "{$this->baseUrl}/invoice/pdf";

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->token),
                'Accept' => 'application/octet-stream',
                'Content-Type' => 'application/json',
            ])->get($url, [
                'cif' => $this->cif,
                'seriesname' => $series,
                'number' => $number
            ]);

            if ($response->successful()) {
                return $response->body();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('SmartBill PDF Download Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send invoice by email
     */
    // public function sendInvoiceByEmail(string $series, string $number, string $email): bool
    // {
    //     try {
    //         $url = "{$this->baseUrl}/document/send";

    //         $subject = base64_encode('Factura #serie numar document#');
    //         $bodyText = base64_encode('Buna ziua, </br></br>Atasat va transmitem #tip document# #serie numar document# emisa in data de #data emiterii#, in valoare de #total document#. </br></br> Multumim pentru colaborare!');

    //         $response = Http::withHeaders($this->getAuthHeaders())
    //             ->post($url, [
    //                 'companyVatCode' => $this->cif,
    //                 'seriesName' => $series,
    //                 'number' => $number,
    //                 'type' => 'factura',
    //                 'subject' => $subject,
    //                 'to' => $email,
    //                 'bodyText' => $bodyText
    //             ]);

    //         if ($response->successful()) {
    //             $result = $response->json();
    //             return isset($result['status']['code']) && $result['status']['code'] == 0;
    //         }

    //         return false;
    //     } catch (\Exception $e) {
    //         Log::error('SmartBill Email Send Exception', [
    //             'message' => $e->getMessage()
    //         ]);
    //         return false;
    //     }
    // }

    public function sendInvoiceByEmail(string $series, string $number, string $email): bool
    {
        try {
            $url = "{$this->baseUrl}/document/send";

            $subject = base64_encode('Factura #serie numar document#');
            $bodyText = base64_encode('Buna ziua, </br></br>Atasat va transmitem #tip document# #serie numar document# emisa in data de #data emiterii#, in valoare de #total document#. </br></br> Multumim pentru colaborare!');

            $response = Http::withHeaders($this->getAuthHeaders())
                ->post($url, [
                    'companyVatCode' => $this->cif,
                    'seriesName' => $series,
                    'number' => $number,
                    'type' => 'factura',
                    'subject' => $subject,
                    'to' => $email,
                    'bodyText' => $bodyText
                ]);

            Log::info('SmartBill Invoice Email Sent', [
                'series' => $series,
                'number' => $number,
                'email' => $email,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return isset($result['status']['code']) && $result['status']['code'] == 0;
            }

            Log::error('SmartBill Invoice Email Failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('SmartBill Email Send Exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }
}
