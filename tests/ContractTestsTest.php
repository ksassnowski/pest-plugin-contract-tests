<?php

declare(strict_types=1);

use Sassnowski\PestContractTests\ContractTests;
use Sassnowski\PestContractTests\Exceptions\ContractTestAlreadyExistsException;
use Sassnowski\PestContractTests\Exceptions\ContractTestDoesNotExistException;

it('throws an exception when trying to expand a contract test that does not exist', function (): void {
    ContractTests::expand('::name::', fn () => null);
})->throws(ContractTestDoesNotExistException::class);

it('throws an exception when trying to add a contract test with an existing name', function (): void {
    ContractTests::add('::name::', function (Closure $getInstance) {
    });
    ContractTests::add('::name::', function (Closure $getInstance) {
    });
})->throws(ContractTestAlreadyExistsException::class);
