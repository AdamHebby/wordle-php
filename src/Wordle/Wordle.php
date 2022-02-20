<?php

namespace Wordle;

use Wordle\Generators\GeneratorInterface;
use Wordle\Output\OutputFormatter;
use Wordle\Output\OutputHandler;

/**
 * Wordle Game!
 */
class Wordle
{
    /**
     * Word Validator
     *
     * @var Validator
     */
    private $validator;
    /**
     * Output Handler
     *
     * @var OutputHandler
     */
    private $output;
    /**
     * Word Selected from Generator
     *
     * @var null|string
     */
    private $word;

    /**
     * Is the game over?
     *
     * @var bool
     */
    private $gameFinished = false;

    /**
     * Start the game!
     *
     * @param GeneratorInterface $generator
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->word      = $generator->generateWord();
        $this->validator = new Validator();
        $this->output    = new OutputHandler($generator->getShareString());
        $this->validator->setWord($this->word);
    }

    /**
     * Make a guess!
     *
     * @param string $guessAttempt
     *
     * @return void
     */
    public function attemptGuess(string $guessAttempt): void
    {
        if (empty($this->word)) {
            throw new \Exception("Word has not been generated!");
        }

        $guessAttempt = strtolower($guessAttempt);

        if (!$this->validator->validateRealWord($guessAttempt)) {
            $this->output->addTemporaryOutput(OutputFormatter::formatString(
                "ERR: $guessAttempt is not a real word! \n",
                OutputFormatter::FORMAT_ERROR
            ));

            return;
        }

        if (strlen($guessAttempt) !== strlen($this->word)) {
            $this->output->addTemporaryOutput(OutputFormatter::formatString(
                "ERR: The word you're looking for is " . strlen($this->word) . " chars long! \n",
                OutputFormatter::FORMAT_ERROR
            ));

            return;
        }

        $validGuess = $this->validator->validateGuess($guessAttempt);

        if ($validGuess) {
            $this->output->addValidGuess($guessAttempt);
        } else {
            $this->output->addInvalidGuess($guessAttempt, $this->word);
        }

        $this->gameFinished = $validGuess;
    }

    /**
     * Get the games output
     *
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output->getOutput($this->gameFinished);
    }

    /**
     * Is this guess valid?
     *
     * @param string $guessAttempt
     *
     * @return bool
     */
    public function isValidGuess(string $guessAttempt): bool
    {
        return $this->validator->validateGuess($guessAttempt);
    }
}
