<?php

namespace ToyLang\Core\Util\Regex;

class MatchResult
{
    /**
     * @var mixed
     */
    private $matches;

    public function __construct($matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return mixed
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
