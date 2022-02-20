<?php

namespace Wordle\Tests\Mock;

use Wordle\Generators\BaseGenerator;

class FixedTestGenerator extends BaseGenerator
{
    public $testWords = [];
    public function setWords(array $words): void
    {
        $this->testWords = $words;
    }
    public function generateWord(): string
    {
        $key = array_key_first($this->testWords);

        $word = $this->testWords[$key];

        unset($this->testWords[$key]);

        return $word;
    }

    public function getShareString(): string
    {
        return "TESTSHARESTRING";
    }
}
