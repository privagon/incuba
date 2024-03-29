# Incuba - Flexible data harvester for distributed workloads.

[![Tests](https://github.com/felixdorn/incuba/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/felixdorn/incuba/actions/workflows/tests.yml)
[![Formats](https://github.com/felixdorn/incuba/actions/workflows/formats.yml/badge.svg?branch=main)](https://github.com/felixdorn/incuba/actions/workflows/formats.yml)
[![Version](https://poser.pugx.org/felixdorn/incuba/version)](//packagist.org/packages/felixdorn/incuba)
[![Total Downloads](https://poser.pugx.org/felixdorn/incuba/downloads)](//packagist.org/packages/felixdorn/incuba)
[![License](https://poser.pugx.org/felixdorn/incuba/license)](//packagist.org/packages/felixdorn/incuba)

## Installation

> Requires [PHP 8.3+](https://php.net/releases)

You can install the package via composer:

```bash
composer require privagon/incuba
```

## Usage

// Usage goes here

### Distributing load

Incuba can optionally distribute load for speed accross multiple execution environments using a single-instance Redis.
If correctness is
also important (e.g. if you are heavily rate-limited), it is possible to integrate Incuba with Postgres or even
ZooKeeper for better distributed locking.

## Testing

```bash
composer test
```

**Incuba** was created by **[Félix Dorn](https://felixdorn.fr)** under the *
*[MIT license](https://opensource.org/licenses/MIT)**.
