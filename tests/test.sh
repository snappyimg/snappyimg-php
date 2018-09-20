#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_DIR="$(dirname "$DIR")"

cd "$ROOT_DIR"

PHP_VERSION="$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')"
if [[ "$PHP_VERSION" == "7.0" ]]; then
    sed -i'' 's/.*phpstan\/phpstan.*//g' composer.json
fi

composer install
if [[ "$PHP_VERSION" == "7.0" ]]; then
    echo "Unsuported PHP version, phpstan not run"
else
    ./vendor/bin/phpstan analyse src tests --level=7
fi
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
