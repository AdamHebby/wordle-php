<?php

namespace Wordle\Tests\Output;

use PHPUnit\Framework\TestCase;
use Wordle\Output\OutputFormatter;
use Wordle\Output\WordleOutput;

class WordleOutputTest extends TestCase
{
    public function testGetOutputReturnsWordles()
    {
        $output = new WordleOutput();

        $formattedWord = OutputFormatter::formatString(
            'F',
            OutputFormatter::FORMAT_GREEN
        ) . 'ormatted';

        $output->addWordleAttempt('Tests1');
        $output->addWordleAttempt('Tests2');
        $output->addWordleAttempt($formattedWord);

        $outputString = $output->getOutput();

        $this->assertStringContainsString('Tests1', $outputString);
        $this->assertStringContainsString('Tests2', $outputString);
        $this->assertStringContainsString($formattedWord, $outputString);
    }
}
