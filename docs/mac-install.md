Mac Development Install
=======================

Packages required
-----------------

Macports will need to be installed in order to setup MySQL, Apache and PHP. You can install from http://www.macports.org/

Once installed the following ports should be installed
```
sudo port install apache2
sudo port install mysql56
sudo port install mysql56-server
sudo port install php56
sudo port install php56-apache2handler
sudo port install php56-curl
sudo port install php56-exif
sudo port install php56-imagick
sudo port install php56-intl
sudo port install php56-mysql
sudo port install php56-openssl
```


Clone the repo
--------------

You'll need your ssh keys installed at github so you can push changes back to the project if you have permissions.

It is recommended to create a working directory for the project that can contain extra files, downloads etc and the git repo is a subdirectory.

```
~/projects/qruqsp
```

Clone the qruqsp repo
```
cd ~/projects/qruqsp
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
cd ~/projects/qruqsp/qruqsp.local
chmod a+w site
chmod a+w site/qruqsp-mods/web/cache
```

MySQL
-----
Setup a database on your dev machine for the qruqsp project.
```
mysqladmin create qruqsp
```

You can create a user in the database specifically for this project, or you can use the root database user for development. In production
you should always create a different user for each install of QRUQSP.

Hosts file
----------
Edit your /etc/hosts file and add the line
```
127.0.0.1   qruqsp.local    qruqsp
```

Apache
------
The following virtual host definition should be added to the file /opt/local/apache2/conf/extra/httpd-vhosts.conf and modify for your
file system.

```
<VirtualHost *:80>
    ServerName qruqsp.local
    ServerAdmin veggiefrog@gmail.com
    DocumentRoot "DIR/projects/qruqsp/qruqsp.local/site"
    CustomLog "DIR/projects/qruqsp/qruqsp.local/logs/access.log" common
    ErrorLog "DIR/projects/qruqsp/qruqsp.local/logs/error.log"
    <Directory "DIR/projects/qruqsp/qruqsp.local/site">
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

Test the new configuration to make sure the webserver will restart
```
/opt/local/apache2/bin/apachectl configtest
```

If everything is ok, restart apache with the new configuration
```
/opt/local/apache2/bin/apachectl restart
```

Configure QRUQSP
----------------
Run the qruqsp-install from the website http://qruqsp.local/qruqsp-installer.php


Install QRUQSP/dev-tools
------------------------
The dev-tools packages contains useful scripts to help you test and setup new modules.

```
cd ~/projects/qruqsp/qruqsp.local
git clone https://github.com/qruqsp/dev-tools.git
```

Copy the run.ini.default to run.ini and configure with your local settings. This will allow you to 
execute ./run.php and see the history of API calls and repeat any calls you want, useful for testing the API.



