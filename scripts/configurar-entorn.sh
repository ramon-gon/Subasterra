#!/bin/bash

URL_REPO="git@gitlab.com:ortiz.leal.roger/subasterra.git"
DIRECTORI_WEB="/var/www/subasterra"
DIRECTORI_TEMP="$HOME/subasterra-temp"

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
sudo apt install -y git apache2

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

echo "L'entorn de $TIPUS_ENTORN s'ha configurat correctament!"
