# Development guide
## 1. Tech stack
- Symfony 6.1.8
- PHP 8.1
- MySQL 8.0.29

## 2. Diagram
![alt text](https://github.com/viendang1988/arent-api/blob/main/docs/diagram.png?raw=true)
## 3. Build code
- Run composer to build vendor
  ``composer install``

- Define your `.env.local` by coping from .env

  ### Config Database
  ```
  MYSQL_USER=
  MYSQL_PASSWORD=
  MYSQL_DATABASE=
  MYSQL_VERSION=
  MYSQL_HOST=
  MYSQL_PORT=
  ```
  ### JWT config

  Create secret and public key for JWT

  ``bin/console lexik:jwt:generate-keypair``

## 4. Migrate Database
- Create the database
- Run this command to create tables
  ```shell
    bin/console doctrine:migrations:migrate
  ```

## 5. How to use
### Start web server

Start web server, example http://localhost:8000
  ```
  symfony serve
  ```

PLEASE READ all the documents in [/docs](https://github.com/viendang1988/arent-api/tree/main/docs) to know all APIs
