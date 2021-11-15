# q-test-backend


Notes:

Vanilla php app with composer


Run locally with php dev server - steps:

1) create .env file, copy contents from .env.example
    - do not change anything, TEST_MODE variable must be '0' when not testing
    - it will run default on port 9000, if you change port please change BASE_URL in .env file
2) composer install
3) composer dump-autoload
4) start dev server   ```php -S localhost:9000 -t public/```


Run on docker

1) cd docker
2) run  docker-compose up
3) open the app on localhost:9000


Run tests (locally on php dev server)

1) put TEST_MODE="1" in .env file (don't forget to switch back to "0" when finished)
2) set TEST_EMAIL, TEST_PASSWORD & TEST_TOKEN in .env file
        - they need to be valid (we need them to have authenticated user for testing protected routes)
3) run on windows: vendor\bin\phpunit
4) run on linux: php vendor/bin/phpunit
