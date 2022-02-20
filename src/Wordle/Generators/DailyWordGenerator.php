<?php

namespace Wordle\Generators;

/**
 * Using todays date, will seed a pseudo-random number and get a word to use
 */
final class DailyWordGenerator extends BaseGenerator
{
    /**
     * Current timestamp (Hopefully)
     *
     * @var int
     */
    private $date;

    public function __construct(int $wordLength = self::DEFAULT_WORD_LENGTH)
    {
        $this->setDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $this->wordLength = $wordLength;
    }

    /**
     * Set the date, mostly for testing purposes
     *
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date->setTime(0, 0, 0, 0)->getTimestamp();
    }

    protected function getWordPosition(int $maxLine): int
    {
        // We seed `rand` with the current DATE to synchronize a daily word
        srand($this->date);

        return rand(0, $maxLine);
    }

    public function getShareString(): string
    {
        $date = date('Y-m-d', $this->date);

        return "AdamHebby/wordle-php $date Daily \n";
    }
}
