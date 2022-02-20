<?php

namespace Wordle\Generators;

/**
 * Generator interface to generate a word to guess
 */
interface GeneratorInterface
{
    /**
     * Generate a word to guess
     *
     * @return string
     */
    public function generateWord(): string;

    /**
     * Get the share string specific to the generator
     *
     * @return string
     */
    public function getShareString(): string;
}
