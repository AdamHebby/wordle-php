![Coverage](https://github.com/AdamHebby/wordle-php/.github/badges/coverage.svg)

# Wordle (PHP)

My implementation of Wordle in PHP.

Features:
 - Unlimited tries!
 - A global Daily random word synced to UTC
 - Random words of 4 to 9 letters
 - Tell your friends about word #123 of 5 letters for them to try!

## Usage

If git cloning, use `bin/wordle`, if installing globally use `wordle`.

### Daily Word
Command: `wordle`

Will get the daily word without internet access. The daily word is generated using a seeded random number, the seed will be the current date in UTC.

<img height="250px" src="https://raw.githubusercontent.com/AdamHebby/wordle-php/master/.github/images/daily.png" alt="Daily Wordle">

### Random Words
Command: `wordle LENGTH`

Replace LENGTH with any number between 4 and 9 (inclusive).

This is entirely random.

When you're done, it will tell you which number word you did, so your friends can try.

<img height="250px" src="https://raw.githubusercontent.com/AdamHebby/wordle-php/master/.github/images/8-letters.png" alt="Random 8">

<img height="250px" src="https://raw.githubusercontent.com/AdamHebby/wordle-php/master/.github/images/8-letters-end.png" alt="Random 8">

### Specific word
Command: `wordle LENGTH WORD_NUMBER`

Like the last command, replace LENGTH with any number between 4 and 9 (inclusive).

If your friend has tried word #123, you can replace WORD_NUMBER with this to use try the same word!

<img height="250px" src="https://raw.githubusercontent.com/AdamHebby/wordle-php/master/.github/images/8-letters-specific.png" alt="834">

## Installation

`composer global require adamhebby/wordle-php`

Then you can run `wordle` from anywhere, assuming you have composer in your path.
