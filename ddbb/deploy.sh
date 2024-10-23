#!/bin/bash

URL_REPO="git@gitlab.com:ortiz.leal.roger/subasterra.git"
DIRECTORI_WEB="/var/www/subasterra"
DIRECTORI_TEMP="$HOME/subasterra-temp"
MARIADB_CONFIG="/etc/mysql/mariadb.cnf"
PHP_INI="/etc/php/8.2/apache2/php.ini"

if [ -z "$1" ]; then
    echo "Ús: $0 [desenvolupament|produccio]"
    exit 1
fi

TIPUS_ENTORN="$1"
if [ "$TIPUS_ENTORN" == "desenvolupament" ]; then
    BRANCA="develop"
    CONF_APACHE="/etc/apache2/sites-available/subasterra-dev.conf"
    NIVELL_LOG="debug"
    PERMETRE_OVERRIDE="All"
    OPCIONS="Indexes FollowSymLinks"
    sudo sed -i "s/^error_reporting = .*/error_reporting = E_ALL/" "$PHP_INI"
    sudo sed -i "s/^display_errors = .*/display_errors = On/" "$PHP_INI"
    sudo sed -i "s/^display_startup_errors = .*/display_startup_errors = On/" "$PHP_INI"
    sudo sed -i "s/^log_errors = .*/log_errors = On/" "$PHP_INI"
    sudo sed -i "s/^max_execution_time = .*/max_execution_time = 0/" "$PHP_INI"
    sudo sed -i "s/^memory_limit = .*/memory_limit = -1/" "$PHP_INI"
elif [ "$TIPUS_ENTORN" == "produccio" ]; then
    BRANCA="main"
    CONF_APACHE="/etc/apache2/sites-available/subasterra-prod.conf"
    NIVELL_LOG="warn"
    PERMETRE_OVERRIDE="None"
    OPCIONS="FollowSymLinks"
else
    echo "Opció no vàlida. Usa 'desenvolupament' o 'produccio'."
    exit 1
fi

sudo apt update
sudo apt install -y git apache2 mariadb-server php8.2 php8.2-cli php8.2-mysql

sudo systemctl restart mariadb

if [ -d "$DIRECTORI_TEMP" ]; then
    rm -rf "$DIRECTORI_TEMP"
fi

git clone "$URL_REPO" "$DIRECTORI_TEMP" -b "$BRANCA"

if [ -d "$DIRECTORI_WEB" ]; then
    sudo rm -rf "$DIRECTORI_WEB"
fi

sudo mv "$DIRECTORI_TEMP" "$DIRECTORI_WEB"

sudo chown -R www-data:www-data "$DIRECTORI_WEB"
sudo chmod -R 755 "$DIRECTORI_WEB"

sudo bash -c "cat > $CONF_APACHE" <<EOL
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot $DIRECTORI_WEB

    <Directory $DIRECTORI_WEB>
        Options $OPCIONS
        AllowOverride $PERMETRE_OVERRIDE
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined

    LogLevel $NIVELL_LOG
</VirtualHost>
EOL

sudo a2ensite $(basename "$CONF_APACHE")
sudo a2dissite 000-default
sudo systemctl reload apache2

sudo mariadb <<EOF
CREATE USER 'subasterra'@'%' IDENTIFIED BY 'subasterra1234!';
GRANT ALL PRIVILEGES ON *.* TO 'subasterra'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EOF

sudo mariadb < /var/www/subasterra/ddbb/files/subasterra.sql

if [ "$(hostname)" == "dev-server" ]; then
    sudo sed -i "s/localhost:1234/localhost/" /var/www/subasterra/config/config.php
fi

echo "L'entorn de $TIPUS_ENTORN s'ha configurat correctament!"
sudo systemctl restart apache2
sudo systemctl restart mariadb
