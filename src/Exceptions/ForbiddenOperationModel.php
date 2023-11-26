<?php

namespace Alayubi\Invoice\Exceptions;

use Alayubi\Invoice\Models\Invoice;
use BadMethodCallException;

class ForbiddenOperationModel extends BadMethodCallException
{
    public function __construct(string $operation = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Forbidden ' . $operation . ' operation on model ' . Invoice::class . ' with status ' . config('invoice.settled'), $code, $previous);
    }
}
