install:
	composer install
	cp .env_example .env
	docker-compose exec robocf_app_1 php artisan key:generate
	docker-compose exec robocf_app_1 php artisan optimize
	sudo chmod -R 777 storage && sudo chmod -R 777 bootstrap/cache
	docker-compose exec app php artisan migrate --seed
	cp .env_example .env
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

