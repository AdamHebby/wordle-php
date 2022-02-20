<?php

namespace Wordle;

/**
 * Wordle Validator!
 */
class Validator
{
    /**
     * PSpell dictionaries for validating a word is real
     *
     * @var array<int>
     */
    private $dictionaries;

    /**
     * Word Selected from Generator
     *
     * @var null|string
     */
    private $word;

    /**
     * Validator Constructor, will generate dictionaries
     */
    public function __construct()
    {
        $dicts = [
            pspell_new('en')
        ];

        foreach ($dicts as $dict) {
            if (!is_int($dict)) {
                throw new \Exception('Dictionary not loaded');
            }
        }

        // @phan-suppress-next-line Validated dictionaries are ints
        $this->dictionaries = $dicts;
    }

    /**
     * Validate that a word is a real word. Does not check if we use that word
     *
     * @param string $word
     *
     * @return bool
     */
    public function validateRealWord(string $word): bool
    {
        foreach ($this->dictionaries as $dict) {
            if (pspell_check($dict, $word)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Set the word we're aiming for
     *
     * @param string $word
     *
     * @return void
     */
    public function setWord(string $word): void
    {
        $this->word = strtolower(trim($word));
    }

    /**
     * Validate if the guess is correct or not
     *
     * @param string $word
     *
     * @return bool
     */
    public function validateGuess(string $word): bool
    {
        return strtolower(trim($word)) === $this->word;
    }
}
