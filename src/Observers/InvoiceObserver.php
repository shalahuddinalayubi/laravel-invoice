<?php

namespace Alayubi\Invoice\Observers;

use Alayubi\Invoice\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "updating" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function updating(Invoice $invoice)
    {
        $invoice->throwForbiddenOperationModelIfSettled('updating ' . $invoice::class);
    }

    /**
     * Handle the Invoice "saving" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function saving(Invoice $invoice)
    {
        $invoice->throwForbiddenOperationModelIfSettled('saving ' . $invoice::class);
    }

    /**
     * Handle the Invoice "deleting" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function deleting(Invoice $invoice)
    {
        $invoice->throwForbiddenOperationModelIfSettled('deleting ' . $invoice::class);
    }

    /**
     * Handle the Invoice "created" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        // 
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        // 
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \Alayubi\Invoice\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
