# Zerotoprod\Filesystem

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/filesystem)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/filesystem/test.yml?label=test)](https://github.com/zero-to-prod/filesystem/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/filesystem/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/filesystem/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/filesystem?color=blue)](https://packagist.org/packages/zero-to-prod/filesystem/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/filesystem.svg?color=purple)](https://packagist.org/packages/zero-to-prod/filesystem/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/filesystem?color=f28d1a)](https://packagist.org/packages/zero-to-prod/filesystem)
[![License](https://img.shields.io/packagist/l/zero-to-prod/filesystem?color=pink)](https://github.com/zero-to-prod/filesystem/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/filesystem.svg)](https://wakatime.com/badge/github/zero-to-prod/filesystem)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/filesystem?branch=main)](https://hitsofcode.com/github/zero-to-prod/filesystem/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Usage](#usage)
    - [getFilesByExtension()](#getFilesByExtension)
    - [getFilesByExtensionRecursive()](#getFilesByExtensionRecursive)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

Helpers for interacting with a filesystem.

## Requirements

- PHP 7.1 or higher.

## Installation

Install `Zerotoprod\Filesystem` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/filesystem
```

This will add the package to your project's dependencies and create an autoloader entry for it.

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/filesystem)
vendor/bin/zero-to-prod-filesystem

# Publish to custom directory
vendor/bin/zero-to-prod-filesystem /path/to/your/docs
```

### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
    "scripts": {
        "post-install-cmd": [
            "zero-to-prod-filesystem"
        ],
        "post-update-cmd": [
            "zero-to-prod-filesystem"
        ]
    }
}
```

## Usage

### getFilesByExtension()

Return all files by extension in a directory.

```php
use Zerotoprod\Filesystem\Filesystem;

$files = Filesystem::getFilesByExtension('dir', 'php')
```

### getFilesByExtensionRecursive()

Return all files by extension in a directory recursively.

```php
use Zerotoprod\Filesystem\Filesystem;

$files = Filesystem::getFilesByExtensionRecursive('dir', 'php')
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/filesystem/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.
