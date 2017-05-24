.PHONY: all create migrate rollback

type ?= development

ifeq ($(type),production)
	cmd := $(shell \cp -f config/environment-production.php config/environment.php)
else ifeq ($(type),test)
	cmd := $(shell \cp -f config/environment-test.php config/environment.php)
else ifeq ($(type),development)
	cmd := $(shell \cp -f config/environment-development.php config/environment.php)
endif

all:
	@echo $$ make list
	@echo $$ make status
	@echo $$ make generate type=development
	@echo $$ make migrate type=development
	@echo $$ make dry-run type=development

list:
	@php ../../../app/vendor/bin/doctrine list

status:
	@php ../../../app/vendor/bin/doctrine --configuration=config/migrations.yml migrations:status --show-versions

generate:
	@php ../../../app/vendor/bin/doctrine --configuration=config/migrations.yml migrations:generate

migrate:
	@make -s status
	@echo
	@php ../../../app/vendor/bin/doctrine --configuration=config/migrations.yml migrations:migrate

dry-run:
	@php ../../../app/vendor/bin/doctrine --configuration=config/migrations.yml migrations:migrate --dry-run

rollback:
	@make -s status
	@echo
	@echo "Rollback to $(shell bin/getPreviousVersion.sh)"
	@echo
	@php ../../../app/vendor/bin/doctrine --configuration=config/migrations.yml migrations:migrate $(shell bin/getPreviousVersion.sh)

