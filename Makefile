setup:
	@make build
	@make up
	@make composer-update
build:
	docker-compose up -d --build
stop:
	docker compose stop
up:
	docker compose up -d
migrate:
	docker exec laravel_app bash -c "php artisan migrate"
seed:
	docker exec laravel_app bash -c "php artisan db:seed"
data:
	docker exec laravel_app bash -c "php artisan migrate"
	docker exec laravel_app bash -c "php artisan db:seed"
api-key:
	docker exec laravel_app bash -c "php artisan key:generate"
install:
	docker exec -it laravel_app composer install
init:
	@make build
	@make up
	@make install
	@make api-key
	@make migrate
	@make seed