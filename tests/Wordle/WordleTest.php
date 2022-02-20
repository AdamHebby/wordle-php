<?php

namespace Wordle\Tests;

use PHPUnit\Framework\TestCase;
use Wordle\Generators\RandomWordGenerator;
use Wordle\Output\OutputFormatter;
use Wordle\Tests\Mock\FixedTestGenerator;
use Wordle\Wordle;

class WordleTest extends TestCase
{
    public function testBasic()
    {
        $generator = new FixedTestGenerator();

        $generator->setWords([
            'tests',
            'taste'
        ]);
        $wordle = new Wordle($generator);

        $this->assertTrue($wordle->isValidGuess('tests'));
        $this->assertFalse($wordle->isValidGuess('taste'));

        $wordle = new Wordle($generator);
        $this->assertTrue($wordle->isValidGuess('taste'));
        $this->assertFalse($wordle->isValidGuess('tests'));
    }

    public function testAttemptGuessInvalidWord()
    {
        $wordle = new Wordle(new RandomWordGenerator());

        $wordle->attemptGuess('dassd');
        $this->assertStringContainsString(
            'ERR: dassd is not a real word!',
            $wordle->getOutput()
        );

        $this->assertStringNotContainsString(
            'ERR: dassd is not a real word!',
            $wordle->getOutput()
        );
    }
    public function testAttemptGuessWrongLength()
    {
        $wordle = new Wordle(new RandomWordGenerator());

        $wordle->attemptGuess('invalid');
        $this->assertStringContainsString(
            "ERR: The word you're looking for is",
            $wordle->getOutput()
        );
        $this->assertStringNotContainsString(
            "ERR: The word you're looking for is",
            $wordle->getOutput()
        );

        $wordle->attemptGuess('valid');
        $this->assertStringNotContainsString(
            "ERR: The word you're looking for is",
            $wordle->getOutput()
        );
    }

    public function testFull()
    {
        $generator = new FixedTestGenerator();
        $generator->setWords([
            'tests'
        ]);
        $wordle = new Wordle($generator);

        // Rails
        $wordle->attemptGuess('rails');
        $output = $wordle->getOutput();

        $this->assertStringContainsString(
            self::formatMany([
                ['rail', 'I', true],
                ['s', 'G', true]
            ]),
            $output
        );

        $this->assertStringContainsString('│' . self::format('R', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('A', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('I', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('L', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('S', 'G') . '│', $output);

        // Teats
        $wordle->attemptGuess('teats');
        $output = $wordle->getOutput();

        $this->assertStringContainsString(
            self::formatMany([
                ['te', 'G', true],
                ['a', 'I', true],
                ['ts', 'G', true],
            ]),
            $output
        );

        $this->assertStringContainsString('│' . self::format('R', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('A', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('I', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('L', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('S', 'G') . '│', $output);
        $this->assertStringContainsString('│' . self::format('T', 'G') . '│', $output);
        $this->assertStringContainsString('│' . self::format('E', 'G') . '│', $output);

        // Tears
        $wordle->attemptGuess('tears');
        $output = $wordle->getOutput();

        $this->assertStringContainsString(
            self::formatMany([
                ['te', 'G', true],
                ['a', 'I', true],
                ['r', 'I', true],
                ['s', 'G', true],
            ]),
            $output
        );

        $this->assertStringContainsString('│' . self::format('R', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('A', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('I', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('L', 'I') . '│', $output);
        $this->assertStringContainsString('│' . self::format('S', 'G') . '│', $output);
        $this->assertStringContainsString('│' . self::format('T', 'G') . '│', $output);
        $this->assertStringContainsString('│' . self::format('E', 'G') . '│', $output);

        $wordle->attemptGuess('tests');
        $output = $wordle->getOutput();

        $this->assertStringContainsString(
            self::format('tests', 'G', false),
            $output
        );
        $this->assertStringNotContainsString('│' . self::format('E', 'G') . '│', $output);

        $this->assertStringContainsString('TESTSHARESTRING', $output);

        $this->assertStringContainsString(
            "⬛⬛⬛⬛🟩\n" .
            "🟩🟩⬛🟩🟩\n" .
            "🟩🟩⬛⬛🟩\n" .
            "🟩🟩🟩🟩🟩\n",
            $output
        );
    }
    private static function formatMany(array $data): string
    {
        $returnString = "";

        foreach ($data as $key) {
            $returnString .= self::format($key[0], $key[1], $key[2] ?? false);
        }

        return $returnString;
    }

    private static function format($char, $color, $each = false)
    {
        $format = null;
        switch ($color) {
            case 'G':
                $format = OutputFormatter::FORMAT_GREEN;
                break;
            case 'A':
                $format = OutputFormatter::FORMAT_AMBER;
                break;
            case 'I':
                $format = OutputFormatter::FORMAT_INVALID;
                break;
        }

        $returnString = "";

        if ($each) {
            foreach (str_split($char) as $c) {
                $returnString .= OutputFormatter::formatString(
                    $c,
                    $format
                );
            }
        } else {
            $returnString = OutputFormatter::formatString(
                $char,
                $format
            );
        }

        return $returnString;
    }
}
