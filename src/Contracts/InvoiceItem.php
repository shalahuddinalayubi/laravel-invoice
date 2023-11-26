<?php

namespace Alayubi\Invoice\Contracts;

use Alayubi\Invoice\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface InvoiceItem
{
    /**
     * Get all of the invoice items.
     */
    public function invoiceItems(): MorphMany;

    /**
     * Map invoice item with parent model.
     */
    public function mapItem() : array;

    /**
     * Create invoice item with map item.
     */
    public function addToInvoiceWithMapItem(array $attributes, Invoice $invoice = null) : Model;

    /**
     * Create invoice item.
     */
    public function addToInvoice(array $attributes, Invoice $invoice = null, bool $withMapItem = true) : Model;
}
