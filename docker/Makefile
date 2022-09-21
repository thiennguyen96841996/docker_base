# phpコンテナでcomposer updateを実行 (どのコンテナでやってもOK)
composer-update:
	docker-compose exec php-customer composer update

# phpコンテナでcomposer installを実行 (どのコンテナでやってもOK)
composer-install:
	docker-compose exec php-customer composer install

# phpコンテナでcomposer dump-autoを実行 (どのコンテナでやってもOK)
composer-dump:
	docker-compose exec php-customer composer dump-auto

# phpコンテナでartisan ide-helper:generateを実行 (どのコンテナでやってもOK)
helper-generate:
	docker-compose exec php-customer php artisan ide-helper:generate

# NPM
npm-update:
	docker-compose exec node npm update
	docker-compose restart node

# Log tail
npm-watch-log:
	docker logs -f tourbillon-node-1
laravel-tail-log:
	tail -f src/storage/logs/*

# DB
fresh-db:
	docker-compose exec php-customer php artisan migrate:fresh --seed --database=mysql_migration
seed-db:
    docker-compose exec php-customer php artisan db:seed --database=mysql_migration