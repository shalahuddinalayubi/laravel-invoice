<?php

namespace Alayubi\Invoice\Observers;

use Alayubi\Invoice\Models\InvoiceItem;

class InvoiceItemObserver
{
    /**
     * Handle the InvoiceItem "updating" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function updating(InvoiceItem $invoiceItem)
    {
        $invoiceItem->invoice->throwForbiddenOperationModelIfSettled('updating ' . $invoiceItem::class);

        $invoiceItem->setTotal();
    }

    /**
     * Handle the InvoiceItem "updated" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function saving(InvoiceItem $invoiceItem)
    {
        $invoiceItem->invoice->throwForbiddenOperationModelIfSettled('saving ' . $invoiceItem::class);

        $invoiceItem->setTotal();
    }

    /**
     * Handle the InvoiceItem "updated" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function deleting(InvoiceItem $invoiceItem)
    {
        $invoiceItem->invoice->throwForbiddenOperationModelIfSettled('deleting ' . $invoiceItem::class);
    }

    /**
     * Handle the InvoiceItem "creating" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function creating(InvoiceItem $invoiceItem)
    {
        $invoiceItem->invoice->throwForbiddenOperationModelIfSettled('creating ' . $invoiceItem::class);

        $invoiceItem->setTotal();
    }

    /**
     * Handle the InvoiceItem "created" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function created(InvoiceItem $invoiceItem)
    {
        // 
    }

    /**
     * Handle the InvoiceItem "updated" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function updated(InvoiceItem $invoiceItem)
    {
        // 
    }

    /**
     * Handle the InvoiceItem "deleted" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function deleted(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Handle the InvoiceItem "restored" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function restored(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Handle the InvoiceItem "force deleted" event.
     *
     * @param  \Alayubi\Invoice\Models\InvoiceItem  $invoiceItem
     * @return void
     */
    public function forceDeleted(InvoiceItem $invoiceItem)
    {
        //
    }
}
