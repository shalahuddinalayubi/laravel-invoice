<?php

namespace Alayubi\Invoice\Models;

use Alayubi\Invoice\Contracts\InvoiceItem as InvoiceItemInterface;
use Alayubi\Invoice\Exceptions\ForbiddenOperationModel;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_date',
        'status',
        'total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_date' => 'datetime',
    ];

    /**
     * Get the parent invoiceable model.
     */
    public function customer()
    {
        return $this->morphTo('invoiceable');
    }

    /**
     * Get the invoice items for the invoice.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Add item to invoice.
     */
    public function addItem(InvoiceItemInterface $invoiceItem, array $attributes, bool $withMapItem = true) : InvoiceItem
    {
        return $invoiceItem->addToInvoice($attributes, $this, $withMapItem);
    }

    /**
     * Update the total attribute of invoice.
     */
    public function updateTotal() : bool
    {
        $this->total = $this->invoiceItems()->sum('total');

        return $this->save();
    }

    /**
     * Add item to invoice wiht map.
     */
    public function addItemWithMap(InvoiceItemInterface $invoiceItem, array $attributes) : InvoiceItem
    {
        return $invoiceItem->addToInvoiceWithMapItem($attributes, $this);
    }

    /**
     * Determine if the invoice is settled.
     */
    public function isSettled() : bool
    {
        return $this->getOriginal('status') == config('invoice.settled');
    }

    /**
     * Update the invoice status as settled.
     */
    public function makeSettled() : bool
    {
        return $this->update(['status' => config('invoice.settled')]);
    }

    /**
     * Throw exception if the model with status settled.
     * 
     * @throws \Alayubi\Invoice\Exceptions\ForbiddenOperationModel
     */
    public function throwForbiddenOperationModelIfSettled(string $operation = '', int $code = 0, ?Throwable $previous = null) : void
    {
        if ($this->isSettled()) {
            throw new ForbiddenOperationModel($operation, $code, $previous);
        }
    }
}
