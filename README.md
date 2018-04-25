# ReCast

## What is ReCast?

ReCast is a multi platform streaming tool written in PHP and uses nginx RTMP. You can throught your servers to multiple services simultaneously like Twitch, YouTube, Mixer and custom RTMP.

## Installation

* You have to install a nginx server with rtmp support to ```/opt/nginx-rtmp/``` or something else
* Checkout this project and adjust the .env file
* Create the database ```php bin/console doctrine:schema:create```
* Go to ``public/theme``, run ``npm install`` and copy the generated files to public (``cp -R static ..``)
* Create a new crontab entry which runs every minute ```php bin/console recast:cron```
* Create a new user with ```php bin/console recast:create:user```

## Screenshots

![Dashboard](https://i.imgur.com/CJFRqFM.png)

![List Streams](https://i.imgur.com/LGBcyBu.png)

![Add Endpoint](https://i.imgur.com/lGhD6YS.png)