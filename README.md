# App Records

An application to list records in a movement, like Deadlift, Back Squat and Bench Press.

------

## Functionalities

An endpoint to list records in a movement, with raking.

curl --location 'http://0.0.0.0:8020/records?movement=1'

curl --location 'http://0.0.0.0:8020/records?movement=Deadlift'

------

### Technologies
- PHP 8.4
- MySQL 8.0.32

------

## Instructions for run this app:

### First time

Clone project in your projects folder.
```shell script
$ git clone git@github.com:fatorx/app-records.git && cd app-records
```
Copy .env.dist to .env and adjust values in the .env file to your preferences.
```shell script
cp .env.dist .env 
```

Add permissions to folder data (MySQL and logs) and api/data (logs), this is where the persistence files will be kept.
```shell script
chmod 755 data
chmod 755 api/data/logs
```

Mount the environment based in docker-compose.yml.
```shell script
docker-compose up -d --build
```

Install PHP dependencies
```shell script
docker exec -it app-records-php php composer.phar install
```

Access database to create tables (the name "records" is based in the parameter config APP in .env).
```shell script
docker exec -it app-records mysql -u root -p -D records
```
After access the docker with above command, at the MySQL prompt type:  
```shell script
source /docker-entrypoint-initdb.d/dump.sql
```

------
### Working routine 
```shell script
docker-compose up -d
```
------

### Tests Inside Docker 
```shell script
docker exec -it app-records-php bash
```
And then do this
```shell script
vendor/bin/phpunit --testdox --testsuite "Records Test Suite"
```

------
### Tests Outside Docker
```shell script
docker exec -it app-records-php vendor/bin/phpunit --testdox --testsuite "Records Test Suite"
```

------
## Licence

[MIT](https://github.com/fatorx/app-records/blob/main/LICENSE.md)


