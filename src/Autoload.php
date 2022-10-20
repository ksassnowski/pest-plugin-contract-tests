<?php

declare(strict_types=1);

namespace Sassnowski\PestContractTests;

use Closure;

/**
 * @template T
 *
 * @param  non-empty-string  $name
 * @param  Closure(Closure(): T): void  $defineTestCases
 */
function contractTest(string $name, Closure $defineTestCases): void
{
    ContractTests::add($name, $defineTestCases);
}

/**
 * @template T
 *
 * @param  non-empty-string  $name
 * @param  Closure(): T  $factory
 */
function implementsContract(string $name, Closure $factory): void
{
    ContractTests::expand($name, $factory);
}
