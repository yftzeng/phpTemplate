.PHONY: all simple full init clean server destroy

all:
	@echo $$ make simple
	@echo $$ make full
	@echo $$ make init
	@echo $$ make server
	@echo $$ make clean
	@echo $$ make destroy

simple:
	@cd app && cp composer.json.simple composer.json && php composer.phar self-update && php composer.phar update
	@make init

full:
	@cd app && cp composer.json.full composer.json && php composer.phar self-update && php composer.phar update
	@make init

init:
	@bash script/init.sh

server:
	php -S 127.0.0.1:8000 -t public

clean:
	sudo rm -rf var/log

destroy:
	sudo rm -rf var
	sudo rm -rf app/cache
	sudo rm -rf app/composer.lock
	sudo rm -rf app/composer.json
	sudo rm -rf app/vendor
