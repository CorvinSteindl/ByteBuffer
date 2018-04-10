<?php

use MSST\ByteBuffer\Buffer;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Corvin Steindl
 * Date: 10.04.18
 * Time: 16:58
 */

class ReadWriteBufferTest extends TestCase
{
    public function testWriteAndReadUTF8Buffer()
    {
        $text1 = "This is the first utf8 test message. 😄 cba";
        $text1Utf8Length = strlen(utf8_encode($text1));

        $text2 = "This is the second utf8 test message. 😉 abc";
        $text2Utf8Length = strlen(utf8_encode($text2));

        $buffer = new Buffer($text1Utf8Length + $text2Utf8Length);
        $buffer->writeUtf8($text1);
        $buffer->writeUtf8($text2);

        /* Export to String */
        $byteString = (string) $buffer;

        $readBuffer = new Buffer($byteString);

        $this->assertEquals($text1, $readBuffer->readUtf8(0, $text1Utf8Length));
        $this->assertEquals($text2, $readBuffer->readUtf8($text1Utf8Length, $text2Utf8Length));

    }
}