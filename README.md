# PHP Library for reading and writing binary data

This is a improved rewrite of the [Project from OleMchls](https://github.com/OleMchls/ByteBuffer)
You can also call this a [pack()](http://www.php.net/manual/en/function.pack.php) wrapper.

## Additional Features
- Autoincrement Offset
- Write Int32, Int64, UInt64 and UTF8 Strings
## Install

Installation should be done via [composer](http://packagist.org/).

```
composer require msst/byte-buffer
```
Or
```
{
    "require": {
        "msst/byte-buffer": "dev-master"
    }
}
```

## Example

A simple usage example could look like this

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use MSST\ByteBuffer\Buffer;

$text1 = 'channel_one';
$text2 = "This is a utf8 test message. 😄";

$buffer = new Buffer(4 + 1 + 4 + strlen($text1) + strlen($text2));
$buffer->writeInt32($buffer->length());
$buffer->writeInt8(0x1);
$buffer->writeInt32(strlen($text1));
$buffer->write($text1);
$buffer->writeUtf8($text2);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$result = socket_connect($socket, '127.0.0.1', 3542);

socket_write($socket, (string) $buffer, $buffer->length());
```

## Testing

```
./vendor/bin/phpunit
```


## License

Licensed under the MIT license.

Original Project: [ByteBuffer](https://github.com/OleMchls/ByteBuffer) by [OleMchls](https://github.com/OleMchls/)
