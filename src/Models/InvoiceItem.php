<?php

namespace Alayubi\Invoice\Models;

use DB;
use Error;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class InvoiceItem extends Model
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($invoiceItem) {
            $invoiceItem->uuid = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'name',
        'price',
        'quantity',
        'unit',
        'description',
    ];

    /**
     * Set the total price.
     */
    public function setTotal()
    {
        $this->attributes['total'] = $this->price * $this->quantity;
    }

    /**
     * Get the invoice that owns the invoice item.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the parent invoiceitemable model.
     */
    public function invoiceitemable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        try {
            DB::beginTransaction();

            $isUpdated = parent::update($attributes, $options);

            $this->invoice->updateTotal();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $isUpdated;
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        try {
            DB::beginTransaction();

            $isSaved = parent::save($options);

            $this->invoice->updateTotal();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $isSaved;
    }

    /**
     * Delete the model from database.
     * 
     * @return bool|null
     */
    public function delete()
    {
        try {
            DB::beginTransaction();

            $isDeleted = parent::delete();
    
            $this->invoice->updateTotal();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $isDeleted;
    }
}
