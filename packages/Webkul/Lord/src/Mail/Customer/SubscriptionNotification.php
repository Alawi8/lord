<?php

namespace Webkul\Lord\Mail\Customer;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Webkul\Core\Contracts\SubscribersList;
use Webkul\Lord\Mail\Mailable;

class SubscriptionNotification extends Mailable
{
    /**
     * Create a mailable instance
     *
     * @return void
     */
    public function __construct(public SubscribersList $subscribersList) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address($this->subscribersList->email),
            ],
            subject: trans('lord::app.emails.customers.subscribed.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'lord::emails.customers.subscribed',
            with: [
                'fullName' => trim($this->subscribersList->first_name.' '.$this->subscribersList->last_name),
            ],
        );
    }
}
