<?php

declare(strict_types=1);

namespace Sassnowski\PestContractTests\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
final class ContractTestAlreadyExistsException extends InvalidArgumentException
{
    public function __construct(string $name)
    {
        parent::__construct("A contract test with the name `$name` already exists");
    }
}
