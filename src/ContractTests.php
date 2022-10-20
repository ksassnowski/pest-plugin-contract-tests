<?php

declare(strict_types=1);

namespace Sassnowski\PestContractTests;

use Closure;
use Sassnowski\PestContractTests\Exceptions\ContractTestAlreadyExistsException;
use Sassnowski\PestContractTests\Exceptions\ContractTestDoesNotExistException;

/**
 * @internal
 */
final class ContractTests
{
    /**
     * @var array<non-empty-string, Closure(Closure(): mixed): void>
     */
    private static array $contractTests = [];

    /**
     * @template T
     *
     * @param  non-empty-string  $name
     * @param  Closure(Closure(): T): void  $defineTestCases
     *
     * @throws ContractTestAlreadyExistsException
     */
    public static function add(string $name, Closure $defineTestCases): void
    {
        if (\array_key_exists($name, self::$contractTests)) {
            throw new ContractTestAlreadyExistsException($name);
        }

        self::$contractTests[$name] = $defineTestCases;
    }

    /**
     * @param  non-empty-string  $name
     * @param  Closure(): mixed  $factory
     *
     * @throws ContractTestDoesNotExistException
     */
    public static function expand(string $name, Closure $factory): void
    {
        if (! \array_key_exists($name, self::$contractTests)) {
            throw new ContractTestDoesNotExistException($name);
        }

        self::$contractTests[$name]($factory);
    }
}
