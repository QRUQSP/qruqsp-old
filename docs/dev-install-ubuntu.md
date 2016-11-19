Development Install for Ubuntu
==============================

Packages required
-----------------

Update your packages list.
```
sudo apt-get update
```

Install the MySQL server
```
sudo apt-get -y install mysql-server
```

Add the following line to /etc/alternatives/my.cnf so that default values don't have to specified
for each column of each table. QRUQSP was designed to use defaults assigned by Mysql not the schema.
The lines should be added at the end of the file after the includes of other configuration files.
```
[mysqld]
sql_mode = ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```

Create the database
```
mysqladmin create qruqsp
```

Install apache and php
```
sudo apt-get -y install apache2
sudo apt-get -y install php
sudo apt-get -y install php-imagick
sudo apt-get -y install php-intl
sudo apt-get -y install php-curl
sudo apt-get -y install php-mysql
sudo apt-get -y install php-json
sudo apt-get -y install php-readline
sudo apt-get -y install php-imap
sudo apt-get -y install php7.0-bcmath
sudo apt-get -y install libapache2-mod-php7.0
```

Hosts file
----------
Edit your /etc/hosts file and add the line
```
127.0.0.1   qruqsp.local    qruqsp
```

Setup QRUQSP
------------

Setup the website and clone the repo.
```
mkdir /qruqsp/sites
cd /qruqsp/sites
git clone git@github.com:qruqsp/qruqsp qruqsp.local
```

Update the submodules for the project to make sure you have the latest code
```
cd qruqsp.local
git submodule update --init
```

The following directory permissions need to be changed so the webserver has access to them. Once the configuration is run further down then
the permissions can be changed back.
```
cd /qruqsp/sites/qruqsp.local
chmod a+w site
chmod a+w site/qruqsp-mods/web/cache
```

Apache
------
Create the log directory for apache logs.
```
cd /qruqsp/sites/qruqsp.local
mkdir logs
```

Edit the file /etc/apache2/sites-available/qruqsp.local.conf
```
<VirtualHost *:80>
    ServerAdmin emailaddress@myserver.com
    ServerName qruqsp.local

    DocumentRoot /qruqsp/sites/qruqsp.local/site
    <Directory />
        Options FollowSymLinks
        AllowOverride None
        Require all granted
    </Directory>
    <Directory /qruqsp/sites/qruqsp.local/site/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Link the file into sites-enabled
```
cd /etc/apache2/sites-enabled
ln -s ../sites-available/qruqsp.local.conf
```

Test the new configuration to make sure the webserver will restart
```
sudo /usr/sbin/apache2ctl configtest
```

If everything is ok, restart apache with the new configuration
```
sudo /usr/sbin/apache2ctl restart
```

Configure QRUQSP
----------------
Run the qruqsp-install from the website http://qruqsp.local/qruqsp-install.php

If you don't want to setup SSL on your dev machine, turn off SSL in the qruqsp-api.ini file.
```
[qruqsp.core]
    ...snip...
    ssl = "off"
    ...snip...
```

Install QRUQSP/dev-tools
------------------------
The dev-tools packages contains useful scripts to help you test and setup new modules.

```
cd /qruqsp/sites/qruqsp.local
git clone https://github.com/qruqsp/dev-tools.git
```

Copy the run.ini.default to run.ini and configure with your local settings. This will allow you to 
execute ./run.php and see the history of API calls and repeat any calls you want, useful for testing the API.

```
cd /qruqsp/sites/qruqsp.local
cp run.ini.default run.ini
```


