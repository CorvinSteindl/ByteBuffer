<?php

namespace MSST\ByteBuffer;

interface ReadableBuffer {
	public function read($start, $end);
	public function readInt8($offset);
	public function readInt16BE($offset);
	public function readInt16LE($offset);
	public function readInt32BE($offset);
	public function readInt32LE($offset);
    public function readInt32($offset);
    public function readUInt64($offset);
    public function readInt64($offset);
}