<?php

namespace Wordle\Output;

interface OutputInterface
{
    /**
     * Get the output!
     *
     * @return string
     */
    public function getOutput(): string;
}
