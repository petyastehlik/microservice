start:
	docker-compose up -d
	composer install

stop:
	docker-compose stop

exec:
	docker-compose exec php bash

run:
	docker-compose exec php bash -c "./bin/console store users 1 comments --format=json,xml,html"

test:
	docker-compose exec php ./vendor/bin/phpunit
	docker-compose exec php ./vendor/bin/phpcbf
	docker-compose exec php ./vendor/bin/phpcs
