Notes
=========

You can find dump of db in app/Resources/db_dump. But you really don't need it. Just follow steps in installation section and you'll get db filled with some faker data.

Answers to MySQL tasks you can find [here](https://gist.github.com/overgapo/8f8aeeafcdcfdeab9b1e).

Installation
============

###1) Project cloning
```bash
$ git clone git@github.com:overgapo/SwivlTest.git /path/to/project
```

###2) Setup local sandbox
```
127.0.0.1 swivl.local
```
Apache virtual host example:
```
<VirtualHost *:80>
    ServerName swivl.local
    DocumentRoot /path/to/project/web
    ErrorLog /path/to/project/app/logs/error.log
    <Directory "/path/to/project/web">
        Require all granted
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

###3) Vendors installation
```bash
/path/to/project$ php composer.phar install -o --dev
```
Composer will ask for db parameters etc.

###4) System Checking
Make sure that your system is properly configured.
```bash
/path/to/project$ php app/check.php
```
If you get any warnings or recommendations, fix them before moving on.

###5) Deploing
```bash
/path/to/project$ bin/phing full
```
