install:
	php composer.phar install
docker-up:
	 docker-compose up --build -d
docker-down:
	 docker-compose down
laravel-refresh:
	 docker exec robocf_app_1 php artisan migrate:refresh --seed
laravel-approve:
	 docker exec robocf_app_1 php artisan schedule:run
laravel-test:
	 docker exec robocf_app_1 ./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests/CashFlowTest.php

