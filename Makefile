ifndef APP_ENV
include .env
endif

FIG=docker-compose
RUN=$(FIG) run --rm app
EXEC=$(FIG) exec app
CONSOLE=bin/console
PHPUNIT=vendor/bin/phpunit


#########
# CACHE #
#########

# Cache Clear
cc:
	@test -f $(CONSOLE) && $(CONSOLE) cache:clear --no-warmup || rm -rf var/cache/*
.PHONY: cc

# Cache Warmup
cw: cc
    @test -f $(CONSOLE) && $(CONSOLE) cache:warmup || echo "cannot warmup the cache (needs symfony/console)"
.PHONY: cw


#############
# BLACKFIRE #
#############

bf-dev:
    blackfire-player --endpoint=http://`$(CONSOLE) server:status --filter=address` run tests/bkf/all.bkf
.PHONY: bf-dev

bf-prod:
    blackfire-player --endpoint=https://twig.sensiolabs.org run tests/bkf/all.bkf --variable="env=prod"
.PHONY: bf-prod

########
# TEST #
########

test:
	@test -f $(PHPUNIT) && BASE_URL=http://`$(CONSOLE) server:status --filter=address` $(PHPUNIT) || echo "PHPUnit Failed!"
.PHONY: test