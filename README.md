# Random

This small lib generates usernames, passwords, tokens.

It has some nice defaults, but you can expand it should you ever need to.

## usage

```php
    use Eurosat7\Random\Generator;
    
    $numerical = Generator::numerical();
    $password = Generator::password();
    $easy = Generator::easy();
    $speakable = Generator::speakable();
```

### power user

```php
    use Eurosat7\Random\Charsets;
    use Eurosat7\Random\Generator;
    use Eurosat7\Random\Transformer;

    $mySet = Transformer::stringToArray('All your base are belong to us!');
    $mySet = Transformer::removeFromSet($mySet, ['!']);
    $mySet = Transformer::removeFromSet($mySet, Charsets::whitespace());
    $sequence = Generator::generate([
        $mySet,
        Transformer::setToUppercase(Charsets::nonexplosives()),
        [
          ... Charsets::vowels(),
          ... Charsets::umlaut(),
        ],
        Charsets::whitespace(),
    ], 32, false);
```
