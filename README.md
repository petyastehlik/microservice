## Prerequisites

To run this project you will need:

```
Docker
Composer
PHP >= 7.4
```

## Installing

```
git clone https://github.com/petyastehlik/microservice ms
cd ms
make start
# to run the example use
make run
```

## Using the application

1. To run from inside the container
    ```
    make exec  
    ```
1.  You can display syntax for using the aplication
    ```
    ./bin/console store -h
    ```
    e.g.:
    
    ```
    ./bin/console store users 1 comments --format=json,xml,html 
    ```
    
3. By default, created output files are stored in _./temp/output_ directory. You can change this in **config.neon** file.
   To disable API caching just change the _default_ttl_ parameter to 0.
    
## Running the tests

```
make test
```

# TODO list

- Support for Windows (without make; used docker image has some SSL bug)
- Differentiate between different environments - dev/staging/production
    - config, DI container rebuilding, logs sent to email etc.
- Since the application is using cache, then a cache:clear command or similar would be helpful
- Add static code analysis (phpstan)
- Add at least a simple integration test
- Finish unit tests marked as incomplete 
- Improve docker-compose.yml, use more suitable image (php:7.4-cli-alpine3.11) with smaller footprint
- Rest of TODOs can be found directly in code