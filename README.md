# ReCast

## What is ReCast?

ReCast is a multi platform streaming tool written in PHP and uses nginx RTMP. You can stream through one server to multiple services

## Installation

* You have to install a nginx server with rtmp support to ```/opt/nginx-rtmp/``` or something else
* Checkout this project, copy .env.dist to .env and adjust the settings
* Run ```composer install --no-dev -o```
* Create the database ```php bin/console doctrine:schema:create```
* Go to ``public/theme``, run ``npm install`` and copy the generated files to public (``cp -R static ..``)
* Create a new crontab entry which runs every minute ```php bin/console recast:cron```
* Create a new user with ```php bin/console recast:create:user```

**Docker Setup will be following**

## Screenshots

![Dashboard](https://i.imgur.com/CJFRqFM.png)

![List Streams](https://i.imgur.com/xRi6eQT.png)

![Add Endpoint](https://i.imgur.com/OvLihhw.png)

![Setup](https://i.imgur.com/gPDnIfr.png)