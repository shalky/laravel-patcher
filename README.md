# Laravel Data Patcher

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielemontecchi/laravel-data-patcher.svg?style=flat-square)](https://packagist.org/packages/danielemontecchi/laravel-data-patcher)
[![Total Downloads](https://img.shields.io/packagist/dt/danielemontecchi/laravel-data-patcher.svg?style=flat-square)](https://packagist.org/packages/danielemontecchi/laravel-data-patcher)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/danielemontecchi/laravel-data-patcher/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/danielemontecchi/laravel-data-patcher/actions/workflows/tests.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=danielemontecchi_laravel-data-patcher&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=danielemontecchi_laravel-data-patcher)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)
[![Documentation](https://img.shields.io/badge/docs-available-brightgreen.svg?style=flat-square)](https://danielemontecchi.github.io/laravel-data-patcher)

Laravel Data Patcher is a Laravel package designed to manage data patches effectively, similar to migrations but specifically focused on data alterations post-migration. Inspired by the approach suggested by Taylor Otwell, this package offers structured, maintainable, and predictable handling of database patches.

---

## Installation

Install via Composer:

```bash
composer require danielemontecchi/laravel-data-patcher
```

Then, run the install command to create the patches table:

```bash
php artisan patch:install
```

---

## Usage

### Creating a Patch

To generate a new patch, use:

```bash
php artisan make:patch PatchName
```

This generates a patch file in the `database/patches` directory with methods `up()`, `down()`, `shouldRun()`, and `__invoke()`.

### Running Patches

Execute all pending patches with:

```bash
php artisan patch
```

Use the `--pretend` option to preview patches without applying:

```bash
php artisan patch --pretend
```

### Rolling Back Patches

Rollback the last applied patch using:

```bash
php artisan patch:rollback
```

Preview rollback with `--pretend`:

```bash
php artisan patch:rollback --pretend
```

---

## Commands Overview

| Command                 | Description                                     |
|-------------------------|-------------------------------------------------|
| `make:patch`            | Generates a new patch class from stub           |
| `patch`                 | Executes all pending patches                    |
| `patch:rollback`        | Rollbacks the last applied patch                |
| `patch:install`         | Creates the necessary patches tracking table    |

---

## Contributing

Contributions are welcome. Please open issues for discussions or submit pull requests for improvements and fixes.

---

## License

Laravel Data Patcher is open-source software licensed under the MIT license.

See [License File](LICENSE.md) for more information.

---

Made with ❤️ by [Daniele Montecchi](https://github.com/danielemontecchi)

