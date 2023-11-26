<?php

namespace Alayubi\Invoice;

use Alayubi\Invoice\Models\Invoice;
use Alayubi\Invoice\Models\InvoiceItem;
use Alayubi\Invoice\Observers\InvoiceItemObserver;
use Alayubi\Invoice\Observers\InvoiceObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/invoice.php', 'invoice');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::observe(InvoiceObserver::class);
        InvoiceItem::observe(InvoiceItemObserver::class);

        $this->publishes([
            __DIR__ . '/../database/migrations/create_invoices_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_invoices_table.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../config/invoice.php' => config_path('invoice.php'),
        ]);
    }
}
