<?php

namespace Wordle\Output;

/**
 * Output handler for the final share block
 */
final class FinalResultOutput implements OutputInterface
{
    /**
     * Final result as a grid of colors
     *
     * @var array<string>
     */
    private $finalResult = [];

    /**
     * pre-text to the share block
     *
     * Might include the date, length of the word, or the index of the word
     *
     * @var string
     */
    private $shareString = "";

    /**
     * Add an attempt, convert G,A,I to color blocks
     *
     * @param string $line
     *
     * @return void
     */
    public function addWordleAttempt(string $line): void
    {
        // TODO: Set to constants?
        $line = str_replace("G", "🟩", $line); // Good
        $line = str_replace("A", "🟨", $line); // Allowed
        $line = str_replace("I", "⬛", $line); // Invalid
        $line = str_replace("C", "🟥", $line); // Cheating

        $this->finalResult[] = $line;
    }

    /**
     * Set the share string pre-text
     *
     * @param string $shareString
     *
     * @return void
     */
    public function setShareString(string $shareString): void
    {
        $this->shareString = $shareString;
    }

    public function getOutput(): string
    {
        return implode(
            "\n",
            array_merge(
                [$this->shareString],
                $this->finalResult
            )
        );
    }
}
