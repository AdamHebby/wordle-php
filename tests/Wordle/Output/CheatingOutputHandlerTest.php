<?php

namespace Wordle\Tests;

use PHPUnit\Framework\TestCase;
use Wordle\Generators\RandomWordGenerator;
use Wordle\Output\CheatingOutput;
use Wordle\Wordle;

class CheatingOutputHandlerTest extends TestCase
{
    public function testCorrectOutput()
    {
        $output = new CheatingOutput();

        // Word = adopt
        $output->addCorrectLetter(0, 'a');
        $output->addValidLetter(1, 'o');
        $output->addInvalidLetter('z');

        $this->assertStringContainsString("above", $output->getOutput());
        $this->assertStringContainsString("Plus 112 more words", $output->getOutput());

        $output->addInvalidLetter('v');
        $this->assertStringNotContainsString("above", $output->getOutput());
        $this->assertStringContainsString("Plus 108 more words", $output->getOutput());

        $output->addInvalidLetter('b');
        $this->assertStringNotContainsString("abbey", $output->getOutput());
        $this->assertStringContainsString("Plus 95 more words", $output->getOutput());

        $output->addCorrectLetter(1, 'd');
        $output->addCorrectLetter(2, 'o');

        $this->assertStringContainsString("adopt", $output->getOutput());
        $this->assertStringContainsString("adore", $output->getOutput());
        $this->assertStringNotContainsString("more words", $output->getOutput());
    }

    public function testOutputDoesntContainUsedWords()
    {
        $output = new CheatingOutput();
        $output->addGuessedWord('adore');

        $output->addCorrectLetter(1, 'a');
        $output->addCorrectLetter(1, 'd');
        $output->addCorrectLetter(2, 'o');

        $this->assertStringContainsString("adopt", $output->getOutput());
        $this->assertStringNotContainsString("adore", $output->getOutput());
    }

    public function testOutputReturnsValidCheats()
    {
        for ($i = 0; $i < 100; $i++) {
            $gen = new RandomWordGenerator();
            $wordle = new Wordle($gen);

            $wordle->attemptGuess('tests');

            $attempts = 0;
            while (stripos($wordle->getOutput(), '┬─┬') !== false) {
                $attempts++;
                $wordle->attemptGuess('?');

                $words = [];
                preg_match('/Suggestions:\n((\w*\n)*)/', $wordle->getOutput(), $words);

                if (empty(trim($words[1]))) {
                    $wordle->attemptGuess('??');
                    echo $wordle->getOutput();
                    $this->fail('No more words but wordle is not solved');
                    break;
                }
                if ($attempts > 25) {
                    $wordle->attemptGuess('??');
                    echo $wordle->getOutput();
                    $this->fail('Too many attempts!');
                    break;
                }

                $words = explode("\n", $words[1]);
                $word  = reset($words);

                $wordle->attemptGuess($word);
            }

            $this->assertStringContainsString('Guesses:', $wordle->getOutput());
        }
    }
}
