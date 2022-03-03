<?php

namespace Wordle\Output;

/**
 * Output Formatter for the CLI, using 8/16 color codes
 */
class OutputFormatter
{
    /**
     * Text Color Codes
     */
    public const COLOR_TXT_BLACK = "1;30";
    public const COLOR_TXT_WHITE = "1;37";
    public const COLOR_TXT_GREY = "1;90";
    public const COLOR_TXT_RED = "1;31";
    public const COLOR_TXT_DEF = "0;39";

    /**
     * Background Color Codes
     */
    public const COLOR_BG_RED = "41";
    public const COLOR_BG_GREEN = "42";
    public const COLOR_BG_AMBER = "43";
    public const COLOR_BG_GREY = "47";
    public const COLOR_BG_DEF = "49";

    /**
     * Text formatting options
     */
    public const FORMAT_DEF = 0;
    public const FORMAT_GREEN = 1;
    public const FORMAT_AMBER = 2;
    public const FORMAT_RED = 3;
    public const FORMAT_NONE = 4;
    public const FORMAT_ERROR = 5;
    public const FORMAT_INVALID = 6;

    /**
     * Format a string against a particular formatting option
     *
     * @param string $input
     * @param int $format
     *
     * @return string
     */
    public static function formatString(string $input, int $format = self::FORMAT_NONE): string
    {
        $formatString = "";

        switch ($format) {
            case self::FORMAT_GREEN:
                $formatString .= self::format(self::COLOR_TXT_WHITE, self::COLOR_BG_GREEN);
                break;
            case self::FORMAT_AMBER:
                $formatString .= self::format(self::COLOR_TXT_WHITE, self::COLOR_BG_AMBER);
                break;
            case self::FORMAT_RED:
                $formatString .= self::format(self::COLOR_TXT_WHITE, self::COLOR_BG_RED);
                break;
            case self::FORMAT_ERROR:
                $formatString .= self::format(self::COLOR_TXT_RED);
                break;
            case self::FORMAT_INVALID:
                $formatString .= self::format(self::COLOR_TXT_BLACK, self::COLOR_BG_GREY);
                break;
            case self::FORMAT_DEF:
                $formatString .= self::format(self::COLOR_TXT_DEF, self::COLOR_BG_DEF);
                break;
        }

        $formatString .= $input;

        if ($format !== self::FORMAT_NONE) {
            $formatString .= self::format(self::COLOR_TXT_DEF, self::COLOR_BG_DEF);
        }

        return $formatString;
    }

    /**
     * Gets the color codes and formats the string
     *
     * @param string ...$colorCodes
     *
     * @return string
     */
    private static function format(string ...$colorCodes): string
    {
        return "\e[" . implode(";", $colorCodes) . "m";
    }
}
