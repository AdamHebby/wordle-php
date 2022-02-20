<?php

namespace Wordle\Output;

/**
 * Shows the keyboard output after each failed attempt
 */
final class KeyboardOutput implements OutputInterface
{
    /**
     * Specific colors for specific characters on the keyboard
     *
     * @var array<string,string>
     */
    public $colors = [];

    /**
     * Stores formatted latters to ensure we don't down-grade a letter
     *
     * @var array<string,int>
     */
    public $formats = [];

    /**
     * A KEYBOARD!
     *
     * @var array<array<string>>
     */
    public $keyboard = [
        ["Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P"],
        ["A", "S", "D", "F", "G", "H", "J", "K", "L"],
        ["Z", "X", "C", "V", "B", "N", "M"],
    ];

    /**
     * Color a character
     *
     * @param string $char
     * @param int $format
     *
     * @return void
     */
    public function colorCharKey(string $char, int $format): void
    {
        if (!isset($this->formats[$char]) || $format < $this->formats[$char]) {
            $this->formats[$char] = $format;
            $this->colors[strtoupper($char)] = OutputFormatter::formatString(strtoupper($char), $format);
        }
    }

    public function getOutput(): string
    {
        //┌─┬─┬─┬─┬─┬─┬─┬─┬─┬─┐
        //│Q│W│E│R│T│Y│U│I│O│P│
        //└┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┴┬┘
        // │A│S│D│F│G│H│J│K│L│
        // └─┼─┼─┼─┼─┼─┼─┼─┼─┘
        //   │Z│X│C│V│B│N│M│
        //   └─┴─┴─┴─┴─┴─┴─┘
        $keyboard = "┌─" . str_repeat("┬─", 9) . "┐" . "\n";
        $keyboard .= "" . $this->getKeyboardLine(0) . "\n";
        $keyboard .= "└" . str_repeat("┬┴", 9) . "┬┘" . "\n";

        $keyboard .= " " . $this->getKeyboardLine(1) . "\n";
        $keyboard .= " └" . str_repeat("─┼", 8) . "─┘" . "\n";

        $keyboard .= "   " . $this->getKeyboardLine(2) . "\n";
        $keyboard .= "   └─" . str_repeat("┴─", 6) . "┘" . "\n";

        return $keyboard;
    }

    /**
     * Get a single keyboad character, with pipes either side, colored as needed
     *
     * @param int $line
     *
     * @return string
     */
    private function getKeyboardLine(int $line): string
    {
        $chars = array_map(function (string $char) {
            return $this->colors[$char] ?? $char;
        }, $this->keyboard[$line]);

        return "│" . implode("│", $chars) . "│";
    }
}
