<?php

namespace Wordle\Output;

use Wordle\Traits\WordFileAwareTrait;

/**
 * Cheating output, for the cheaty cheaters who can't stand to fail!
 */
class CheatingOutput implements OutputInterface
{
    use WordFileAwareTrait;

    /**
     * Letters that we know are valid, but in the wrong position.
     *
     * Keys should be the position they were attempted in
     *
     * @var array<int,array<string>>
     */
    protected $validLetters = [];

    /**
     * Letters that are correct (IE correct character in the correct position)
     *
     * @var array<int,string>
     */
    protected $correctLetters = [];

    /**
     * Letters that aren't used at all within the final word
     *
     * @var array<string>
     */
    protected $invalidLetters = [];

    /**
     * Words we've already tried, so we don't resuggest them
     *
     * @var array<string>
     */
    protected $guessedWords = [];

    /**
     * The word length we're looking for
     *
     * @var int
     */
    protected $wordLength = 5;

    /**
     * Set the word Length for the word file to load
     *
     * @param int $wordLength
     *
     * @return self
     */
    public function setWordLength(int $wordLength): self
    {
        $this->wordLength = $wordLength;

        return $this;
    }

    /**
     * Add a valid letter (IE used, just not in this position)
     *
     * @param int $position
     * @param string $letter
     *
     * @return self
     */
    public function addValidLetter(int $position, string $letter): self
    {
        if (!isset($this->validLetters[$position])) {
            $this->validLetters[$position] = [];
        }

        $this->validLetters[$position][] = $letter;

        return $this;
    }

    /**
     * Add a correctly placed letter
     *
     * @param int $position
     * @param string $letter
     *
     * @return self
     */
    public function addCorrectLetter(int $position, string $letter): self
    {
        $this->correctLetters[$position] = $letter;

        return $this;
    }

    /**
     * Add an invalid letter, IE not used anywhere
     *
     * @param string $letter
     *
     * @return self
     */
    public function addInvalidLetter(string $letter): self
    {
        $alreadyValid = array_merge($this->correctLetters, ...$this->validLetters);

        if (!in_array($letter, $alreadyValid)) {
            $this->invalidLetters[] = $letter;
        }

        return $this;
    }

    /**
     * Add a word guess attempt
     *
     * @param string $guessedWord
     *
     * @return self
     */
    public function addGuessedWord(string $guessedWord): self
    {
        $this->guessedWords[] = $guessedWord;

        return $this;
    }

    public function getOutput(): string
    {
        $file     = $this->getWordFile($this->wordLength);
        $possible = ["Suggestions:"];
        $count    = $total = 0;
        $max      = 10;
        $regex    = $this->buildWordRegex();

        while (!$file->eof()) {
            $line = trim($file->getCurrentLine());

            if (
                !in_array($line, $this->guessedWords) &&
                preg_match($regex, $line)
            ) {
                if ($count !== $max) {
                    $possible[] = $line;
                    $count++;
                }
                $total++;
            }
        }

        $possible[] = "\n";
        if ($total > $max) {
            $possible[] = "Plus " . ($total - $count) . " more words \n";
        }

        return implode("\n", $possible);
    }

    /**
     * Build the word regex to match with our requirements
     *
     * @return string
     */
    private function buildWordRegex(): string
    {
        $minRange = array_diff(range('a', 'z'), $this->invalidLetters);
        $regex = array_fill(0, $this->wordLength, '.');

        foreach (array_keys($regex) as $pos => $key) {
            $charRange   = array_diff($minRange, $this->validLetters[$pos] ?? []);
            $charRange   = implode('', $charRange);
            $regex[$key] = $this->correctLetters[$key] ?? "[$charRange]";
        }

        return "/" . implode("", $regex) . "/";
    }
}
