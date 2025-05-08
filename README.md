# Laravel Patcher

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielemontecchi/laravel-patcher.svg?style=flat-square)](https://packagist.org/packages/danielemontecchi/laravel-patcher)
[![Total Downloads](https://img.shields.io/packagist/dt/danielemontecchi/laravel-patcher.svg?style=flat-square)](https://packagist.org/packages/danielemontecchi/laravel-patcher)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/danielemontecchi/laravel-patcher/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/danielemontecchi/laravel-patcher/actions/workflows/tests.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=danielemontecchi_laravel-patcher&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=danielemontecchi_laravel-patcher)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)
[![Documentation](https://img.shields.io/badge/docs-available-brightgreen.svg?style=flat-square)](https://danielemontecchi.github.io/laravel-patcher)

**Laravel Patcher** is a package that allows you to define and execute patch classes — small, versioned units of logic meant to run once. Patches can be used for anything: updating data, modifying files, clearing caches, running jobs, fixing logic issues after deployment, and more.

Inspired by [Taylor Otwell’s patching concept](https://x.com/taylorotwell/status/1387766514674192384?s=46), this package formalizes that idea into a reliable, testable, and traceable tool.

---

## Installation

Install via Composer:

```bash
composer require danielemontecchi/laravel-patcher
```

Then, run the install command to create the patches tracking table:

```bash
php artisan patcher:install
```

---

## What can you use patches for?

Patches are ideal for any one-time execution logic, such as:

- Transforming or fixing **database records**
- Running **filesystem cleanup**
- Executing **jobs**, events, or listeners
- Calling **external APIs** or webhooks
- Clearing or regenerating **application caches**
- Hotfixing **business logic** post-release
- Updating values in `.env`, config files, or external services

You decide what goes in a patch. It’s like a migration — but for **everything else**.

---

## Usage

### Creating a Patch

```bash
php artisan make:patch FixUserEmails
```

This generates a new patch file under `database/patches/`, timestamped and containing the following methods:

### Patch Class Structure

```php
public function up(): void
```
Logic to apply the patch (data, logic, file operations, etc.).

```php
public function down(): void
```
Logic to reverse the patch.

```php
public function shouldRun(): bool
```
Determines if the patch should run. Defaults to `true`. You can override it for conditional logic.

```php
public function __invoke(): void
```
Runs the patch by calling `up()` only if `shouldRun()` returns `true`. You should never call `up()` directly — always invoke the class.

#### Example

```php
<?php

namespace Database\Patches;

use DanieleMontecchi\LaravelPatcher\Contracts\Patch;
use App\Models\User;

class FixUserEmails implements Patch
{
    public function up(): void
    {
        User::query()->whereNull('email')->update(['email' => 'default@example.com']);
    }

    public function down(): void
    {
        User::query()->where('email', 'default@example.com')->update(['email' => null]);
    }

    public function shouldRun(): bool
    {
        return User::whereNull('email')->exists();
    }

    public function __invoke(): void
    {
        if ($this->shouldRun()) {
            $this->up();
        }
    }
}
```

---

## Running Patches

```bash
php artisan patcher:run
```
Runs all unapplied patches in chronological order.

```bash
php artisan patcher:run --pretend
```
Previews which patches would be applied.

---

## Rolling Back

```bash
php artisan patcher:rollback
```
Rolls back the last applied patch (calls `down()` and removes it from the table).

```bash
php artisan patcher:rollback --pretend
```
Previews which patch would be rolled back.

---

## Artisan Commands

| Command            | Description                                       |
|--------------------|---------------------------------------------------|
| `make:patch`       | Generates a new patch class from stub             |
| `patcher:run`      | Executes all pending patches                      |
| `patcher:rollback` | Rolls back the last applied patch                 |
| `patcher:install`  | Creates the `patches` tracking table              |

---

## Best Practices

- Use patches for **production-safe**, **idempotent**, or **conditional** logic.
- Never assume a patch will be run only once — use `shouldRun()` as a guard.
- Don’t use patches for schema changes — use migrations for that.
- Group patches logically and keep them versioned in source control.

---

## Contributing

If you find a bug or want to improve this package, feel free to open an issue or submit a PR. Feedback and contributions are welcome.

---

## License

Laravel Patcher is open-source software licensed under the [MIT license](LICENSE.md).
