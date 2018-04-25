# ReCast

## What is ReCast?

ReCast is a multi platform streaming tool written in PHP and uses nginx RTMP. You can stream through one server to multiple services

## Installation

* You have to install a nginx server with rtmp support to ```/opt/nginx-rtmp/``` or something else
* Checkout this project, copy .env.dist to .env and adjust the settings
* Run ```composer install --no-dev -o```
* Generate JWT Keys, following [Documentation](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/HEAD/Resources/doc/index.md#installation)
* Create the database ```php bin/console doctrine:migrations:migrate```
* Go to ``public/theme``, run ``npm install`` and copy the generated files to public (``cp -R static ..``)
* Create a new crontab entry which runs every minute ```php bin/console recast:cron```
* Create a new user with ```php bin/console recast:create:user```
* Environment variable ``APP_HOST`` should point to a http server, nginx rtmp does not support https.

**Docker Setup will be following**

## Screenshots

![Dashboard](https://i.imgur.com/CJFRqFM.png)

![List Streams](https://i.imgur.com/xRi6eQT.png)

![Add Endpoint](https://i.imgur.com/OvLihhw.png)

![Setup](https://i.imgur.com/gPDnIfr.png)