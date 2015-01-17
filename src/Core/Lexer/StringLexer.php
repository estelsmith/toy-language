<?php

namespace ToyLang\Core\Lexer;

use ToyLang\Core\Lexer\Token\TokenType;

class StringLexer implements Lexer
{
    /**
     * @var TokenType[]
     */
    private $tokenTypes = [];

    public function addTokenType(TokenType $tokenType)
    {
        $this->tokenTypes[] = $tokenType;
    }

    public function addTokenTypes($tokenTypes)
    {
        foreach ($tokenTypes as $tokenType) {
            $this->addTokenType($tokenType);
        }
    }

    public function tokenize($input)
    {
        $currentInput = $input;
        $tokenTypes = $this->tokenTypes;

        $processedTokens = [];

        while ($currentInput) {
            foreach ($tokenTypes as $tokenType) {
                $token = $tokenType->match($currentInput);

                if ($token) {
                    $processedTokens[] = $token;
                    $currentInput = $tokenType->getExpression()->replace('', $currentInput, 1);
                    break;
                }
            }
        }

        return $processedTokens;
    }
}
