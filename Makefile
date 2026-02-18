default: init

init: get-phpcpd get-phpdocumentor composer start docker-test docker-php-test

test: phpcs phpunit rector phpcpd phpmd phpstan psalm phan

bash:
	docker exec -it random-webserver-1 bash

get-phpcpd:
	wget https://phar.phpunit.de/phpcpd.phar -nc -O ./phpcpd.phar || true
	chmod +x ./phpcpd.phar

get-phpdocumentor:
	wget https://phpdoc.org/phpDocumentor.phar -nc -O ./phpdoc.phar || true
	chmod +x ./phpdoc.phar

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
	./vendor/bin/phpstan

psalm:
	./vendor/bin/psalm

phan:
	./vendor/bin/phan  --allow-polyfill-parser -m verbose

phpcs:
	./vendor/bin/phpcs

phpunit:
	./vendor/bin/phpunit

docker-php-test:
	docker-compose exec webserver php test/test.php

docker-test:
	docker-compose exec webserver make test

normalize:
	composer normalize

phpinsights:
	./vendor/bin/phpinsights -cphpinsights.php -vvv

pdepend:
	./vendor/bin/pdepend \
		--dependency-xml=pdepend/dependency.xml \
		--jdepend-chart=pdepend/jdepend.svg \
		--jdepend-xml=pdepend/jdepend.xml \
        --overview-pyramid=pdepend/pyramid.svg \
		--summary-xml=pdepend/summary.xml \
		--debug \
		src
#		--coverage-report=pdepend/coverage.report \

phpdoc:
	./phpdoc.phar --target=documentation --directory=src --cache-folder=documentation/cache
