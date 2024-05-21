---
title: Installation & Setup
sidebar_position: 1.2
---

You can install the package via composer:

```bash
composer require javaabu/helpers
```

## Publishing Language Files

```bash
php artisan vendor:publish --provider="Javaabu\Helpers\HelpersServiceProvider" --tag="helpers-translation-overrides"
```
