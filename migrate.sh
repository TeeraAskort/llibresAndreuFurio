#!/usr/bin/env bash

php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:schema:update --force 