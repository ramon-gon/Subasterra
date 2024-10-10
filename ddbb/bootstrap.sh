#!/bin/bash

# Assegura que SSH està instal·lat
apt-get update -y
apt-get install -y openssh-server

# Insta·la MariaDB (repositori oficial)
sudo apt-get install -y software-properties-common dirmngr apt-transport-https
sudo apt-key adv --fetch-keys 'https://mariadb.org/mariadb_release_signing_key.asc'
sudo add-apt-repository 'deb [arch=amd64,arm64,ppc64el] https://mirrors.ukfast.co.uk/sites/mariadb/repo/11.5.2/ubuntu bionic main'
apt-get update -y
apt install -y mariadb-server

# Configura MariaDB
sudo sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mariadb.conf.d/50-server.cnf
systemctl restart mariadb

# Crea la base de dades
mariadb < /Vagrant/files/subasterra.sql