#!/bin/bash

# Install LAMP server
apt-get install lamp-server^

# Install Composer
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '41e71d86b40f28e771d4bb662b997f79625196afcca95a5abf44391188c695c6c1456e16154c75a211d238cc3bc5cb47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

# Install NPM
apt-get install npm
npm install -g gulp
npm install -g laravel-elixir

# Move to the web directory
cd /var/www

# Remove default apache homepage
rm index.html

# Install the application
composer install
# Generate a unique application key
php artisan key:generate
# Install our NPM dependencies locally
npm install gulp laravel-elixir

if [ ! -d "/var/www/vendor" ]; then
	mkdir /var/www/vendor
fi

if [ ! -d "/var/www/storage/framework/views" ]; then
	mkdir /var/www/storage/framework/views
fi

if [ ! -d "/var/www/storage" ]; then
	mkdir /var/www/storage
fi

chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Install the database and seed it with sample data
php artisan migrate --seed

# Process the styling for the website
gulp
