.PHONY: dev-build
dev-build:
	cd deploy && docker compose --env-file ./../.env build

.PHONY: dev-up
dev-up:
	cd deploy && docker compose --env-file ./../.env up -d

.PHONY: dev-down
dev-down:
	cd deploy && docker compose --env-file ./../.env down

.PHONY: dev-ps
dev-ps:
	cd deploy && docker compose --env-file ./../.env ps

.PHONY: bash
bash:
	cd deploy && docker compose --env-file ./../.env exec php-fpm bash
