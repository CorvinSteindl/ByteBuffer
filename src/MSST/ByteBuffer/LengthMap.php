<?php

namespace MSST\ByteBuffer;

/**
 * LengthMap
 */
class LengthMap
{

    const MAP = array(
        'n' => 2,
        'N' => 4,
        'v' => 2,
        'V' => 4,
        'c' => 1,
        'C' => 1,
        's' => 2,
        'S' => 2,
        'L' => 4,
        'l' => 4,
        'Q' => 8,
        'q' => 8,
        'd' => 8,
        'f' => 4,
    );

    public function getLengthFor($format)
    {
        if (in_array($format[0], ['a', 'd', 'f'])) {
            return intval(str_replace($format[0], '', $format));
        }
        return self::MAP[$format];
    }

}