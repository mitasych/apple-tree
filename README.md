Apple Tree project
==================

Apple Tree application based on [Yii 2 Advanced Project Template](https://github.com/yiisoft/yii2-app-advanced).

The application includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

The application is configured as single-domain-application. Example configuration for nginx is in the /vagrant/nginx/app-single-domain.conf file.

## Requirements
The minimum requirement by this project template is that your Web server supports PHP 7.1

## Recommended environvent
*nix-like OS

DBMS MySql 5.5+

Web-server nginx 1.16+



## Deployment

1. Clone this repo to your server
    ```
    git clone https://github.com/mitasych/apple-tree
    ```
2. In the app-root [install composer](https://getcomposer.org/download/) and install and update packages

   ```
   php composer.phar update
   ``` 

3. In terminal execute the `init` command.
    ```
    /path/to/php-bin/php /path/to/yii-application/init
    ```
4. Create a new database and adjust the `components['db']` configuration in `/path/to/yii-application/common/config/main-local.php` accordingly.

5. Open a console terminal, apply migrations with command 
    ```
    /path/to/php-bin/php /path/to/yii-application/yii migrate
    ```

6. In terminal execute the `crontab -e` command and set cron task
    ```
    * * * * * /path/to/php-bin/php /path/to/yii-application/yii apple/rot
    ```

## Admin panel

login: admin

password: admin

In single-domain-application path to admin panel `http(s)://your-app.domain/admin`





