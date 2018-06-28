<?php

namespace MSST\ByteBuffer;

/**
 * ByteBuffer
 */
class Buffer extends AbstractBuffer
{
    const DEFAULT_FORMAT = 'x';

    /**
     * @var \SplFixedArray
     */
    protected $buffer;

    /**
     * @var LengthMap
     */
    protected $lengthMap;

    /**
     * @var int
     */
    protected $offsetCounter;

    /**
     * @param string|int $bufferSize The size of the buffer
     */
    public function __construct($bufferSize)
    {
        $this->offsetCounter = 0;
        $this->lengthMap = new LengthMap();
        if (is_string($bufferSize)) {
            $this->initializeStructs(strlen($bufferSize), $bufferSize);
        } else if (is_int($bufferSize)) {
            $this->initializeStructs($bufferSize, pack(self::DEFAULT_FORMAT . $bufferSize));
        } else {
            throw new \InvalidArgumentException('Constructor argument must be an binary string or integer.');
        }
    }

    /**
     * @param $length
     * @param $content
     */
    protected function initializeStructs($length, $content)
    {
        $this->buffer = new \SplFixedArray($length);
        for ($i = 0; $i < $length; $i++) {
            $this->buffer[$i] = $content[$i];
        }
    }

    /**
     * @param $offsetCounter
     */
    protected function setOffsetCounter($offsetCounter)
    {
        $this->offsetCounter = $offsetCounter;
    }

    /**
     * @return int
     */
    protected function getOffsetCounter()
    {
        return $this->offsetCounter;
    }

    /**
     * @param $format
     * @param $value
     */
    protected function insert($format, $value)
    {
        $offset = $this->getOffsetCounter();

        $bytes = pack($format, $value);
        for ($i = 0; $i < strlen($bytes); $i++) {
            $this->buffer[$offset++] = $bytes[$i];
        }

        $this->offsetCounter += $this->lengthMap->getLengthFor($format);
    }

    /**
     * @param $format
     * @param $offset
     * @param $length
     * @return int
     */
    protected function extract($format, $offset, $length)
    {
        $encoded = '';
        for ($i = 0; $i < $length; $i++) {
            $encoded .= $this->buffer->offsetGet($offset + $i);
        }
        if ($format == 'N' && PHP_INT_SIZE <= 4) {
            list(, $h, $l) = unpack('n*', $encoded);
            $result = ($l + ($h * 0x010000));
        } else if ($format == 'V' && PHP_INT_SIZE <= 4) {
            list(, $h, $l) = unpack('v*', $encoded);
            $result = ($h + ($l * 0x010000));
        } else {
            list(, $result) = unpack($format, $encoded);
        }
        return $result;
    }

    /**
     * @param $expectedMax
     * @param $actual
     */
    protected function checkForOverSize($expectedMax, $actual)
    {
        if ($actual > $expectedMax) {
            throw new \InvalidArgumentException(sprintf('%d exceeded limit of %d', $actual, $expectedMax));
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $buf = '';
        foreach ($this->buffer as $bytes) {
            $buf .= $bytes;
        }
        return $buf;
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->buffer->getSize();
    }

    /**
     * @param $string
     */
    public function write($string)
    {
        $length = strlen($string);
        $this->insert('a' . $length, $string);
    }

    /**
     * @param $string
     */
    public function writeUtf8($string)
    {
        $string = utf8_encode($string);
        $length = strlen($string);
        $this->insert('a' . $length, $string);
    }

    /**
     * @param $value
     */
    public function writeUInt8($value)
    {
        $format = 'C';
        $this->checkForOverSize(0xff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt8($value)
    {
        $format = 'c';
        $this->checkForOverSize(0xff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeUInt16($value)
    {
        $format = 's';
        $this->checkForOverSize(0xffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt16($value)
    {
        $format = 'S';
        $this->checkForOverSize(0xffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt16BE($value)
    {
        $format = 'n';
        $this->checkForOverSize(0xffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt16LE($value)
    {
        $format = 'v';
        $this->checkForOverSize(0xffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     * @param null $offset
     */
    public function writeInt32BE($value)
    {
        $format = 'N';
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt32LE($value)
    {
        $format = 'V';
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeUInt32($value)
    {
        $format = 'L';
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt32($value)
    {
        $format = 'l';
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeUInt64($value)
    {
        $format = 'Q';
        $this->checkForOverSize(0xffffffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeInt64($value)
    {
        $format = 'q';
        $this->checkForOverSize(0xffffffffffff, $value);
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeDouble($value)
    {
        $format = 'd';
        $this->insert($format, $value);
    }

    /**
     * @param $value
     */
    public function writeFloat($value)
    {
        $format = 'f';
        $this->insert($format, $value);
    }

    /**
     * @param $offset
     * @param $length
     * @return int
     */
    public function read($offset, $length)
    {
        $format = 'a' . $length;
        return $this->extract($format, $offset, $length);
    }

    /**
     * @param $offset
     * @param $length
     * @return string
     */
    public function readUtf8($offset, $length)
    {
        $format = 'a' . $length;
        return utf8_decode($this->extract($format, $offset, $length));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readUInt8($offset)
    {
        $format = 'C';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt8($offset)
    {
        $format = 'c';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt16($offset)
    {
        $format = 'S';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt16BE($offset)
    {
        $format = 'n';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt16LE($offset)
    {
        $format = 'v';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt32BE($offset)
    {
        $format = 'N';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt32LE($offset)
    {
        $format = 'V';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readUInt32($offset)
    {
        $format = 'L';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt32($offset)
    {
        $format = 'l';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readUInt64($offset)
    {
        $format = 'Q';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return int
     */
    public function readInt64($offset)
    {
        $format = 'q';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return double
     */
    public function readDouble($offset)
    {
        $format = 'd';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }

    /**
     * @param $offset
     * @return float
     */
    public function readFloat($offset)
    {
        $format = 'f';
        return $this->extract($format, $offset, $this->lengthMap->getLengthFor($format));
    }
}