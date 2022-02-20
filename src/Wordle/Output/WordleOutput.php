<?php

namespace Wordle\Output;

/**
 * Output for wordle guesses after each guess
 */
final class WordleOutput implements OutputInterface
{
    /**
     * Array of wordle guesses
     *
     * @var array<string>
     */
    private $wordleGuesses = [];

    /**
     * Add a wordle guess! Should be formatted
     *
     * @param string $formattedWord
     *
     * @return void
     */
    public function addWordleAttempt(string $formattedWord): void
    {
        $this->wordleGuesses[] = $formattedWord;
    }

    public function getOutput(): string
    {
        return implode("\n", $this->wordleGuesses);
    }
}
