default: init

init: get-phpcpd composer start docker-test docker-php-test

test: rector phpcpd phpmd phpstan psalm

get-phpcpd:
	wget https://phar.phpunit.de/phpcpd.phar -nc -O ./phpcpd.phar || true
	chmod +x ./phpcpd.phar

composer:
	composer update

start:
	docker-compose up -d
	@echo "you can now open the browser at: http://localhost:8189/"
	@echo "to shutdown docker run: make stop"

stop:
	docker-compose down

rector:
	./vendor/bin/rector -n

phpcpd:
	./phpcpd.phar src

phpmd:
	./vendor/bin/phpmd src text cleancode,codesize,design,unusedcode,controversial

phpstan:
	php vendor/bin/phpstan

psalm:
	./vendor/bin/psalm

docker-php-test:
	docker-compose exec webserver php test/test.php

docker-test:
	docker-compose exec webserver make test

