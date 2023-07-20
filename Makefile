.PHONY: dev-build
dev-build:
	docker-compose build

.PHONY: dev-up
dev-up:
	docker-compose up -d

.PHONY: dev-down
dev-down:
	docker-compose down

.PHONY: dev-ps
dev-ps:
	docker-compose ps

.PHONY: dev-bash-php-fpm
bash:
	docker-compose exec php-fpm bash

.PHONY: down-build-up
down-build-up:
	docker-compose down && docker-compose build && docker-compose up -d
