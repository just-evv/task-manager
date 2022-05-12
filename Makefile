up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

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
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	npm install

test-coverage:
	touch test.sqlite
	php artisan config:cache --env=testing
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	php artisan test --coverage-clover coverage.xml
	rm test.sqlite
