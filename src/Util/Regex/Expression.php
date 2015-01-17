<?php

namespace ToyLang\Util\Regex;

class Expression
{
    /**
     * @var string
     */
    private $pattern;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @param string $input
     * @return MatchResult|null
     */
    public function match($input)
    {
        $matches = [];

        if (preg_match($this->pattern, $input, $matches)) {
            return new MatchResult($matches);
        }

        return null;
    }

    /**
     * @param string $replacement
     * @param string $input
     * @param int $limit
     * @return string
     */
    public function replace($replacement, $input, $limit = -1)
    {
        return preg_replace($this->pattern, $replacement, $input, $limit);
    }
}
