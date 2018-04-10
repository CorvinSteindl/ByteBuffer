<?php

require __DIR__ . '/../vendor/autoload.php';

use MSST\ByteBuffer\Buffer;

$text = "This is an utf8 test message. 😄";
$textUtf8Length = strlen(utf8_encode($text));

echo PHP_EOL . "Original text: " . $text . PHP_EOL . PHP_EOL;

$buffer = new Buffer($textUtf8Length);
$buffer->writeUtf8($text);

echo "Buffer length: " . $buffer->length() . PHP_EOL;
echo "Buffer readUtf8: " . $buffer->readUtf8(0, $textUtf8Length) . PHP_EOL . PHP_EOL;
