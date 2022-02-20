<?php

namespace Wordle\Generators;

/**
 * Base Abstract Generator, provides most generator functionality
 */
abstract class BaseGenerator implements GeneratorInterface
{
    /**
     * Minimum word length we have configured
     */
    public const MIN_WORD_LENGTH     = 4;

    /**
     * Maxinum word length we have configured
     */
    public const MAX_WORD_LENGTH     = 9;

    /**
     * Default Word Length
     */
    public const DEFAULT_WORD_LENGTH = 5;

    /**
     * Current Word Length selected
     *
     * @var int
     */
    protected $wordLength;

    /**
     * Current Word selected
     *
     * @var int
     */
    protected $selectedWordIndex;

    /**
     * Force the selection?
     *
     * @var bool
     */
    protected $forceSelection = false;

    public function __construct(int $wordLength = self::DEFAULT_WORD_LENGTH)
    {
        $this->wordLength = $wordLength;
    }

    public function generateWord(): string
    {
        $wordFile = $this->getWordFile();

        // Get the last line
        $wordFile->seek(PHP_INT_MAX);
        $maxLine = $wordFile->key() - 1;

        $wordPosition = $this->getWordPosition($maxLine);

        $this->selectedWordIndex = $wordPosition;

        $wordFile->seek($wordPosition);

        // @phan-suppress-next-line Current should always be a valid string
        return trim($wordFile->current());
    }

    /**
     * Generate a 'random' number to pull a word from a word-file
     *
     * @param int $maxLine
     *
     * @return int
     */
    protected function getWordPosition(int $maxLine): int
    {
        if ($this->forceSelection) {
            return $this->selectedWordIndex;
        }

        return rand(0, $maxLine);
    }

    /**
     * Gets the associated word file from the current word length
     *
     * @return \SplFileObject
     */
    protected function getWordFile(): \SplFileObject
    {
        $file = __DIR__ . "/../../../resources/{$this->wordLength}-letter-words.txt";

        return new \SplFileObject($file);
    }
}
