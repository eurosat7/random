# Random

This small lib generates usernames, passwords, tokens.

It has some nice defaults, but you can expand it should you ever need to.

## Disclaimer

This code is not mathematical proofen to be perfectly random.

I ran some tests with bigger numbers and it is random enough for me.

Decide for yourself if you need more.

All randomess I did comes from random_int().

The algorythm I used to shuffle the positions of each character is a Fisher–Yates shuffle.

## Usage

```php
    use Eurosat7\Random\CustomGenerator;use Eurosat7\Random\Generator;
    
    $numerical = Generator::numerical();
    $password = Generator::password();
    $easy = CustomGenerator::easy();
    $speakable = CustomGenerator::speakable();
```

### Power Useage

```php
    use Eurosat7\Random\Arrays;
    use Eurosat7\Random\Charsets;
    use Eurosat7\Random\Generator;
    use Eurosat7\Random\Transformer;

    $mySet = str_split('All your base are belong to us!');
    $mySet = Arrays::removeFromSet($mySet, ['!']);
    $mySet = Arrays::removeFromSet($mySet, Charsets::whitespace());
    $sequence = Generator::generate([
        $mySet,
        Transformer::toUppercase(Charsets::nonexplosives()),
        [
          ... Charsets::vowels(),
          ... Charsets::german(),
        ],
        Charsets::explosives(),
    ], 32, false);
```

## Check Code

Have `make`, `docker` and `docker-compose` installed.

Run `make init` once to install additional developer packages and get the autoloader build.

For testing the docker instance should be started - can be done with `make start`.

When you are done with testing you can stop the docker instance with `make stop`.

### Benchmark

To run benchmarks for speed and memory usage:

```sh
docker-compose exec webserver php /var/www/html/benchmark.php
```

### Preloading

A preloader is available at `src/preload.php`. It is configured in `php.ini` to optimize boot time.

### Check Code Functionality

```sh
    make docker-php-test
```

It just runs `test/test.php` in a docker instance.

### Check Code Quality

```sh
    make test
```

Will run `rector`, `phpcpd`, `phpmd`, `phpstan`,  `psalm` and `phan`.

#### Do more with the code

```sh
    make pdepend
```

```sh
    make phpdoc
```

```sh
    make phpinsights
```
