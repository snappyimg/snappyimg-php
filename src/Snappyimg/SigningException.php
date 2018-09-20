<?php

namespace Snappyimg;


final class SigningException extends Exception
{

    public static function create()
    {
        return new self("Failed to compute HMAC");
    }

}
