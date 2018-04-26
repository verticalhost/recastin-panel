# ReCast

## What is ReCast?

ReCast is a multi platform streaming tool written in PHP and uses nginx RTMP. You can stream through one server to multiple services

## Installation

* You have to install a nginx server with rtmp support to ```/opt/nginx-rtmp/``` or something else
* Checkout this project, copy .env.dist to .env and adjust the settings
* Run ```composer install --no-dev -o```
* Generate JWT Keys, following [Documentation](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/HEAD/Resources/doc/index.md#installation)
* Create the database ```php bin/console doctrine:migrations:migrate```
* Create a new crontab entry which runs every minute ```php bin/console recast:cron```
* Create a new user with ```php bin/console recast:create:user```
* Environment variable ``APP_HOST`` should point to a http server, nginx rtmp does not support https.

### Environment variable overview
| Name                  | Description                                                       | Example                                          |
|-----------------------|-------------------------------------------------------------------|--------------------------------------------------|
| APP_ENV               | Which environment it runs                                         | prod                                             |
| DATABASE_URL          | Database credentials as URL                                       | DATABASE_URL=mysql://USER:PASS@HOST:3306/DB_NAME |
| NGINX_CONFIG_DIR      | Folder where nginx.conf is located                                | /opt/nginx-rtmp/conf/                            |
| APP_HOST              | URL which is used in nginx rtmp conf, This address should be http | https://try.recast.in                            |
| NGINX_RESTART_COMMAND | Reload command for nginx rtmp                                     | systemctl reload nginx-rtmp                      |

**Docker Setup will be following**

## Screenshots

![Dashboard](https://i.imgur.com/6gcqWTh.png)

![List Streams](https://i.imgur.com/E5FVy9K.png)

![Edit Stream](https://i.imgur.com/PHYjnQn.png)

![Add Endpoint](https://i.imgur.com/bYteEQR.png)

![Setup](https://i.imgur.com/ZfP7Tpv.png)