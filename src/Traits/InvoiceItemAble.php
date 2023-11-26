<?php

namespace Alayubi\Invoice\Traits;

use Alayubi\Invoice\Models\Invoice;
use Alayubi\Invoice\Models\InvoiceItem;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use InvalidArgumentException;

trait InvoiceItemAble
{
    /**
     * Get all of the invoice items.
     */
    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceitemable');
    }

    /**
     * Map invoice item with parent model.
     */
    public function mapItem() : array
    {
        return [];
    }

    /**
     * Create invoice item with map item.
     */
    public function addToInvoiceWithMapItem(array $attributes, Invoice $invoice = null) : Model
    {
        $attributes = array_merge($this->mapItem(), $attributes);
        
        return $this->addToInvoice($attributes, $invoice);
    }

    /**
     * Create invoice item.
     */
    public function addToInvoice(array $attributes, Invoice $invoice = null, bool $withMapItem = true) : Model
    {
        if (!array_key_exists('invoice_id', $attributes)) {

            if (is_null($invoice)) {
                throw new InvalidArgumentException('Please add invoice_id key to $attributes argument if $invoice argument is null.');
            }

            $attributes['invoice_id'] = $invoice->id;
        }

        if ($withMapItem) {
            $attributes = array_merge($this->mapItem(), $attributes);
        }
        
        try {
            DB::beginTransaction();
            $invoiceItem = $this->invoiceItems()->create($attributes);
            $invoiceItem->invoice->updateTotal();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $invoiceItem;
    }
}
