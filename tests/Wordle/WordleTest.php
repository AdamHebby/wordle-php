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
            self::format(' R ', 'I', false) .
            self::format(' A ', 'I', false) .
            self::format(' I ', 'I', false) .
            self::format(' L ', 'I', false) .
            self::format(' S ', 'G', false),
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
            self::format(' T ', 'G', false) .
            self::format(' E ', 'G', false) .
            self::format(' A ', 'I', false) .
            self::format(' T ', 'G', false) .
            self::format(' S ', 'G', false),
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
            self::format(' T ', 'G', false) .
            self::format(' E ', 'G', false) .
            self::format(' A ', 'I', false) .
            self::format(' R ', 'I', false) .
            self::format(' S ', 'G', false),
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

        $this->assertStringNotContainsString('│' . self::format('E', 'G') . '│', $output);

        $this->assertStringContainsString(
            self::format(' T  E  S  T  S ', 'G', false),
            $output
        );
        $this->assertStringContainsString('TESTSHARESTRING', $output);
        $this->assertStringContainsString(
            "⬛⬛⬛⬛🟩\n" .
            "🟩🟩⬛🟩🟩\n" .
            "🟩🟩⬛⬛🟩\n" .
            "🟩🟩🟩🟩🟩\n",
            $output
        );
    }

    public function testGeneratorReturnsNull()
    {
        $generator = new FixedTestGenerator();
        $this->expectException(\Exception::class);
        $wordle = new Wordle($generator);
        $wordle->attemptGuess("Throws");
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
