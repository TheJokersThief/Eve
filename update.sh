git pull
composer update
vagrant ssh -c "cd /vagrant && php artisan migrate:refresh --seed"
gulp
echo "OK you can go to the project now"
