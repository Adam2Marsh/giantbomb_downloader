[![Build Status](https://travis-ci.org/Adam2Marsh/giantbomb_downloader.svg?branch=gbd_vue)](https://travis-ci.org/Adam2Marsh/giantbomb_downloader)

### Integration Testing
You need to run the following

```bash
php artisan migrate:refresh && php artisan db:seed && php artisan db:seed --class CreateTestDataForTestsSeeder
```

Then you can run

```bash
vendor/bin/phpunit
```


### Run Inside Docker
1. ```cp .env.docker .env```
2. ```docker-compose up -d```
3. ```docker exec -it gb_php php artisan migrate```
4. ```docker exec -it gb_php php artisan db:seed```

### Running Locally
1. ```php artisan migrate:refresh && php artisan db:seed```
2. ```supervisord -c supervisord.conf```
3. ```npm run dev```