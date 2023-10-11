SHELL := /bin/bash

.PHONY: start
start:
	@symfony proxy:start
	@symfony server:start -d

.PHONY: stop
stop:
	@symfony server:stop
	@symfony proxy:stop

.PHONY: logs_warn
logs_warn:
	@tail -f var/log/*.log  | grep --binary-files=text "ERROR\|CRITICAL\|WARNING"

.PHONY: logs
logs:
	@tail -f var/log/*.log  | grep --binary-files=text "ERROR\|CRITICAL\|WARNING\|INFO"

.PHONY: logs_all
logs_all:
	@tail -f var/log/*.log

.PHONY: purge
purge:
	@rm -fr var/cache/*
	@rm -f var/log/*
