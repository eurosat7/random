# Random

This small lib generates usernames, passwords, tokens.

It has some nice defaults, but you can expand it should you ever need to.

## usage

```php
    use Eurosat7\Random\CustomGenerator;use Eurosat7\Random\Generator;
    
    $numerical = Generator::numerical();
    $password = Generator::password();
    $easy = CustomGenerator::easy();
    $speakable = CustomGenerator::speakable();
```

### power user

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
          ... Charsets::umlaut(),
        ],
        Charsets::explosives(),
    ], 32, false);
```

## check code

Have `make`, `docker` and `docker-compose` installed.

Run `make init` once to install additional developer packages and get the autoloader build.

For testing the docker instance should be started - can be done with `make start`.

When you are done with testing you can stop the docker instance with `make stop`.

### check code functionality

```sh
    make docker-php-test
```

It just runs `test/test.php` in a docker instance.

### check code quality

```sh
    make test
```

Will run `rector`, `phpcpd`, `phpmd`, `phpstan`,  `psalm` and `phan`.

#### do more with the code

```sh
    make pdepend
```

```sh
    make phpdoc
```

```sh
    make phpinsights
```
