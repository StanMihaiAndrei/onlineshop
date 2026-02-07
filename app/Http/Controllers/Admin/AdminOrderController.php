<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Services\SamedayService;
use App\Services\SmartBillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    protected $samedayService;

    public function __construct(SamedayService $samedayService)
    {
        $this->samedayService = $samedayService;
    }

    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,delivering,completed,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:1000',
        ]);

        $previousStatus = $order->status;

        $order->update([
            'status' => $validated['status'],
            'cancellation_reason' => $validated['status'] === 'cancelled' ? $validated['cancellation_reason'] : null,
        ]);

        if ($previousStatus !== $validated['status']) {
            try {
                Mail::to($order->shipping_email)
                    ->queue(new OrderStatusUpdatedMail($order, $previousStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to queue status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Starea comenzii a fost actualizată cu succes.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update(['payment_status' => $validated['payment_status']]);

        return back()->with('success', 'Starea plății a fost actualizată cu succes.');
    }

    /**
     * Creare AWB pentru livrare la domiciliu
     */
    public function createHomeAwb(Order $order)
    {
        try {
            if (!$order->canCreateAwb()) {
                return back()->with('error', 'Comanda nu poate avea AWB creat. Verifică ca plata să fie confirmată și datele de livrare să fie complete.');
            }

            if ($order->delivery_type !== 'home') {
                return back()->with('error', 'Această comandă nu este pentru livrare la domiciliu.');
            }

            $orderData = [
                'order_number' => $order->order_number,
                'county_id' => $order->sameday_county_id,
                'city_id' => $order->sameday_city_id,
                'address' => $order->shipping_address,
                'name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
                'email' => $order->shipping_email,
                'postal_code' => $order->shipping_postal_code,
                'is_company' => $order->is_company,
                'company_name' => $order->billing_company_name,
                'company_cif' => $order->billing_cif,
                'weight' => $order->getTotalWeight(),
                'cash_on_delivery' => $order->payment_method === 'cash_on_delivery' ? $order->total_amount : 0,
                'insured_value' => $order->total_amount,
                'notes' => $order->notes,
            ];

            $result = $this->samedayService->createHomeDeliveryAwb($orderData);

            if ($result) {
                // Download și salvează PDF
                $pdfContent = null;
                if (!empty($result['pdf_link'])) {
                    $pdfContent = $this->samedayService->downloadAwbPdf($result['pdf_link']);
                    if ($pdfContent) {
                        $pdfPath = "awb/{$order->order_number}_{$result['awb_number']}.pdf";
                        Storage::disk('public')->put($pdfPath, $pdfContent);
                    }
                }

                $order->update([
                    'sameday_awb_number' => $result['awb_number'],
                    'sameday_awb_cost' => $result['awb_cost'],
                    'sameday_awb_pdf' => $pdfPath ?? null,
                    'sameday_awb_status' => 'created',
                    'status' => 'processing',
                ]);

                return back()->with('success', "AWB creat cu succes: {$result['awb_number']}");
            }

            return back()->with('error', 'Eroare la crearea AWB. Verifică log-urile.');
        } catch (\Exception $e) {
            return back()->with('error', 'Eroare: ' . $e->getMessage());
        }
    }

    /**
     * Creare AWB pentru livrare la locker
     */
    public function createLockerAwb(Order $order)
    {
        try {
            if (!$order->canCreateAwb()) {
                return back()->with('error', 'Comanda nu poate avea AWB creat. Verifică ca plata să fie confirmată și datele de livrare să fie complete.');
            }

            if ($order->delivery_type !== 'locker' || !$order->sameday_locker_id) {
                return back()->with('error', 'Această comandă nu este pentru livrare la locker sau lipsește locker-ul.');
            }

            $orderData = [
                'order_number' => $order->order_number,
                'county_id' => $order->sameday_county_id,
                'city_id' => $order->sameday_city_id,
                'locker_id' => $order->sameday_locker_id,
                'locker_address' => $order->sameday_locker_name ?? 'Locker',
                'name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
                'email' => $order->shipping_email,
                'is_company' => $order->is_company,
                'company_name' => $order->billing_company_name,
                'company_cif' => $order->billing_cif,
                'weight' => $order->getTotalWeight(),
                'cash_on_delivery' => $order->payment_method === 'cash_on_delivery' ? $order->total_amount : 0,
                'insured_value' => $order->total_amount,
                'notes' => $order->notes,
            ];

            $result = $this->samedayService->createLockerDeliveryAwb($orderData);

            if ($result) {
                // Download și salvează PDF
                $pdfContent = null;
                if (!empty($result['pdf_link'])) {
                    $pdfContent = $this->samedayService->downloadAwbPdf($result['pdf_link']);
                    if ($pdfContent) {
                        $pdfPath = "awb/{$order->order_number}_{$result['awb_number']}.pdf";
                        Storage::disk('public')->put($pdfPath, $pdfContent);
                    }
                }

                $order->update([
                    'sameday_awb_number' => $result['awb_number'],
                    'sameday_awb_cost' => $result['awb_cost'],
                    'sameday_awb_pdf' => $pdfPath ?? null,
                    'sameday_awb_status' => 'created',
                    'status' => 'processing',
                ]);

                return back()->with('success', "AWB creat cu succes: {$result['awb_number']}");
            }

            return back()->with('error', 'Eroare la crearea AWB. Verifică log-urile.');
        } catch (\Exception $e) {
            return back()->with('error', 'Eroare: ' . $e->getMessage());
        }
    }

    /**
     * Sincronizare status AWB
     */
    public function syncAwbStatus(Order $order)
    {
        try {
            if (!$order->hasAwb()) {
                return back()->with('error', 'Comanda nu are AWB creat.');
            }

            $status = $this->samedayService->syncAwbStatus($order->sameday_awb_number);

            if ($status) {
                $order->update([
                    'sameday_tracking_history' => $status,
                ]);

                return back()->with('success', 'Status AWB sincronizat cu succes.');
            }

            return back()->with('error', 'Eroare la sincronizarea statusului AWB.');
        } catch (\Exception $e) {
            return back()->with('error', 'Eroare: ' . $e->getMessage());
        }
    }

    /**
     * Download AWB PDF
     */
    public function downloadAwbPdf(Order $order)
    {
        if (!$order->sameday_awb_pdf || !Storage::disk('public')->exists($order->sameday_awb_pdf)) {
            return back()->with('error', 'PDF-ul AWB nu este disponibil.');
        }

        return Storage::disk('public')->download($order->sameday_awb_pdf);
    }

    public function downloadInvoice(Order $order)
    {
        if (!$order->smartbill_series || !$order->smartbill_number) {
            return back()->with('error', 'Factura nu a fost emisă încă.');
        }

        try {
            $smartbillService = app(SmartBillService::class);
            $pdfContent = $smartbillService->getInvoicePdf($order->smartbill_series, $order->smartbill_number);

            if (!$pdfContent) {
                return back()->with('error', 'Nu s-a putut descărca factura.');
            }

            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="factura-' . $order->smartbill_series . '-' . $order->smartbill_number . '.pdf"',
            ]);
        } catch (\Exception $e) {
            Log::error('Eroare la descărcarea facturii: ' . $e->getMessage());
            return back()->with('error', 'A apărut o eroare la descărcarea facturii.');
        }
    }
}
