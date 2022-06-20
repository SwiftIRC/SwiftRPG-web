# SwiftRPG

## Setting up a Development Environment (in WSL/Ubuntu)

### Dependencies

#### git

First, clone the other required services:

https://github.com/SwiftIRC/SwiftRPG
https://github.com/SwiftIRC/SwiftRPG-map

#### packages

Second, add the PHP repository to your apt sources:

NOTE: This command is for Ubuntu 20.04

```
echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ondrej-ubuntu-php-focal.list
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
apt update
```

Third, install the following packages:

```
apt install php8.1-mysql php8.1-gd php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip mysql-server mysql-client nginx
```

This will install PHP 8.1, MySQL 8.0, and nginx 1.18.0.

NOTE: You may need to install openssl here if it's not already installed

#### mysql

Now we're going to configure MySQL to create a user and a database:

```
sudo mysql
create user 'rpg'@'localhost' identified by 'password';
create database rpg;
grant all on rpg.* to 'rpg'@'localhost';
flush privileges;
```

#### nginx

Getting nginx configured can be tricky.
First, we will become root for all this work.

```
sudo -i
```

Now we can `rm` the default host and touch the new one.

```
rm /etc/nginx/sites-enabled/default
touch /etc/nginx/sites-enabled/rpg.swiftirc.dev
```

Let's edit that new file with your favorite editor to contain the following:

```
server {
    server_name rpg.swiftirc.dev _;
    root /home/rohara/Workspace/personal/SwiftRPG-web/public;
    listen 80;
    server_tokens off;

    client_max_body_size 50m;

    location ~ ^/dist/.* {
       root /home/rohara/Workspace/personal/SwiftRPG-map;
       index index.html;
    }

    location ~ ^/map {
       root /home/rohara/Workspace/personal/SwiftRPG-map;
       rewrite ^/map/?(.*) /dist/$1 break;
    }

    index  index.php index.html index.htm;
    location ~ \.php {
        include         fastcgi_params;
        fastcgi_index   index.php;
        fastcgi_pass    unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param   SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param   SCRIPT_NAME        $fastcgi_script_name;
        fastcgi_intercept_errors on;
    }

    location / {
        index index.php;
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

#### /etc/hosts

Add `127.0.0.1 rpg.swiftrpg.dev` to your /etc/hosts file.
In Windows this requires running Notepad as an administrator and
editing `C:\Windows\System32\drivers\etc\hosts`. If you do not
see that file in the list, be sure to select `All Files` from the
dropdown at the bottom right of the Open menu.

#### .env

Next, copy the .env file, generate a key, and make any modifications you may need:

```
cp .env.example .env
php artisan key:generate
```

### Run Migrations

```
php artisan migrate --seed
```

### Load it in Your Browser

Open up your new development environment!

```
http://rpg.swiftirc.dev/
http://rpg.swiftirc.dev/map
```