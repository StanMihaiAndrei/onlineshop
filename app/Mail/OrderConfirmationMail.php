<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;

class OrderConfirmationMail extends Mailable 
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public ?string $invoiceSeries = null,
        public ?string $invoiceNumber = null,
        public ?string $invoicePdfPath = null
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = 'Comanda trimisă cu succes - #' . $this->order->order_number;
        
        if ($this->invoiceSeries && $this->invoiceNumber) {
            $subject .= ' - Factura ' . $this->invoiceSeries . $this->invoiceNumber;
        }
        
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.confirmation',
            with: [
                'invoiceSeries' => $this->invoiceSeries,
                'invoiceNumber' => $this->invoiceNumber,
            ]
        );
    }

    public function attachments(): array
    {
        // ✅ Atașează PDF-ul facturii dacă există
        if ($this->invoicePdfPath && Storage::disk('local')->exists($this->invoicePdfPath)) {
            return [
                Attachment::fromStorageDisk('local', $this->invoicePdfPath)
                    ->as("Factura_{$this->invoiceSeries}{$this->invoiceNumber}.pdf")
                    ->withMime('application/pdf'),
            ];
        }
        
        return [];
    }
}