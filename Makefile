up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

restart:
	./vendor/bin/sail restart

test:
	./vendor/bin/sail test

migrate:
	./vendor/bin/sail artisan migrate

lint:
	composer exec phpcs -- --standard=PSR12 app tests

deploy:
	git push heroku main

setup:
	docker run --rm -v $(PWD):/app composer/composer:latest install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	docker-compose up -d
	docker-compose exec -T laravel.test php artisan migrate
	npm install

start:
	docker-compose up -d

test-coverage:
	docker-compose exec -T laravel.test php artisan db:seed
	docker-compose exec -T laravel.test php artisan test --coverage-clover coverage.xml
