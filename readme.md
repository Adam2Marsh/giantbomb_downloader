### Integration Testing
You need to run the following

```bash
php artisan migrate:refresh && php artisan db:seed && php artisan db:seed --class VideoFactory
```

Then you can run

```bash
vendor/bin/phpunit
```