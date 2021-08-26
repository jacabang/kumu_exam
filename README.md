<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## After Clone please run the following:

- run `composer update` on your terminal but go to the folder were the project is cloned.
- create <b>kumu_exam</b> databased on mysql.
- run `php artisan migrate --seed` to generate tables on to the create database.
- make sure you have redis installed on your computer
- run `redis-server` on your terminal
- run `redis-cli` on your terminal
- run `php artisan passport:client --personal` to generate personal token for bearer token generation upon using the payloads for fetching the user list on github using this application
- run `php artisan optimize`
- run `php artisan serve` to generate an server IP for the project

### create a <b>.env</b> file on the folderproject and copy the code block bellow

<pre>
APP_NAME=Laravel<br>
APP_ENV=local<br>
APP_KEY=base64:FHPCvy/Pyc7TX1Rcp5Di2iE51eWUs4UWQ6HLoz9/sN4=<br>
APP_DEBUG=true<br>
APP_URL=http://localhost<br>
<br>
LOG_CHANNEL=stack<br>
LOG_LEVEL=debug<br>
<br>
DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1<br>
DB_PORT=3306<br>
DB_DATABASE=kumu_exam<br>
DB_USERNAME=root<br>
DB_PASSWORD=<br>
<br>
BROADCAST_DRIVER=log<br>
CACHE_DRIVER=file<br>
FILESYSTEM_DRIVER=local<br>
QUEUE_CONNECTION=sync<br>
SESSION_DRIVER=file<br>
SESSION_LIFETIME=120<br>
<br>
MEMCACHED_HOST=127.0.0.1<br>
<br>
REDIS_CLIENT=predis<br>
REDIS_HOST=127.0.0.1<br>
REDIS_PASSWORD=null<br>
REDIS_PORT=6379<br>
<br>
MAIL_MAILER=smtp<br>
MAIL_HOST=mailhog<br>
MAIL_PORT=1025<br>
MAIL_USERNAME=null<br>
MAIL_PASSWORD=null<br>
MAIL_ENCRYPTION=null<br>
MAIL_FROM_ADDRESS=null<br>
MAIL_FROM_NAME="${APP_NAME}"<br>
<br>
AWS_ACCESS_KEY_ID=<br>
AWS_SECRET_ACCESS_KEY=<br>
AWS_DEFAULT_REGION=us-east-1<br>
AWS_BUCKET=<br>
AWS_USE_PATH_STYLE_ENDPOINT=false<br>
<br>
PUSHER_APP_ID=<br>
PUSHER_APP_KEY=<br>
PUSHER_APP_SECRET=<br>
PUSHER_APP_CLUSTER=mt1<br>
<br>
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"<br>
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"<br>
</pre>

### ALL Routes

API Route | Action | Payload | Remarks | Description
------------ | ------------- | ------------- | ------------- | -------------
```/login``` | Post | <pre>{<br />"email": "jeffreycabang@gmail.com",<br />"password": "123qwe"<br />}</pre> |  | Login is the requirements to access ```/fetchUser```
```/register``` | Post | <pre>{<br />"name": "Jeffrey Cabang",<br />"email": "jeffreycabang@gmail.com",<br />"password": "123qwe"<br />"confirmed_password": "123qwe"<br/>}</pre> | Upon Register it will automatically login | To register a user to the database.
```/fetchUser``` | Post | None | Bearer Token Required | This pulls user data from github if no request occur or request has been made not exceeding 2 Minutes.
```/logout``` | Post | None | Bearer Token Required | Remove all token available for the user.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
