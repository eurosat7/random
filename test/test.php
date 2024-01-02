<?php
// please run from inside docker.
// > make docker-php-test

declare(strict_types=1);

use Eurosat7\Random\Charsets;
use Eurosat7\Random\Transformer;

include(dirname(__DIR__) . "/vendor/autoload.php");

//<editor-fold desc="Charsets">
expect("numeric", Charsets::numeric());
expect("alphanumeric", Charsets::alphanumeric());
expect("special", Charsets::special());
expect("umlaut", Charsets::umlaut());

expect("explosives", Charsets::explosives());
expect("vowels", Charsets::vowels());
expect("nonexplosives", Charsets::nonexplosives());
expect("whitespace", Charsets::whitespace());
//</editor-fold>

//<editor-fold desc="Transformer">
expect("removeFromSet", Transformer::removeFromSet(Charsets::vowels(), ['a', 'o']));
expect("setToUppercase", Transformer::setToUppercase([... Charsets::vowels(), ... Charsets::explosives()]));
expect("setToLowercase", Transformer::setToLowercase(['P', 'H', 'P']));
expect("setToRandomcase", Transformer::setToRandomcase([... Charsets::vowels(), ... Charsets::explosives()]));

expect("stringToArray", Transformer::stringToArray('Hello world!'));

$l = "l";
$array = ['H', 'e', $l, $l, 'o'];

expect("arrayToString", Transformer::arrayToString($array));
//</editor-fold>

//<editor-fold desc="Transformer">
expect("password", \Eurosat7\Random\Generator::password());
expect("numerical", \Eurosat7\Random\Generator::numerical());
expect("easy", \Eurosat7\Random\Generator::easy());
expect("speakable", \Eurosat7\Random\Generator::speakable());
//</editor-fold>

function expect(string $label, mixed $realdata, mixed $expecteddata = null): void
{
    if ($expecteddata !== null && $realdata != $expecteddata) {
        echo "KO ";
    } else {
        echo "OK ";
    }
    echo $label . ": ";
    if (is_array($realdata)) {
        var_export($realdata);
    } else {
        echo $realdata;
    }
    echo "\r\n";
}