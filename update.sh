git pull
composer update
vagrant ssh -c "cd /vagrant && php artisan migrate:refresh --seed && php artisan cache:clear"
gulp
echo "OK you can go to the project now"
