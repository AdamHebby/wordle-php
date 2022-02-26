<?php

namespace Wordle\Traits;

/**
 * Handles Word Files
 */
trait WordFileAwareTrait
{
    /**
     * Gets the associated word file from the current word length
     *
     * @return \SplFileObject
     */
    protected static function getWordFile(int $wordLength): \SplFileObject
    {
        return new \SplFileObject(self::getWordFilePath($wordLength));
    }

    /**
     * Get the word file path based on the word length
     *
     * @param int $wordLength
     *
     * @return string
     */
    protected static function getWordFilePath(int $wordLength): string
    {
        return __DIR__ . "/../../../resources/{$wordLength}-letter-words.txt";
    }
}
