<?php declare(strict_types=1);

namespace Snappyimg;


final class InvalidOptionException extends Exception
{

    public static function resize($resize, $values)
    {
        $strValues = implode("', '", $values);
        return new self("Value '$resize' is invalid for option 'resize', expected one of '$strValues''.");
    }

    public static function gravity($gravity, $values)
    {
        $strValues = implode("', '", $values);
        return new self("Value '$gravity' is invalid for option 'gravity', expected one of '$strValues''.");
    }

    public static function format($format, $values)
    {
        $strValues = implode("', '", $values);
        return new self("Value '$format' is invalid for option 'format', expected one of '$strValues''.");
    }

    public static function width($width)
    {
        return new self("Value '$width' is invalid for option 'width', expected non-zero positive integer.");
    }

    public static function height($height)
    {
        return new self("Value '$height' is invalid for option 'height', expected non-zero positive integer.");
    }

}
