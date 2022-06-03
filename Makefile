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
	composer run-script phpcs -- --standard=PSR12 app tests

deploy:
	git push heroku main

setup:
	composer install
	composer update
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan migrate

test-coverage:
	./vendor/bin/sail artisan db:seed
	./vendor/bin/sail artisan test --coverage-clover coverage.xml
