#!/bin/bash
set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
NORMAL='\033[0m'

error() {
    echo -e "[${RED}ERROR${NORMAL}]: $*"
}
info() {
    echo -e "[${GREEN}INFO${NORMAL}]: $*"
}

check_environment() {
    set +e
    if command -v php > /dev/null 2>&1; then
        info Found PHP.
    else
        error Missing PHP.
    fi

    if [ -e bin ]; then
        info Running from project root.
    else
        error Run me from the project root.
    fi
    set -e
}

install_composer() {
    if [ -e composer.phar ]; then
        info composer.phar already installed
    else
        info installing composer.phar
        curl -sS https://getcomposer.org/installer -o /tmp/composer_installer
        php /tmp/composer_installer
    fi
}

install_symfony_command() {
    if [ -e bin/symfony ]; then
        info symfony command already installed.
    else
        info installing symfony command.
        curl -LsS http://symfony.com/installer -o bin/symfony
    fi
}

bootstrap() {
    check_environment

    install_composer
    install_symfony_command

    info 'Good to go!'
}

bootstrap "$@"

