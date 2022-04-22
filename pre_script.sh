#!/bin/bash
GREEN=$'\e[0;32m'
RED=$'\e[0;31m'
NC=$'\e[0m'
echo "This script is going to download/install Apache, PHP, the code for the SAML test and some dependencies. Are you sure? If so, ${GREEN}write yes or y${NC} -You have to be root or run it with sudo-."
read input
if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
	apt -y update
	apt -y upgrade
	apt -y  install apache2 php git zip
	cd /var/www
	git clone https://github.com/jrgnavarrete/LightSAMLpruebas
	rm -r html/
	cp -r LightSAMLpruebas/ html/
	rm -r LightSAMLpruebas/
	cd html/
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	apt -y install php-xml
	service apache2 restart
	mv composer.phar /usr/local/bin/composer
	#composer require lightsaml/lightsaml
	#composer require symfony/symfony
	composer install
	service apache2 restart
fi
echo "The SAMLserver is installed, do you want to install Docker and download a Keycloak Docker image mapping the port 8080? If so, ${GREEN}answer yes/y${NC}. (Admin user is admin:admin)"
read input
if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
	apt -y install docker-compose
	docker run -d -e KEYCLOAK_USER=admin -e KEYCLOAK_PASSWORD=admin -e KEYCLOAK_LOGLEVEL=DEBUG -p 8080:8080 jboss/keycloak
fi
