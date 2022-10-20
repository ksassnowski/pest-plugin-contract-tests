<?php

declare(strict_types=1);

namespace Sassnowski\PestContractTests\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
final class ContractTestDoesNotExistException extends InvalidArgumentException
{
    public function __construct(string $name)
    {
        parent::__construct("No contract test exists for name `$name`");
    }
}
