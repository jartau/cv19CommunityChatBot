# Covid-19 chatbot community

## Install
Install compsoser
```
composer install
```
Set the domain in APP_URL var in .env file
```
APP_URL=https://my.domain.here
```
Add your Telegram token in .env file
```
TELEGRAM_TOKEN=telegrem-token
```
Set telegram web hook using the following command:
```
php artisan register:telegram
```
