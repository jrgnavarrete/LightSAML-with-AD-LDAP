#!/bin/bash
YELLOW=$'\e[1;33m'
GREEN=$'\e[0;32m'
RED=$'\e[0;31m'
NC=$'\e[0m'
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    if [  "${EUID:-$(id -u)}" -eq 0  ]; then
        wget -q --tries=2 --timeout=3 --spider https://google.com
        if [[ $? -eq 0 ]]; then
            echo "This script is going to download/install Apache, PHP, the code for the SAML test and some dependencies. Are you sure? If so, ${GREEN}write yes or y${NC}"
            read input
            if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
                echo "Do you want to update and upgrade the system? If so, ${GREEN}write yes or y ${YELLOW}-Recommended if you haven't done this before-.${NC}"
                read wantUpdate
                if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
                    apt -y update
                    apt -y upgrade
                fi
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
                apt install -y php-ldap
                service apache2 restart
                mv composer.phar /usr/local/bin/composer
                #composer require lightsaml/lightsaml
                #composer require symfony/symfony
                composer -n install
                service apache2 restart
            fi
            echo "Do you want to install Docker and download a Keycloak Docker image If so, ${GREEN}answer yes/y.${NC}"
            read input
            if [[ "$input" == "yes"  ||  "$input" == "y" ]]; then
                apt -y install docker-compose
                echo "${YELLOW}Write the admin name for Keycloak: ${NC}" 
                read name
                echo "${YELLOW}Write the admin password for Keycloak: ${NC}" 
                read password
                while [[ "$name" == ""  ||  "$password" == "" ]]; do
                    echo "${RED}The username and/or password can't be null.${NC}"
                    echo "${YELLOW}Write again the admin name for Keycloak: ${NC}" 
                    read name
                    echo "${YELLOW}Write again the admin password for Keycloak: ${NC}" 
                    read password
                done
                echo "${YELLOW}Write the port for Keycloak container (recommended 8080): ${NC}" 
                read port
                while [[ "$port" == "" || ! "$port" =~ ^()([1-9]|[1-5]?[0-9]{2,4}|6[1-4][0-9]{3}|65[1-4][0-9]{2}|655[1-2][0-9]|6553[1-5])$ ]]; do
                    echo "${YELLOW}Write a port for Keycloak container, ${RED}it has to be a valid port number${NC}${YELLOW}(recommended 8080): ${NC}" 
                    read port
                done
                    docker run -d -e KEYCLOAK_USER=$name -e KEYCLOAK_PASSWORD=$password -e KEYCLOAK_LOGLEVEL=DEBUG -p $port:8080 jboss/keycloak
            fi
            exit 0;
        else
                echo "${RED}You need Internet connection${NC}"
                exit 1;
        fi   
    else
        echo "${RED}You have to be root or run it with sudo.${NC}"
        exit 1;
    fi 
else
    echo "${RED}The OS must to be Linux :(${NC}"
    exit 1;
fi
