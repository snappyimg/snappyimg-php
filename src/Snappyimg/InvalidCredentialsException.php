<?php

namespace Snappyimg;


final class InvalidCredentialsException extends Exception
{

    public static function appToken($appToken)
    {
        return new self("Value '$appToken' is not a valid appToken. You can view your credentials at https://www.snapyimg.com/user/.");
    }

    public static function appSecret($appSecret)
    {
        return new self("Value '$appSecret' is not a valid appSecret. You can view your credentials at https://www.snapyimg.com/user/.");
    }

    public static function stage($stage, $values)
    {
        $strValues = implode("', '", $values);
        return new self("Value '$stage' is invalid for option '$stage', expected one of '$strValues''.");
    }

}
