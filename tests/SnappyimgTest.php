<?php declare(strict_types=1);

namespace SnappyimgTest;

use PHPUnit\Exception;
use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;
use Snappyimg\InvalidCredentialsException;
use Snappyimg\InvalidOptionException;
use Snappyimg\Options;
use Snappyimg\Snappyimg;


final class SnappyimgTest extends TestCase
{

    public function testSignedUrlIsValid()
    {
        $originUrl = 'https://www.snappyimg.com/demo.jpg';

        $options = new Options(Options::RESIZE_FILL, 300, 300, Options::GRAVITY_SMART, TRUE, Options::FORMAT_JPG);

        $snappy = new Snappyimg('dummyappid', 'beefcafebeefcafe', Snappyimg::STAGE_DEMO);
        $url = $snappy->buildUrl($options, $originUrl);

        $expected = 'https://demo.snappyimg.com/dummyappid/Y56BcZfggoXkTY0k1lH9bN_xmIKEz8983Ze3ClI3wac/fill/300/300/sm/1/aHR0cHM6Ly93d3cuc25hcHB5aW1nLmNvbS9kZW1vLmpwZw.jpg';
        $this->assertSame($expected, $url);
    }

    public function testValidation()
    {
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg('', 'beefcafebeefcafe', Snappyimg::STAGE_DEMO);
        });
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg('dummyappid', 'not our hex encoded value', Snappyimg::STAGE_DEMO);
        });
        $this->assertException(InvalidCredentialsException::class, function () {
            new Snappyimg('dummyappid', 'beefcafebeefcafe', 'dummy');
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
