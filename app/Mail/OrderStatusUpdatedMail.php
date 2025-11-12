<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $previousStatus
    ) {
        $this->delay(now()->addSeconds(5));
    }

    public function envelope(): Envelope
    {
        $statusMessage = match($this->order->status) {
            'processing' => 'în procesare',
            'completed' => 'finalizată',
            'cancelled' => 'anulată',
            default => $this->order->status
        };

        return new Envelope(
            subject: 'Actualizare comandă #' . $this->order->order_number . ' - ' . $statusMessage,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.status-updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}