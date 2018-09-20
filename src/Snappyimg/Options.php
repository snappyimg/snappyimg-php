<?php declare(strict_types=1);

namespace Snappyimg;


final class Options
{

    const RESIZE_FILL = 'fill';
    const RESIZE_FIT = 'fit';
    const RESIZE_CROP = 'crop';

    const GRAVITY_SMART = 'sm';
    const GRAVITY_CENTER = 'ce';
    const GRAVITY_LEFT_EDGE = 'we';
    const GRAVITY_TOP_EDGE = 'no';
    const GRAVITY_RIGHT_EDGE = 'ea';
    const GRAVITY_BOTTOM_EDGE = 'so';

    const FORMAT_PNG = 'png';
    const FORMAT_JPG = 'jpg';
    const FORMAT_WEBP = 'webp';

    /** @var string */
    private $resize;
    /** @var int */
    private $width;
    /** @var int */
    private $height;
    /** @var string */
    private $gravity;
    /** @var bool */
    private $enlarge;
    /** @var string */
    private $format;

    /**
     * @param string $resize
     * @param int $width
     * @param int $height
     * @param string $gravity
     * @param bool $enlarge
     * @param string $format
     * @throws InvalidOptionException
     */
    public function __construct($resize, $width, $height, $gravity, $enlarge, $format)
    {
        $this->setResize($resize);
        $this->setDimensions($width, $height);
        $this->setGravity($gravity);
        $this->setEnlarge($enlarge);
        $this->setFormat($format);
    }


    /**
     * @param int $width
     * @param int $height
     * @throws InvalidOptionException
     */
    public static function fromDefaults($width, $height): self
    {
        return new self(self::RESIZE_FILL, $width, $height, self::GRAVITY_SMART, TRUE, self::FORMAT_JPG);
    }


    /**
     * @param string $resize
     * @throws InvalidOptionException
     */
    public function setResize($resize): self
    {
        $allowed = [self::RESIZE_FILL, self::RESIZE_FIT, self::RESIZE_CROP];
        if (!in_array($resize, $allowed, TRUE)) {
            throw InvalidOptionException::resize($resize, $allowed);
        }
        $this->resize = $resize;

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @throws InvalidOptionException
     */
    public function setDimensions($width, $height): self
    {
        if ($width <= 0) {
            throw InvalidOptionException::width($width);
        }
        if ($height <= 0) {
            throw InvalidOptionException::height($width);
        }

        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * @param string $gravity
     * @throws InvalidOptionException
     */
    public function setGravity($gravity): self
    {
        $allowed = [self::GRAVITY_SMART, self::GRAVITY_CENTER, self::GRAVITY_LEFT_EDGE, self::GRAVITY_TOP_EDGE, self::GRAVITY_RIGHT_EDGE, self::GRAVITY_BOTTOM_EDGE];
        if (!in_array($gravity, $allowed, TRUE)) {
            throw InvalidOptionException::gravity($gravity, $allowed);
        }
        $this->gravity = $gravity;

        return $this;
    }

    /**
     * @param string $format
     * @throws InvalidOptionException
     */
    public function setFormat($format): self
    {
        $allowed = [self::FORMAT_JPG, self::FORMAT_PNG, self::FORMAT_WEBP];
        if (!in_array($format, $allowed, TRUE)) {
            throw InvalidOptionException::format($format, $allowed);
        }
        $this->format = $format;

        return $this;
    }

    /**
     * @param bool $enlarge
     */
    public function setEnlarge($enlarge): self
    {
        $this->enlarge = $enlarge;
        return $this;
    }

    public function getResize(): string
    {
        return $this->resize;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function getEnlarge(): bool
    {
        return $this->enlarge;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

}
