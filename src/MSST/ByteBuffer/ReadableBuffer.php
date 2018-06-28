<?php

namespace MSST\ByteBuffer;

interface ReadableBuffer {
	public function read($offset, $length);
	public function readUtf8($offset, $length);

	public function readUInt8($offset);
	public function readInt8($offset);

	public function readUInt16BE($offset);
	public function readUInt16LE($offset);
    public function readUInt16($offset);
    public function readInt16($offset);

	public function readUInt32BE($offset);
	public function readUInt32LE($offset);
    public function readUInt32($offset);
    public function readInt32($offset);

    public function readUInt64($offset);
    public function readInt64($offset);

    public function readDouble($offset);
    public function readFloat($offset);
}