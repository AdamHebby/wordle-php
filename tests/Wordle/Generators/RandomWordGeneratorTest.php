<?php

namespace Wordle\Tests\Generators;

use PHPUnit\Framework\TestCase;
use Wordle\Generators\RandomWordGenerator;
use Wordle\Validator;

class RandomWordGeneratorTest extends TestCase
{
    public function testGeneratorDefault()
    {
        $generator = new RandomWordGenerator();

        $this->assertSame(RandomWordGenerator::DEFAULT_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::DEFAULT_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::DEFAULT_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::DEFAULT_WORD_LENGTH, strlen($generator->generateWord()));

        $this->assertNotSame(
            $generator->generateWord(),
            $generator->generateWord()
        );
    }
    public function testGenerator()
    {
        $generator = new RandomWordGenerator(RandomWordGenerator::MAX_WORD_LENGTH);

        $this->assertSame(RandomWordGenerator::MAX_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::MAX_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::MAX_WORD_LENGTH, strlen($generator->generateWord()));
        $this->assertSame(RandomWordGenerator::MAX_WORD_LENGTH, strlen($generator->generateWord()));

        $this->assertNotSame(
            $generator->generateWord(),
            $generator->generateWord()
        );
    }

    public function testForceWord()
    {
        $generator = new RandomWordGenerator();
        $generator->setWordIndex(0);

        $this->assertSame('aback', $generator->generateWord());
    }
}
