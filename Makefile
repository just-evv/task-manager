up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

test:
	./vendor/bin/sail test

lint:
	composer run-script phpcs -- --standard=PSR12 app tests

deploy:
	git push heroku main

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	npm install

test-coverage:
	php artisan test --coverage-clover coverage.xml
