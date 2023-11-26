<?php

namespace Alayubi\Invoice\Traits;

use Alayubi\Invoice\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasInvoice
{
    /**
     * Get all of invoices.
     */
    public function invoices() : MorphMany
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    /**
     * Create invoice model.
     */
    public function createInvoice() : Model
    {
        return $this->invoices()->create();
    }    
}
