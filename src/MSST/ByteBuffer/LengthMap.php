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
        'l' => 4,
        'Q' => 8,
        'q' => 8
    );

    public function getLengthFor($format)
    {
        if ($format[0] === 'a') {
            return intval(str_replace('a', '', $format));
        }
        return self::MAP[$format];
    }

}