#!/bin/bash
YELLOW=$'\e[1;33m'
GREEN=$'\e[0;32m'
RED=$'\e[0;31m'
NC=$'\e[0m'
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    wget -q --tries=2 --timeout=3 --spider https://google.com
    if [[ $? -eq 0 ]]; then
        echo "This script is going to download/install Apache, PHP, the code for the SAML test and some dependencies. Are you sure? If so, ${GREEN}write yes or y ${YELLOW}-You have to be root or run it with sudo-.${NC}"
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
            rm pre_script.sh README.md
            php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
            php composer-setup.php
            php -r "unlink('composer-setup.php');"
            apt -y install php-xml
            service apache2 restart
            mv composer.phar /usr/local/bin/composer
            #composer require lightsaml/lightsaml
            #composer require symfony/symfony
            composer -n install
            service apache2 restart
        fi
        echo "Do you want to install Docker and download a Keycloak Docker image mapping the port 8080? If so, ${GREEN}answer yes/y.${NC}"
        read input
        if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
            apt -y install docker-compose
            echo "${YELLOW}Write the admin name for Keycloak: ${NC}" 
            read name
            echo "${YELLOW}Write the admin password for Keycloak: ${NC}" 
            read password
            if [[ "$name" == ""  ||  "$password" == "" ]]; then
                echo "${RED}The username and/or password can't be null.${NC}"
            else
                docker run -d -e KEYCLOAK_USER=$name -e KEYCLOAK_PASSWORD=$password -e KEYCLOAK_LOGLEVEL=DEBUG -p 8080:8080 jboss/keycloak
            fi
            
        fi
    else
            echo "${RED}You need Internet connection${NC}"
    fi   
else
    echo "${RED}The OS must to be Linux :(${NC}"
fi
