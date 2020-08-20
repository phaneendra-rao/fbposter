## installation
----------------------------------------------------------
composer install

Now go to your .env file and change the database credentials

DB_DATABASE=Your Database Name
DB_USERNAME=Username
DB_PASSWORD=Password

php artisan key:generate

php artisan migrate

php artisan passport:install

npm install

npm run dev

php artisan serve
