<?php declare(strict_types=1);

namespace Snappyimg;


final class Singleton
{

    /**
     * @var Snappyimg
     */
    static $snappyimg;

    /**
     * @param string $appToken
     * @param string $appSecret
     * @param string $stage
     * @return void
     */
    public static function setup($appToken, $appSecret, $stage)
    {
        self::$snappyimg = new Snappyimg($appToken, $appSecret, $stage);
    }

    public static function buildUrl(Options $options, $originUrl): string
    {
        return self::$snappyimg->buildUrl($options, $originUrl);
    }

}
