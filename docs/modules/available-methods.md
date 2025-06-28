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

## youtube_video_id

Extracts the video id from YouTube URLs.

```php
$video_id = youtube_video_id('https://www.youtube.com/watch?v=p7P8DmTbjUY'); // 'p7P8DmTbjUY'
```

## youtube_embed_url

Generates the YouTube embed URL from a YouTube link

```php
$embed_url = youtube_embed_url('https://www.youtube.com/watch?v=p7P8DmTbjUY'); // 'https://www.youtube.com/embed/p7P8DmTbjUY'
```

## youtube_thumbnail_url

Finds the YouTube thumbnail URL from a YouTube link. Supports `'sd'`, `'mq'`, `'hq'`, and `'max'` as the second argument to get image in different sizes. The default is `'max'`. 

```php
$thumbnail = youtube_thumbnail_url('https://www.youtube.com/watch?v=p7P8DmTbjUY'); // 'https://img.youtube.com/vi/p7P8DmTbjUY/maxresdefault.jpg'
$thumbnail = youtube_thumbnail_url('https://www.youtube.com/watch?v=p7P8DmTbjUY', 'hq'); // 'https://img.youtube.com/vi/p7P8DmTbjUY/hqdefault.jpg'
```

## google_drive_file_id

Extracts the file id from Google Drive URLs.

```php
$file_id = google_drive_file_id('https://drive.google.com/file/d/13YYH0OlibUYzT2q7uRPOQotbE03rdsDr/view?usp=drive_link'); // '13YYH0OlibUYzT2q7uRPOQotbE03rdsDr'
```

## google_drive_embed_url

Generates a Google Drive embed URL from a file link

```php
$embed_url = google_drive_embed_url('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'); // 'https://docs.google.com/viewer?embedded=true&url=https%3A%2F%2Fwww.w3.org%2FWAI%2FER%2Ftests%2Fxhtml%2Ftestfiles%2Fresources%2Fpdf%2Fdummy.pdf'
$embed_url = google_drive_embed_url('https://drive.google.com/file/d/13YYH0OlibUYzT2q7uRPOQotbE03rdsDr/view?usp=drive_link'); // 'https://drive.google.com/file/d/13YYH0OlibUYzT2q7uRPOQotbE03rdsDr/preview'
```
