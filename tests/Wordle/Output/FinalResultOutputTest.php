<?php

namespace Wordle\Tests\Output;

use PHPUnit\Framework\TestCase;
use Wordle\Output\FinalResultOutput;

class FinalResultOutputTest extends TestCase
{
    public function testShareString()
    {
        $output = new FinalResultOutput();

        $output->setShareString('SHARE STRING TEST');

        $this->assertStringContainsString(
            'SHARE STRING TEST',
            $output->getOutput()
        );
    }

    public function testWordleAttemptsGeneratesColorGrids()
    {
        $output = new FinalResultOutput();
        $output->addWordleAttempt('GGGGG');
        $output->addWordleAttempt('GAIAG');

        $this->assertStringContainsString('🟩🟩🟩🟩🟩', $output->getOutput());
        $this->assertStringContainsString('🟩🟨⬛🟨🟩', $output->getOutput());
    }
}
