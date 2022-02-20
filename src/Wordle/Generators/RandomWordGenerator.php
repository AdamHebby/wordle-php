<?php

namespace Wordle\Generators;

/**
 * Generates a completely random word from the list, unless setWordIndex is used
 */
final class RandomWordGenerator extends BaseGenerator
{
    public function getShareString(): string
    {
        return "AdamHebby/wordle-php Random {$this->wordLength} #{$this->selectedWordIndex} \n";
    }

    /**
     * Forcefully set the word index, used by bin/wordle
     *
     * @param int $wordIndex
     *
     * @return void
     */
    public function setWordIndex(int $wordIndex): void
    {
        $this->selectedWordIndex = $wordIndex;
        $this->forceSelection = true;
    }
}
