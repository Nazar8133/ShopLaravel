<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public array $order;
    public array $watch;
    public array $promoCode;
    public array $buyer;
    public string $delivery;
    public string $payment;
    public int $totalCost;

    /**
     * Create a new message instance.
     */
    public function __construct(array $order, array $watch, array $promoCode, array $buyer, string $delivery, string $payment, int $totalCost)
    {
        $this->order=$order;
        $this->watch=$watch;
        $this->promoCode=$promoCode;
        $this->buyer=$buyer;
        $this->delivery=$delivery;
        $this->payment=$payment;
        $this->totalCost=$totalCost;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Замовлення оформлено #'.$this->order['numberOrder']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'user.emailNotification.orderConfirmed',
            with: [
                'order'=>$this->order,
                'watch'=>$this->watch,
                'promoCode'=>$this->promoCode,
                'buyer'=>$this->buyer,
                'delivery'=>$this->delivery,
                'payment'=>$this->payment,
                'totalCost'=>$this->totalCost
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
