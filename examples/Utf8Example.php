<?php

require __DIR__ . '/../vendor/autoload.php';

use MSST\ByteBuffer\Buffer;

$text1 = "This is the first utf8 test message. 😄";
$text1Utf8Length = strlen(utf8_encode($text1));

$text2 = "This is the second utf8 test message. 😉";
$text2Utf8Length = strlen(utf8_encode($text2));

echo PHP_EOL;
echo 'Original text 1: ' . $text1 . PHP_EOL;
echo 'Original text 2: ' . $text2 . PHP_EOL;
echo PHP_EOL;

$buffer = new Buffer($text1Utf8Length + $text2Utf8Length);
$buffer->writeUtf8($text1);
$buffer->writeUtf8($text2);

echo "Buffer readUtf8: " . $buffer->readUtf8(0, $text1Utf8Length) . PHP_EOL;
echo "Buffer readUtf8: " . $buffer->readUtf8($text1Utf8Length, $text2Utf8Length) . PHP_EOL;
echo PHP_EOL;
