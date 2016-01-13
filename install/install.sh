#!/bin/bash
cd /var/www
composer self-update

if [ ! -d "/var/www/vendor" ]; then
	composer install
	if [ ! -d "/var/www/storage/framework/views" ]; then
		mkdir /var/www/storage/framework/views
	fi
fi

chmod -R 777 storage
chmod -R 777 bootstrap/cache
composer update
php artisan migrate
php artisan db:seed