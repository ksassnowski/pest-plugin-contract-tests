# Pest Contract Tests Plugin 

This plugin provides a way to easily define and implement contract tests in Pest. To learn more about what contract tests
are and when you might use them, check out [this blog post](https://www.kai-sassnowski.com/post/contract-tests/) I wrote.

## Installation

Install the plugin via composer:

```
composer require sassnowski/pest-plugin-contract-tests
```

## Usage

To define a new contract test suite, you may use the `contractTest` function provided by the plugin.

```php
// tests/Contracts/FilesystemContract.php

<?php

use function Sassnowski\PestContractTests\contractTest;

contractTest(Filesystem::class, function (Closure $getInstance) {
    it('can save a file for the first time', function () use ($getInstance) {
        /** @var Filesystem $fs */
        $fs = $getInstance();
        
        expect($fs->fileExists('::filename::'))->toBeFalse();
        
        $fs->storeFile(
            new MockFile('::contents::'),
            '::filename::',
        );
        
        expect($fs->fileExists('::filename::'))->toBeTrue();
    });
    
    it('throws an exception if a file with the same name already exists', function () use ($getInstance) {
        /** @var Filesystem $fs */
        $fs = $getInstance();

        $fs->storeFile(
            new MockFile('::contents::'),
            '::filename::'
        );

        // Trying to store another file with the same name should blow up.
        $fs->storeFile(
            new MockFile('::contents::'),
            '::filename::'
        ); 
    })->throws(
        FileAlreadyExistsException::class,
        "The file '::filename::' already exists"
    );
});
```

The `contractTest` method takes two parameters:

1. The name of the contract test. While this can be any string, it is recommended to use the fully-qualified class name (FQCN)
   of the interface described by the contract test.
1. A closure that defines the actual test cases for the contract. Everything inside this closure works exactly like
   vanilla Pest. So, you can use all goodies you're used to like higher-order tests or the `throws` method to check for
   exceptions.

Calling `contractTests` doesn't actually register any tests it. All it does is make the contract tests available to be
used inside other test files. To actually register the tests for a particular class, you may use the `implementsContract` 
function.

```php
// tests/InMemoryFilesystemTest.php

<?php

use function Sassnowski\PestContractTests\implementsContract;

implementsContract(Filesystem::class, fn () => new InMemoryFilesystem());
```

The `implementsContract` function takes the name of the contract test, as well as a factory function which needs to
return an instance of the class you want to test. This factory function is the `$getInstance` parameter that gets passed
to the second parameter of the `contractTest` function.

This will now register all test cases that were registered inside the contract name for the `InMemoryFilesystem` class.

```
$ vendor/bin/pest

PASS Tests\InMemoryFilesystemTest

✓ it can save a file for the first time                   0.12s
✓ it throws an exception if a file with the same name al… 0.08s
```

## Credits

- [Kai Sassnowski](https://github.com/ksassnowski)
- [All contributors](https://github.com/ksassnowski/pest-plugin-contract-tests/contributors)

## License

MIT
