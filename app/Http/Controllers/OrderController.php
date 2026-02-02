<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\SmartBillService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Download Invoice PDF pentru client
     */
    public function downloadInvoice(Order $order)
    {
        // Verifică dacă utilizatorul autentificat poate accesa această comandă
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to order.');
        }

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
                'Content-Disposition' => 'inline; filename="factura-' . $order->smartbill_series . '-' . $order->smartbill_number . '.pdf"',
            ]);
        } catch (\Exception $e) {
            Log::error('Eroare la descărcarea facturii (client): ' . $e->getMessage());
            return back()->with('error', 'A apărut o eroare la descărcarea facturii.');
        }
    }
}
