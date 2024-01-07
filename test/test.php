<?php
// please run from inside docker.
// > make docker-php-test

declare(strict_types=1);

use Eurosat7\Random\Arrays;
use Eurosat7\Random\Charsets;
use Eurosat7\Random\CustomGenerator;
use Eurosat7\Random\Generator;
use Eurosat7\Random\Transformer;

include(dirname(__DIR__) . '/vendor/autoload.php');

//<editor-fold desc="Charsets">
expect('numeric', Charsets::numeric());
expect('alphanumeric', Charsets::alphanumeric());
expect('special', Charsets::special());
expect('umlaut', Charsets::umlaut());

expect('explosives', Charsets::explosives());
expect('vowels', Charsets::vowels());
expect('nonexplosives', Charsets::nonexplosives());
expect('whitespace', Charsets::whitespace());
//</editor-fold>

//<editor-fold desc="Transformer">
expect('removeFromSet', Arrays::removeFromSet(Charsets::vowels(), ['a', 'o']));
expect('setToUppercase', Transformer::toUppercase([... Charsets::vowels(), ... Charsets::explosives()]));
expect('setToLowercase', Transformer::toLowercase(['P', 'H', 'P']));
expect('setToRandomcase', Transformer::toRandomcase([... Charsets::vowels(), ... Charsets::explosives()]));

expect('stringToArray', str_split('Hello world!'));

$l = 'l';
$array = ['H', 'e', $l, $l, 'o'];

expect('arrayToString', implode('', $array));
//</editor-fold>

//<editor-fold desc="Generator">
expect('password', Generator::password());
expect('passwordDE', CustomGenerator::passwordDE());
expect('numerical', Generator::numerical());
expect('easy', CustomGenerator::easy());
expect('speakable', CustomGenerator::speakable());
//</editor-fold>

//<editor-fold desc="power user">
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

expect('generate sequence', $sequence);
//</editor-fold>

function expect(string $label, mixed $realdata, mixed $expecteddata = null): void
{
    if ($expecteddata !== null && $realdata != $expecteddata) {
        echo 'KO ';
    } else {
        echo 'OK ';
    }
    echo $label . ': ';
    if (is_array($realdata)) {
        var_export($realdata);
    }
    if (is_scalar($realdata)) {
        echo $realdata;
    }
    echo "\r\n";
}