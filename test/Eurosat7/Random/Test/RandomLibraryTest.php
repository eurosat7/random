<?php

declare(strict_types=1);

namespace Eurosat7\Random\Test;

use Eurosat7\Random\Arrays;
use Eurosat7\Random\Charsets;
use Eurosat7\Random\CustomGenerator;
use Eurosat7\Random\Exception\EmptySetException;
use Eurosat7\Random\Exception\InvalidLengthException;
use Eurosat7\Random\Generator;
use Eurosat7\Random\Transformer;
use PHPUnit\Framework\TestCase;
use Throwable;

class RandomLibraryTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testCharsets(): void
    {
        self::assertNotEmpty(Charsets::numeric());
        self::assertNotEmpty(Charsets::lowercase());
        self::assertNotEmpty(Charsets::uppercase());
        self::assertNotEmpty(Charsets::alphanumeric());
        self::assertNotEmpty(Charsets::hexadecimal());
        self::assertNotEmpty(Charsets::special());
        self::assertNotEmpty(Charsets::german());
        self::assertContains('Ä', Charsets::german());
        self::assertContains('ä', Charsets::german());

        self::assertNotEmpty(Charsets::explosives());
        self::assertNotEmpty(Charsets::vowels());
        self::assertNotEmpty(Charsets::nonexplosives());
        self::assertNotEmpty(Charsets::whitespace());
    }

    /**
     * @throws Throwable
     */
    public function testArraysRemoveFromSet(): void
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        $result = Arrays::removeFromSet($vowels, ['a', 'o']);
        self::assertEquals(['e', 'i', 'u'], $result);
    }

    /**
     * @throws Throwable
     */
    public function testArraysPickOne(): void
    {
        $set = ['a'];
        self::assertEquals('a', Arrays::pickOne($set));

        $set = ['a', 'b', 'c'];
        $pick = Arrays::pickOne($set);
        self::assertContains($pick, $set);
    }

    /**
     * @throws Throwable
     */
    public function testArraysPickOneEmpty(): void
    {
        $this->expectException(EmptySetException::class);
        Arrays::pickOne([]);
    }

    /**
     * @throws Throwable
     */
    public function testGeneratorInvalidLength(): void
    {
        $this->expectException(InvalidLengthException::class);
        Generator::numerical(0);
    }

    /**
     * @throws Throwable
     */
    public function testGeneratorNegativeLength(): void
    {
        $this->expectException(InvalidLengthException::class);
        Generator::numerical(-1);
    }

    /**
     * @throws Throwable
     */
    public function testTransformer(): void
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        $upper = Transformer::toUppercase($vowels);
        self::assertEquals(['A', 'E', 'I', 'O', 'U'], $upper);

        $lower = Transformer::toLowercase(['P', 'H', 'P']);
        self::assertEquals(['p', 'h', 'p'], $lower);

        $random = Transformer::toRandomcase($vowels);
        self::assertCount(5, $random);
        foreach ($random as $char) {
            self::assertContains(mb_strtolower($char), $vowels);
        }
    }

    /**
     * @throws Throwable
     */
    public function testMultibyteTransformer(): void
    {
        $umlauts = ['ä', 'ö', 'ü', 'ß'];
        $upper = Transformer::toUppercase($umlauts);
        self::assertEquals(['Ä', 'Ö', 'Ü', 'SS'], $upper); // mb_strtoupper('ß') is 'SS'

        $lower = Transformer::toLowercase(['Ä', 'Ö', 'Ü']);
        self::assertEquals(['ä', 'ö', 'ü'], $lower);
    }

    /**
     * @throws Throwable
     */
    public function testGenerators(): void
    {
        self::assertMatchesRegularExpression('/^[0-9]{8}$/', Generator::numerical());
        self::assertNotEmpty(Generator::password());

        self::assertNotEmpty(CustomGenerator::passwordDE());
        self::assertNotEmpty(CustomGenerator::easy());
        self::assertNotEmpty(CustomGenerator::speakable());
    }

    /**
     * @throws Throwable
     */
    public function testPowerUserSequence(): void
    {
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

        self::assertEquals(32, mb_strlen($sequence));
    }
}
