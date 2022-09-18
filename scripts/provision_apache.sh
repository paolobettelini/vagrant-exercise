#!/bin/bash

echo "Apache2 provisioning - begin"

# Install Apache2
apt-get install apache2 -y

# Enable mod_rewrite
a2enmod rewrite

# Restart Apache
systemctl restart apache2

echo "Apache2 provisioning - end"
