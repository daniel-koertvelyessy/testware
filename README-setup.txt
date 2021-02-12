
# setup laravel environment on debian buster

# IF inside a new debian / ubuntu container you may 
# need to install wget / sudo first
apt update
apt install wget -y 
apt insatll sudo -y 

# make new system user
adduser system
usermod -aG sudo system
su - system

# install Apache Server
sudo apt update
sudo apt install apache2

# install PHP
sudo apt install lsb-release apt-transport-https ca-certificates
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sudo echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php7.3.list
sudo apt update
sudo apt install php7.3 php7.3-cli php7.3-fpm php7.3-json php7.3-pdo php7.3-mysql php7.3-zip php7.3-gd  php7.3-mbstring php7.3-curl php7.3-xml php7.3-bcmath php7.3-json php7.3-zip

# install MariaDB
sudo apt install mariadb-server mariadb-client
sudo mysql_secure_installation

Set root password? [Y/n] Y
Remove anonymous users? [Y/n] Y
Disallow root login remotely? [Y/n] Y
Remove test database and access to it? [Y/n] Y
Reload privilege tables now? [Y/n] Y

sudo mysql -u root

create database testware;
GRANT USAGE ON *.* TO 'root'@localhost IDENTIFIED BY 'password';
GRANT ALL privileges ON `testware`.* TO 'root'@localhost;
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'root'@localhost;
+----------------------------------------------------------------------------------------------------------------------------------------+
| Grants for root@localhost                                                                                                              |
+----------------------------------------------------------------------------------------------------------------------------------------+
| GRANT ALL PRIVILEGES ON *.* TO `root`@`localhost` IDENTIFIED BY PASSWORD 'password' WITH GRANT OPTION |
| GRANT ALL PRIVILEGES ON `testware`.* TO `root`@`localhost`                                                                             |
| GRANT PROXY ON ''@'%' TO 'root'@'localhost' WITH GRANT OPTION                                                                          |
+----------------------------------------------------------------------------------------------------------------------------------------+

mysql -u root -p

# setup apache server
sudo mkdir /var/www/hub.bitpack.io
sudo vi /etc/apache2/sites-available/hub.bitpack.io.conf

<VirtualHost *:80>

ServerAdmin info@bitpack.io
ServerName testware.hub.bitpack.io
ServerAlias testware.hub.bitpack.io
DocumentRoot /var/www/hub.bitpack.io/public/

<Directory /var/www/hub.bitpack.io/public/>
    AllowOverride all
    Require all granted
</Directory>

ErrorLog ${APACHE_LOG_DIR}/example.com_error.log
CustomLog ${APACHE_LOG_DIR}/example.com_access.log combined

</VirtualHost>

sudo a2ensite hub.bitpack.io
sudo a2enmod rewrite
sudo service apache2 restart

sudo apt install git
ssh-keygen

system@testware:~$ cd /var/www/
system@testware:/var/www$ sudo chown -R system:www-data /var/www/hub.bitpack.io
system@testware:/var/www$ git clone https://workspace.hub.bitpack.io/gitlab/bitpackio/testware.git hub.bitpack.io/
system@testware:/var/www$ cd hub.bitpack.io/
system@testware:/var/www/hub.bitpack.io$ sudo chown -R system:www-data /var/www/hub.bitpack.io/
system@testware:/var/www/hub.bitpack.io$ find /var/www/hub.bitpack.io/ -type f -exec chmod 664 {} \;
system@testware:/var/www/hub.bitpack.io$ find /var/www/hub.bitpack.io/ -type d -exec chmod 775 {} \;
system@testware:/var/www/hub.bitpack.io$ chgrp -R www-data storage bootstrap/cache
system@testware:/var/www/hub.bitpack.io$ chmod -R ug+rwx storage bootstrap/cache

system@testware:/var/www/hub.bitpack.io$ cd
system@testware:~$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
system@testware:~$ php composer-setup.php
system@testware:~$ php -r "unlink('composer-setup.php');"
system@testware:~$ sudo mv composer.phar /usr/local/bin/composer
system@testware:~$ cd /var/www/hub.bitpack.io/
system@testware:/var/www/hub.bitpack.io$ composer install

system@testware:/var/www/hub.bitpack.io$ sudo apt install npm
system@testware:/var/www/hub.bitpack.io$ npm install
system@testware:/var/www/hub.bitpack.io$ npm run dev

system@testware:/var/www/hub.bitpack.io$ cp .env.example .env
system@testware:/var/www/hub.bitpack.io$ vi .env

APP_NAME=testware
APP_ENV=local
APP_KEY=base64:vKS9VjfRvOQto5mfkdX9VB15VpFnJFMx/d3K5RL68i4=
APP_DEBUG=true
APP_URL=http://testware.hub.bitpack.io

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=testware
DB_USERNAME=root
DB_PASSWORD=password

system@testware:/var/www/hub.bitpack.io$ cd /var/www/
system@testware:/var/www$ sudo chown -R server-user:www-data /var/www/hub.bitpack.io/
system@testware:/var/www$ sudo chown -R system:www-data /var/www/hub.bitpack.io/
system@testware:/var/www$ find /var/www/hub.bitpack.io/ -type f -exec chmod 664 {} \;
system@testware:/var/www$ find /var/www/hub.bitpack.io/ -type d -exec chmod 775 {} \;
system@testware:/var/www$ cd hub.bitpack.io/
system@testware:/var/www/hub.bitpack.io$ chgrp -R www-data storage bootstrap/cache
system@testware:/var/www/hub.bitpack.io$ chmod -R ug+rwx storage bootstrap/cache

system@testware:/var/www/hub.bitpack.io$ php artisan migrate:fresh --seed

