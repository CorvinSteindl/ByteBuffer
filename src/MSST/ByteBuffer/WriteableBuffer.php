<?php

namespace MSST\ByteBuffer;

interface WriteableBuffer {
	public function write($string);
	public function writeUtf8($string);
	public function writeInt8($value);
	public function writeInt16BE($value);
	public function writeInt16LE($value);
	public function writeInt32BE($value);
	public function writeInt32LE($value);
	public function writeInt32($value);
    public function writeUInt64($value);
    public function writeInt64($value);
}
