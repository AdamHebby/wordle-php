<?php

namespace Wordle\Output;

use PHPUnit\Framework\TestCase;

class KeyboardOutputTest extends TestCase
{
    public function testGetOutput()
    {
        $keyboard = new KeyboardOutput();

        $output =
            "┌─┬─┬─┬─┬─┬─┬─┬─┬─┬─┐\n" .
            "│Q│W│E│R│T│Y│U│I│O│P│\n" .
            "└┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┘\n" .
            " │A│S│D│F│G│H│J│K│L│\n" .
            " └─┼─┼─┼─┼─┼─┼─┼─┼─┘\n" .
            "   │Z│X│C│V│B│N│M│\n" .
            "   └─┴─┴─┴─┴─┴─┴─┘\n";
        $this->assertEquals($output, $keyboard->getOutput());
    }
    public function testGetOutputColours()
    {
        $keyboard = new KeyboardOutput();

        $l = OutputFormatter::formatString(
            'E',
            OutputFormatter::FORMAT_GREEN
        );

        $keyboard->colorCharKey('E', OutputFormatter::FORMAT_GREEN);

        $output =
            "┌─┬─┬─┬─┬─┬─┬─┬─┬─┬─┐\n" .
            "│Q│W│{$l}│R│T│Y│U│I│O│P│\n" .
            "└┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┘\n" .
            " │A│S│D│F│G│H│J│K│L│\n" .
            " └─┼─┼─┼─┼─┼─┼─┼─┼─┘\n" .
            "   │Z│X│C│V│B│N│M│\n" .
            "   └─┴─┴─┴─┴─┴─┴─┘\n";
        $this->assertEquals($output, $keyboard->getOutput());
    }

    public function testGetOutputSeveralColours()
    {

        $keyboard = new KeyboardOutput();

        $l = OutputFormatter::formatString(
            'E',
            OutputFormatter::FORMAT_GREEN
        );

        $keyboard->colorCharKey('E', OutputFormatter::FORMAT_GREEN);
        $keyboard->colorCharKey('E', OutputFormatter::FORMAT_AMBER);
        $keyboard->colorCharKey('E', OutputFormatter::FORMAT_INVALID);

        $output =
            "┌─┬─┬─┬─┬─┬─┬─┬─┬─┬─┐\n" .
            "│Q│W│{$l}│R│T│Y│U│I│O│P│\n" .
            "└┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┘\n" .
            " │A│S│D│F│G│H│J│K│L│\n" .
            " └─┼─┼─┼─┼─┼─┼─┼─┼─┘\n" .
            "   │Z│X│C│V│B│N│M│\n" .
            "   └─┴─┴─┴─┴─┴─┴─┘\n";
        $this->assertEquals($output, $keyboard->getOutput());
    }
}
