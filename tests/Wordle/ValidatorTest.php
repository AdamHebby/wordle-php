<?php

namespace Wordle\Tests;

use PHPUnit\Framework\TestCase;
use Wordle\Validator;

class ValidatorTest extends TestCase
{
    public function testValidateRealWord()
    {
        $validator = new Validator();

        $this->assertTrue($validator->validateRealWord('Test'));
        $this->assertTrue($validator->validateRealWord('Tests'));
        $this->assertTrue($validator->validateRealWord('Validate'));
        $this->assertTrue($validator->validateRealWord('Manor'));

        $this->assertFalse($validator->validateRealWord('aaaaaaa'));
        $this->assertFalse($validator->validateRealWord('oahhbsdkjav'));
        $this->assertFalse($validator->validateRealWord('87175623'));
    }

    public function testWordGuess()
    {
        $validator = new Validator();

        $validator->setWord('Test');
        $this->assertTrue($validator->validateGuess('Test'));

        $validator->setWord('Tests');
        $this->assertTrue($validator->validateGuess('Tests'));

        $validator->setWord('Validate');
        $this->assertTrue($validator->validateGuess('Validate'));

        $validator->setWord('Manor');
        $this->assertTrue($validator->validateGuess('Manor'));
    }

    public function testWordGuessCase()
    {
        $validator = new Validator();

        $validator->setWord('TEST');
        $this->assertTrue($validator->validateGuess('TeSt'));

        $validator->setWord('TestS');
        $this->assertTrue($validator->validateGuess('Tests'));

        $validator->setWord('validate');
        $this->assertTrue($validator->validateGuess('VALIDATE'));

        $validator->setWord('MaNoR');
        $this->assertTrue($validator->validateGuess('manor'));
    }
}
