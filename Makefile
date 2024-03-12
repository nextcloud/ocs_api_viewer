# SPDX-FileCopyrightText: Bernhard Posselt <dev@bernhard-posselt.com>
# SPDX-License-Identifier: AGPL-3.0-or-later

app_name=$(notdir $(CURDIR))
build_tools_directory=$(CURDIR)/build/tools
project_directory=$(CURDIR)/../$(app_name)
appstore_build_directory=$(CURDIR)/build/artifacts
certificate_directory=$(HOME)/.nextcloud/certificates
npm=$(shell which npm 2> /dev/null)
composer=$(shell which composer 2> /dev/null)

all: build

.PHONY: build
build: composer npm

.PHONY: composer
composer:
	composer install --prefer-dist

.PHONY: npm
npm:
	npm ci
	npm run build

.PHONY: clean
clean:
	rm -rf ./build

.PHONY: distclean
distclean: clean
	rm -rf vendor
	rm -rf node_modules

.PHONY: appstore
appstore: build
	rm -rf $(appstore_build_directory)
	mkdir -p $(appstore_build_directory)
	rsync -a \
	--exclude=babel.config.js \
	--exclude=/build \
	--exclude=composer.json \
	--exclude=composer.lock \
	--exclude=.git \
	--exclude=.gitignore \
	--exclude=.idea \
	--exclude=Makefile \
	--exclude=node_modules \
	--exclude=package.json \
	--exclude=package-lock.json \
	--exclude=psalm.xml \
	--exclude=README.md \
	--exclude=/src \
	--exclude=stylelint.config.js \
	--exclude=vendor/bin \
	--exclude=webpack.config.js \
	$(project_directory)/  $(appstore_build_directory)/$(app_name)
	tar -czf $(appstore_build_directory)/$(app_name).tar.gz -C $(appstore_build_directory) $(app_name)
	@if [ -f $(certificate_directory)/$(app_name).key ]; then \
		echo "Signing package…"; \
		openssl dgst -sha512 -sign $(certificate_directory)/$(app_name).key $(appstore_build_directory)/$(app_name).tar.gz | openssl base64; \
	fi
