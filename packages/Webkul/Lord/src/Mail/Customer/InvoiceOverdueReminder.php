<?php

namespace Webkul\Lord\Mail\Customer;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Webkul\Admin\Mail\Mailable;
use Webkul\Sales\Contracts\Invoice;

class InvoiceOverdueReminder extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Invoice $invoice) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address(
                    core()->getSenderEmailDetails()['email'],
                    core()->getSenderEmailDetails()['name']
                ),
            ],
            subject: trans('lord::app.emails.customers.reminder.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'lord::emails.customers.invoice-reminder',
        );
    }
}
