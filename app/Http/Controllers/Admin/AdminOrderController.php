<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
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
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $previousStatus = $order->status;
        
        $order->update(['status' => $validated['status']]);

        // Send email notification to customer if status changed
        if ($previousStatus !== $validated['status']) {
            try {
                Mail::to($order->shipping_email)
                    ->queue(new OrderStatusUpdatedMail($order, $previousStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to queue status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update(['payment_status' => $validated['payment_status']]);

        return back()->with('success', 'Payment status updated successfully.');
    }
}