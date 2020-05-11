.PHONY: help
help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: install
install: node_modules/time vendor/autoload.php ## Installe les différentes dépendances
	yarn run build

.PHONY: migrate
migrate: vendor/autoload.php ## Migre la base de donnée
	php bin/console doctrine:migrations:migrate

.PHONY: seed
seed: vendor/autoload.php ## Remplie la base de données
	php bin/console doctrine:fixtures:load

.PHONY: tests
tests: vendor/autoload.php ## execute les tests
	php bin/phpunit

.PHONY: lint
lint: vendor/autoload.php ## Lint le code
	php vendor/bin/phpcs -s

.PHONY: lint-fix
lint-fix: vendor/autoload.php ## corrige les erreurs du linting
	php vendor/bin/phpcbf

.PHONY: serve
serve: vendor/autoload.php ## lance, le serve de development
	php -S localhost:8000 -t public

.PHONY: clear
clear: vendor/autoload.php ## Vide le cache de l'enviroment en cours
	php bin/console cache:clear

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php

node_modules/time: yarn.lock
	yarn
	touch node_modules/time
