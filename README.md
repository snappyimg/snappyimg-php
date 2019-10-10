<img src="./logo.png" width="400">

[![Build Status](https://travis-ci.org/snappyimg/snappyimg-php.svg?branch=master)](https://travis-ci.org/snappyimg/snappyimg-php)

This is a PHP implementation of Snappyimg URL builder. For more information about the service, go to [https://www.snappyimg.com/](https://www.snappyimg.com/).

### Installation

This library is available as [Composer package](https://packagist.org/packages/snappyimg/snappyimg-php):

```console
$ composer require snappyimg/snappyimg-php
```


### Demo

Processed original image
`https://www.snappyimg.com/demo.jpg`
into 640×360:
`https://serve.snappyimg.com/snappyimg/pvvJK7Di3E1Fjetx9viameQMNo0LjHcM2rUh8v10En0/fit/640/360/ce/1/aHR0cHM6Ly93d3cuc25hcHB5aW1nLmNvbS9kZW1vLmpwZw.jpg`

<img src="https://serve.snappyimg.com/snappyimg/pvvJK7Di3E1Fjetx9viameQMNo0LjHcM2rUh8v10En0/fit/640/360/ce/1/aHR0cHM6Ly93d3cuc25hcHB5aW1nLmNvbS9kZW1vLmpwZw.jpg" width=180>

### Example usage

```php
$snappy = new Snappyimg($appToken, $appSecret, Snappyimg::STAGE_DEMO);

$options = Options::fromDefaults(360, 420);
$url = $snappy->buildUrl($options, 'https://www.snappyimg.com/demo.jpg');
```

Where `$appToken` and `$appSecret` are generated for you when you register at [snappyimg.com](https://www.snappyimg.com/).

```html
<img alt="Snappyimg Example" src="{{$url}}">
```

While `STAGE_DEMO` is available for free for all users, you will need a [subscription](https://www.snappyimg.com/pricing) to use `STAGE_SERVE`.


### Additional options

The `Options` class lets you specify exactly how the image should be processed.

```php
$options = Options::fromDefaults(360, 420)
    ->setResize(Options::RESIZE_FIT)
    ->setGravity(Options::GRAVITY_SMART)
    ->setEnlarge(FALSE)
    ->setFormat(Options::FORMAT_WEBP);
```

The options themselves are explained at [Documentation](https://www.snappyimg.com/docs) and at each method. 
