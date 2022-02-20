<?php

namespace Wordle\Tests\Output;

use PHPUnit\Framework\TestCase;
use Wordle\Output\OutputHandler;

class OutputHandlerTest extends TestCase
{
    public function testAddTemporaryOutput()
    {
        $output = new OutputHandler('TEST');

        $output->addTemporaryOutput('temp output');

        $this->assertStringContainsString('temp output', $output->getOutput());
        $this->assertStringNotContainsString('temp output', $output->getOutput());
    }

    public function testGetFinalOutput()
    {
        $output = new OutputHandler('TEST SHARE');

        $this->assertStringContainsString('TEST SHARE', $output->getOutput(true));
        $this->assertStringContainsString('SHARE:', $output->getOutput(true));
        $this->assertStringContainsString('Guesses:', $output->getOutput(true));
    }

    public function testAddValidGuess()
    {
        $output = new OutputHandler('TEST SHARE');
        $output->addValidGuess('Test');

        $this->assertStringContainsString('🟩🟩🟩🟩', $output->getOutput(true));
    }
    public function testAddInvalidGuess()
    {
        $output = new OutputHandler('TEST SHARE');
        $output->addInvalidGuess('Test', 'Tear');

        $this->assertStringContainsString('🟩🟩⬛⬛', $output->getOutput(true));
        $this->assertStringContainsString('Guesses: 1', $output->getOutput(true));
    }
}
