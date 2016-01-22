git pull
composer update
vagrant ssh -c "cd /vagrant && php artisan migrate"
vagrant ssh -c "cd /vagrant && php artisan db:seed"
gulp
echo "OK you can go to the project now"
