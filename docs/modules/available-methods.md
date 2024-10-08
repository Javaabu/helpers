---
title: Available Helper Methods
sidebar_position: 2
---

This package provides the following helper methods:

## seconds_to_human_readable

Given a number of seconds, returns the seconds formatted to a humanreadable string

```php
$formatted = seconds_to_human_readable(37949415); // 1 year 2 months 14 days 5 hours 30 minutes 15 seconds
```

You can abbreviate the returned string by setting the second argument to `true`.

```php
$formatted = seconds_to_human_readable(37949415, true); // 1 year 2 months 14 days 5 hrs 30 mins 15 secs
```

If you want to ommit any units that are 0 valued, you can set the 3rd argument to `false`.

```php
$formatted = seconds_to_human_readable(37931415, false, false); // 1 year 2 months 14 days 30 minutes 15 seconds
```

## number_format_exact

Formats the given number while keeping the decimal part intact

```php
$formatted = number_format_exact(1120.5); // '1,120.5'
$formatted = number_format_exact('1120.50'); // '1,120.50'
$formatted = number_format_exact('1120.500'); // '1,120.500'
$formatted = number_format_exact('1120.500', max_decimals: 2); // '1,120.50'
$formatted = number_format_exact('1120.500', max_decimals: 0); // '1,120.5'
$formatted = number_format_exact('1120.000', max_decimals: 0); // '1,120'
```
