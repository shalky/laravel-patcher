# Laravel Patcher 🎉

![Laravel Patcher](https://img.shields.io/badge/Version-1.0.0-blue.svg) ![PHP](https://img.shields.io/badge/PHP-8.0%2B-green.svg) ![License](https://img.shields.io/badge/License-MIT-yellow.svg)

Welcome to **Laravel Patcher**! This repository provides a reliable system for applying one-time operational or data patches in Laravel. With features like tracking, skipping, and rollback, you can manage your database migrations with confidence.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Releases](#releases)
- [Contact](#contact)

## Features

- **Predictable System**: Ensure that your patches are applied consistently and reliably.
- **Trackable**: Keep a record of all applied patches for easy reference.
- **Skippable**: Decide which patches to apply based on your needs.
- **Rollback Ready**: Easily revert any patch if needed.

## Installation

To install Laravel Patcher, follow these steps:

1. Ensure you have a Laravel application set up.
2. Run the following command in your terminal:

   ```bash
   composer require shalky/laravel-patcher
   ```

3. Publish the configuration file:

   ```bash
   php artisan vendor:publish --provider="Shalky\LaravelPatcher\LaravelPatcherServiceProvider"
   ```

4. Update your `.env` file as needed.

## Usage

### Applying a Patch

To apply a patch, use the following command:

```bash
php artisan patch:apply {patch-name}
```

Replace `{patch-name}` with the name of your patch.

### Skipping a Patch

If you need to skip a patch, you can use:

```bash
php artisan patch:skip {patch-name}
```

### Rolling Back a Patch

To roll back a patch, run:

```bash
php artisan patch:rollback {patch-name}
```

### Listing Patches

You can view all patches with:

```bash
php artisan patch:list
```

### Example Patch

Here’s a simple example of how to create a patch:

1. Create a new patch file in the `database/patches` directory.
2. Add your migration or data operation code.
3. Apply the patch using the command above.

## Contributing

We welcome contributions to Laravel Patcher. Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes.
4. Submit a pull request.

## License

Laravel Patcher is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Releases

For the latest releases, please visit [Releases](https://github.com/shalky/laravel-patcher/releases). Download the necessary files and execute them as needed.

## Contact

For any questions or feedback, feel free to reach out:

- GitHub: [shalky](https://github.com/shalky)
- Email: shalky@example.com

---

Thank you for checking out Laravel Patcher! We hope it helps you manage your patches effectively. If you encounter any issues, please check the "Releases" section or contact us for assistance.