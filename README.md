# In2it Training Course PHPUnit

This training course is designed to learn you becoming a better developer by testing the PHP code you produce or have to maintain.

## Requirements

You're required to have a working development environment with the following items installed:

- PHP 5.4 or higher (with XDebug extension enabled)
- GIT

## Installation

The installation is straight forward as all sources are available on GitHub

On your commandline issue the following command:

    git clone git@github.com:in2it/phpunit-training.git

This will download the source code to work with. Enter the project's directory

    cd phpunit-training

Next step is to get "composer" to install required tools

    curl -sS https://getcomposer.org/installer | php

This will create a `composer.phar` file which you can use to install and update this project

    php composer.phar install

Once installation is completed, you should now be able to execute `phpunit`

    ./vendor/bin/phpunit --version

This should display the following:

    PHPUnit 4.8.18 by Sebastian Bergmann and contributors.

You're ready for the training.