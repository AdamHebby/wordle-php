<?php

namespace Wordle\Output;

/**
 * Handles all the output
 */
class OutputHandler implements OutputInterface
{
    /**
     * Keyboard Output
     *
     * @var KeyboardOutput
     */
    public $keyboardOutput;

    /**
     * Final Result Output
     *
     * @var FinalResultOutput
     */
    public $finalResultOutput;

    /**
     * Wordle Output
     *
     * @var WordleOutput
     */
    public $wordleOutput;

    /**
     * Cheating Output
     *
     * @var CheatingOutput
     */
    public $cheatingOutput;
    /**
     * How many guesses?
     *
     * @var int
     */
    private $guessCount = 0;

    /**
     * Temporary output
     *
     * @var array<string>
     */
    private $temporaryOutput = [];

    public function __construct(string $shareString)
    {
        $this->keyboardOutput    = new KeyboardOutput();
        $this->finalResultOutput = new FinalResultOutput();
        $this->wordleOutput      = new WordleOutput();
        $this->cheatingOutput    = new CheatingOutput();

        $this->finalResultOutput->setShareString($shareString);
    }

    /**
     * Add some temporary output that wont be there on the next result. Something like an error
     *
     * @param string $output
     *
     * @return void
     */
    public function addTemporaryOutput(string $output): void
    {
        $this->temporaryOutput[] = $output;
    }

    public function getOutput(bool $done = false): string
    {
        $return = "";
        $return .= $this->wordleOutput->getOutput() . "\n\n";

        if (!$done) {
            $return .= $this->keyboardOutput->getOutput() . "\n\n";
        } else {
            $return .= "SHARE:\n" .
                $this->finalResultOutput->getOutput() .
                "\nGuesses: " . $this->guessCount . "\n\n";
        }

        $return .= implode("\n", $this->temporaryOutput);

        $this->temporaryOutput = [];

        return $return;
    }

    /**
     * Add a completely valid guess
     *
     * @param string $guess
     *
     * @return void
     */
    public function addValidGuess(string $guess): void
    {
        $this->wordleOutput->addWordleAttempt(
            OutputFormatter::formatString(
                implode('', array_map(function (string $str) {
                    return " $str ";
                }, str_split(strtoupper($guess)))),
                OutputFormatter::FORMAT_GREEN
            )
        );

        $this->finalResultOutput->addWordleAttempt(
            str_repeat("G", strlen($guess))
        );
        $this->guessCount++;
    }

    public function addCheatingOutput(int $wordLength, bool $fullCheat = false): void
    {
        $this->finalResultOutput->addWordleAttempt(str_repeat('C', $wordLength));
        $this->wordleOutput->addWordleAttempt(OutputFormatter::formatString(
            str_repeat($fullCheat ? ' * ' : ' ? ', $wordLength),
            OutputFormatter::FORMAT_RED
        ));

        $this->guessCount++;
    }

    /**
     * Add an invalid guess
     *
     * @param string $guess
     * @param string $realWord
     *
     * @return void
     */
    public function addInvalidGuess(string $guess, string $realWord): void
    {
        $cheating = stristr($guess, '?') !== false;
        $splitGuess = str_split($guess);
        $splitWord = str_split($realWord);
        $wordOutput = "";
        $finalResultWord = "";
        $usedLetters = array_count_values($splitWord);

        $this->cheatingOutput->addGuessedWord($guess);

        foreach ($splitGuess as $key => $char) {
            $upperChar = strtoupper($char);

            if ($char === ($splitWord[$key] ?? null) && ($usedLetters[$char] ?? 0) !== 0) {
                $wordOutput .= OutputFormatter::formatString(
                    " $upperChar ",
                    OutputFormatter::FORMAT_GREEN
                );

                $this->keyboardOutput->colorCharKey($char, OutputFormatter::FORMAT_GREEN);

                if (!$cheating) {
                    $this->cheatingOutput->addCorrectLetter($key, $char);
                }

                $finalResultWord .= "G";
            } elseif (in_array($char, $splitWord) && ($usedLetters[$char] ?? 0) !== 0) {
                $wordOutput .= OutputFormatter::formatString(
                    " $upperChar ",
                    OutputFormatter::FORMAT_AMBER
                );

                $this->keyboardOutput->colorCharKey($char, OutputFormatter::FORMAT_AMBER);

                if (!$cheating) {
                    $this->cheatingOutput->addValidLetter($key, $char);
                }

                $finalResultWord .= "A";
            } else {
                $wordOutput .= OutputFormatter::formatString(
                    " $upperChar ",
                    OutputFormatter::FORMAT_INVALID
                );

                $this->keyboardOutput->colorCharKey($char, OutputFormatter::FORMAT_INVALID);

                if (!$cheating) {
                    $this->cheatingOutput->addInvalidLetter($char);
                }

                $finalResultWord .= "I";
            }

            if (isset($usedLetters[$char])) {
                $usedLetters[$char]--;
            }
        }

        $this->wordleOutput->addWordleAttempt($wordOutput);
        $this->finalResultOutput->addWordleAttempt($finalResultWord);

        $this->guessCount++;
    }
}
