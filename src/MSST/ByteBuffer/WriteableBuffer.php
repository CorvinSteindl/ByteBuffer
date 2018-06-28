<?php

namespace MSST\ByteBuffer;

interface WriteableBuffer {
	public function write($string);
	public function writeUtf8($string);

	public function writeUInt8($value);
	public function writeInt8($value);

	public function writeUInt16BE($value);
	public function writeUInt16LE($value);
	public function writeUInt16($value);
	public function writeInt16($value);

	public function writeUInt32BE($value);
	public function writeUInt32LE($value);
	public function writeUInt32($value);
	public function writeInt32($value);

    public function writeUInt64($value);
    public function writeInt64($value);

    public function writeDouble($value);
    public function writeFloat($value);
}
