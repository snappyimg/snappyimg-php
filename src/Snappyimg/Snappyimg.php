<?php

namespace Snappyimg;


final class Snappyimg
{

    const STAGE_DEMO = 'demo';
    const STAGE_SERVE = 'serve';

    /** @var string */
    private $appToken;
    /** @var string */
    private $appSecretBin;
    /** @var string */
    private $stage;

    /**
     * @param string $appToken
     * @param string $appSecret
     * @param string $stage
     * @throws InvalidCredentialsException
     */
    public function __construct($appToken, $appSecret, $stage)
    {
        $this->appToken = (string) $appToken;
        if ($this->appToken === '') {
            throw InvalidCredentialsException::appToken($appToken);
        }

        $this->appSecretBin = pack("H*" , $appSecret);
        if ($this->appSecretBin === '') {
            throw InvalidCredentialsException::appSecret($appSecret);
        }

        $this->stage = $stage;
        $stages = [self::STAGE_DEMO, self::STAGE_SERVE];
        if (!in_array($stage, $stages, TRUE)) {
            throw InvalidCredentialsException::stage($stage, $stages);
        }
    }


    /**
     * @param Options $options
     * @param $originUrl
     * @return string URL
     * @throws SigningException
     */
    public function buildUrl(Options $options, $originUrl): string
    {
        $path = sprintf("%s/%d/%d/%s/%d/%s.%s",
            $options->getResize(),
            $options->getWidth(),
            $options->getHeight(),
            $options->getGravity(),
            $options->getEnlarge(),
            self::base64($originUrl),
            $options->getFormat()
        );

        $hmac = hash_hmac('sha256', $path, $this->appSecretBin, TRUE);
        if ($hmac === FALSE || $hmac === '') {
            throw SigningException::create();
        }

        $signature = self::base64($hmac);
        return "https://{$this->stage}.snappyimg.com/{$this->appToken}/$signature/$path";
    }


    /**
     * @param string $string
     * @return string
     */
    private static function base64($string): string
    {
        return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
    }

}