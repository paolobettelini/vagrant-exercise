echo "PHP provisioning - begin"

# Install utilities
apt install software-properties-common apt-transport-https -y

# Add repository
add-apt-repository ppa:ondrej/php -y

# Install php8 for apache2
apt install php8.1 libapache2-mod-php8.1 -y

# Install MySQL binding for PHP
apt-get install php-mysql -y

# Restart apache2
systemctl restart apache2

echo "PHP provisioning - end"