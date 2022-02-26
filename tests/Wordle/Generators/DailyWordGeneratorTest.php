<?php

namespace Wordle\Tests\Generators;

use DateTimeZone;
use Generator;
use PHPUnit\Framework\TestCase;
use Wordle\Generators\DailyWordGenerator;

class DailyWordGeneratorTest extends TestCase
{
    public function testGeneration()
    {
        $generator = new DailyWordGenerator();
        $dateTime = new \DateTime('2022-01-01', new \DateTimeZone('UTC'));

        $words = [];
        for ($i = 0; $i <= 50; $i++) {
            $generator->setDate($dateTime->add(new \DateInterval('P1D')));
            $words[] = $generator->generateWord();
        }

        $words = array_unique($words);

        $this->assertCount(50, $words);
    }

    public function testShareString()
    {
        $generator = new DailyWordGenerator();
        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $generator->setDate($dateTime->add(new \DateInterval('P1D')));
        $this->assertStringContainsString(
            $dateTime->format('Y-m-d'),
            $generator->getShareString()
        );
    }
}
