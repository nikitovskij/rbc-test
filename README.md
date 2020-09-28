## Setup

#### Installation

```
$ git clone https://github.com/nikitovskij/rbc.git
```
Run commands from `rbc` folder
```
$ composer install
$ cp .env.example .env
```
Open `.env` file and change DB connection
```
DB_CONNECTION=sqlite
```
Delete or comment `DB_DATABASE` variable
```
# DB_DATABASE=
```
Generate APP_KEY
```
$ php artisan key:generate
```

#### Launch

```
$ php artisan serv
```
Open in browser.

http://127.0.0.1:8000


## Example
Test app on <a href="https://rbc-test.herokuapp.com/">Heroku</a>

## REQUIREMENTS
* PHP 7.4+
