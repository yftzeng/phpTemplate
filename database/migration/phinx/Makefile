.PHONY: all create migrate rollback

type ?= development

all:
	@echo $$ make create name=AddTAble
	@echo $$ make migrate type=development
	@echo $$ make rollback type=development

create:
	php ../../app/vendor/bin/phinx create $(name) -c phinx.php

migrate:
	php ../../app/vendor/bin/phinx migrate -e $(type) -c phinx.php

rollback:
	php ../../app/vendor/bin/phinx rollback -e $(type) -c phinx.php
