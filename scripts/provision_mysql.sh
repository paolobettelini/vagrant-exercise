#!/bin/bash

# Variables
DBNAME=vagrant
DBUSER=vagrant
DBPASSWD=vagrantpass

echo "MySql provisioning - begin"

# Install mysql-server
apt-get install mysql-server -y

# Enable remote connections
echo "Updating bind address"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

# Restart MySQL
echo "Restarting mysql service"
systemctl restart mysql

echo "Creating new schema '$DBNAME'"

mysql -uroot -e "CREATE USER IF NOT EXISTS '$DBUSER'@'%' IDENTIFIED BY '$DBPASSWD'"
mysql -uroot -e "FLUSH PRIVILEGES"
mysql -uroot -e "CREATE SCHEMA IF NOT EXISTS $DBNAME"
mysql -uroot -e "GRANT ALL PRIVILEGES ON $DBNAME.* TO '$DBUSER'@'%'"

mysql -uroot $DBNAME << EOF
CREATE TABLE persona (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(25),
    cognome VARCHAR(25),
    citta VARCHAR(25)
);
EOF

mysql -uroot $DBNAME -e "INSERT INTO persona (nome, cognome, citta) VALUES('Paolo', 'Bettelini', 'Caslano');"
mysql -uroot $DBNAME -e "INSERT INTO persona (nome, cognome, citta) VALUES('Damian', 'Campesi', 'Claro');"
mysql -uroot $DBNAME -e "INSERT INTO persona (nome, cognome, citta) VALUES('Erik', 'Pelloni', 'Bioggio');"

# Install firewall
apt install ufw -y
ufw --force enable
ufw allow 3306

echo "MySql provisioning - end"