# Wordle (PHP)

My implementation of Wordle in PHP.

Features:
 - Unlimited tries!
 - A global Daily random word synced to UTC
 - Random words of 4 to 9 letters
 - Tell your friends about word #123 of 5 letters for them to try!

## Usage

### Daily Word
Command: `bin/wordle`

Will get the daily word without internet access. The daily word is generated using a seeded random number, the seed will be the current date in UTC.

### Random Words
Command: `bin/wordle LENGTH`

Replace LENGTH with any number between 4 and 9 (inclusive).

This is entirely random.

When you're done, it will tell you which number word you did, so your friends can try.

### Specific word
Command: `bin/wordle LENGTH WORD_NUMBER`

Like the last command, replace LENGTH with any number between 4 and 9 (inclusive).

If your friend has tried word #123, you can replace WORD_NUMBER with this to use try the same word!

