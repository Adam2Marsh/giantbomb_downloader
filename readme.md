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
1. ```docker-compose up -d```
2. ```docker exec -it gb_php php artisan migrate```
3. ```docker exec -it gb_php php artisan db:seed```