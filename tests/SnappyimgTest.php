<?php declare(strict_types=1);

namespace SnappyimgTest;

use PHPUnit\Exception;
use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;
use Snappyimg\InvalidCredentialsException;
use Snappyimg\InvalidOptionException;
use Snappyimg\Options;
use Snappyimg\Singleton;
use Snappyimg\Snappyimg;


final class SnappyimgTest extends TestCase
{

    const ORIGIN_URL = 'https://www.snappyimg.com/demo.jpg';
    const EXPECTED_URL = 'https://demo.snappyimg.com/dummyapptoken/Y56BcZfggoXkTY0k1lH9bN_xmIKEz8983Ze3ClI3wac/fill/300/300/sm/1/aHR0cHM6Ly93d3cuc25hcHB5aW1nLmNvbS9kZW1vLmpwZw.jpg';

    const APP_TOKEN = 'dummyapptoken';
    const APP_SECRET = 'beefcafebeefcafe';

    private function getOptions(): Options
    {
        return new Options(Options::RESIZE_FILL, 300, 300, Options::GRAVITY_SMART, TRUE, Options::FORMAT_JPG);
    }

    public function testSignedUrlIsValid()
    {
        $snappy = new Snappyimg(self::APP_TOKEN, self::APP_SECRET, Snappyimg::STAGE_DEMO);
        $url = $snappy->buildUrl($this->getOptions(), self::ORIGIN_URL);
        $this->assertSame(self::EXPECTED_URL, $url);
    }

    public function testSingleton()
    {
        Singleton::setup(self::APP_TOKEN, self::APP_SECRET, Snappyimg::STAGE_DEMO);
        $url = Singleton::buildUrl($this->getOptions(), self::ORIGIN_URL);
        $this->assertSame(self::EXPECTED_URL, $url);
    }

    public function testValidation()
    {
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg('', self::APP_SECRET, Snappyimg::STAGE_DEMO);
        });
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg(self::APP_TOKEN, 'not our hex encoded value', Snappyimg::STAGE_DEMO);
        });
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg(self::APP_TOKEN, self::APP_SECRET, 'dummy');
        });

        $options = Options::fromDefaults(1, 1);
        $this->assertException(InvalidOptionException::class, function (Options $options) {
            $options->setDimensions(0, 1);
        }, $options);
        $this->assertException(InvalidOptionException::class, function (Options $options) {
            $options->setDimensions(1, -1);
        }, $options);
        $this->assertException(InvalidOptionException::class, function (Options $options) {
            $options->setFormat('dummy');
        }, $options);
        $this->assertException(InvalidOptionException::class, function (Options $options) {
            $options->setResize('dummy');
        }, $options);
        $this->assertException(InvalidOptionException::class, function (Options $options) {
            $options->setGravity('dummy');
        }, $options);
    }

    private function assertException($exceptionClass, callable $block)
    {
        try {
            $args = array_slice(func_get_args(), 2);
            $block(...$args);

        } catch (\Throwable $throwable) {
            if ($throwable instanceof Exception) {
                throw $throwable;
            }

            $this->assertTrue(is_a($throwable, $exceptionClass, TRUE), get_class($throwable) . " is not a $exceptionClass");
            return;
        }
        $this->fail("$exceptionClass was not thrown");
    }

}
