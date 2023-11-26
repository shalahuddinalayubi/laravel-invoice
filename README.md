# Laravel Invoice
This package handle invoice in your Laravel app.

# Installing

1. Install the package via composer:
```bash
composer require
```
2. You should publish the migration and the config/invoice.php file with:
```bash
php artisan vendor:publish --provider="Alayubi\Invoice\InvoiceServiceProvider"
```
3. Run the migrations
```bash
php artisan migrate
```

# Basic Usage

## `customer` and `item`

A customer is a model that posible has many invoices whereas an item is model
that can be added to invoice.

## Add trait

Add the `Alayubi\Invoice\Traits\HasInvoice` trait to your model:

```php
use Alayubi\Invoice\Traits\HasInvoice;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasInvoice;
}
```

By adding the trait to your model makes your model become a `customer`.

Add the `Alayubi\Invoice\Traits\InvoiceItemAble` trait to your model:

```php
use Alayubi\Invoice\Contracts\InvoiceItem as InvoiceItemInterface;
use Alayubi\Invoice\Traits\InvoiceItemAble;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model implements InvoiceItemInterface;
{
    use InvoiceItemAble;
}
```

By adding the trait to your model makes your model become an `item`.

## Map Item

You may override the `mapItem` method on your item to set the default values
for the item that would like to added to invoice.

```php
use Alayubi\Invoice\Contracts\InvoiceItem as InvoiceItemInterface;
use Alayubi\Invoice\Traits\InvoiceItemAble;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model implements InvoiceItemInterface;
{
    use InvoiceItemAble;

    public function mapItem() : array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'unit' => $this->unit,
        ];
    }
}
```

## Create Invoice

An invoice ca be created using a method:

```php
$invoice = $user->createInvoice();
```

## Add Item To Invoice

An item ca be added to an invoice usign a method:
```php
// First find the item.
$stuff = \App\Models\Stuff::find(34);

// Add the item through invoice.
$invoice->addItem($stuff, ['quantity' => 10]);

// Add the item through item.
$stuff->addToInvoice(['quantity' => 10], $invoice);
```

### addItem Method

The second argument is an array of attributes.
If you supply the argument, it will override the default values in `mapItem`.

### addToInvoice Method

The first argument is an array of attributes.
If you supply the argument, it will override the default values in `mapItem`.

## Settled

Settled is a condition where the invoice status is settled. You may change the
value of settled in config file.

```php
return [
    'settled' => 'settled'
];
```

if the status of invoice is settled you can not modify the invoice and neither
you can create, delete, or update the item that is belongs to the invoice if you
do so the `Alayubi\Invoice\Exceptions\ForbiddenOperationModel` will be throw.

Settled methods:

```php
// Make the invoice to be settled.
$invoice->makeSettled();

// Check the invoice is settled.
$invoice->isSettled();
```
