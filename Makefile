update:
	composer update

install:
	composer install

console:
	psysh --config psysh.php

lint:
	composer run-script phpcs -- --standard=PSR12 app tests

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 app tests

test:
	composer run-script phpunit test

.PHONY: test
