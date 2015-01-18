<?php

namespace ToyLang\Parser;

use ToyLang\Core\Lexer\Token\Token;
use ToyLang\Parser\Node\AssignmentNode;
use ToyLang\Parser\Node\ExpressionNode;
use ToyLang\Parser\Node\IdentifierNode;
use ToyLang\Parser\Node\NumberNode;
use ToyLang\Parser\Node\ProgramNode;
use ToyLang\Parser\Node\StatementNode;

class LanguageParser
{
    /**
     * @var Token[]
     */
    private $tokens;

    /**
     * @param Token[] $tokens
     * @return ProgramNode
     */
    public function parse($tokens)
    {
        if (!$tokens) {
            throw new \InvalidArgumentException('Cannot parse an empty tokens tree');
        }

        $this->tokens = $this->removeWhitespace($tokens);

        return $this->parseProgram();
    }

    protected function discard()
    {
        array_shift($this->tokens);
    }

    /**
     * @param Token[] $tokens
     * @return Token[]
     */
    protected function removeWhitespace($tokens)
    {
        $newTokens = [];

        foreach ($tokens as $token) {
            if ($token->getTokenType()->getName() !== 'WHITESPACE') {
                $newTokens[] = $token;
            }
        }

        return $newTokens;
    }

    /**
     * @param int $count
     * @return Token
     */
    protected function peek($count = 1)
    {
        return $this->tokens[$count - 1];
    }

    /**
     * @param string $expectedType
     * @return Token
     * @throws \Exception
     */
    protected function match($expectedType)
    {
        $token = $this->peek();

        $currentTokenType = $token->getTokenType()->getName();

        if ($currentTokenType === $expectedType) {
            $this->discard();
            return $token;
        }

        throw new \Exception(sprintf(
            'Expected token type "%s", got "%s" instead',
            $expectedType,
            $currentTokenType
        ));
    }

    /**
     * @return ProgramNode
     */
    protected function parseProgram()
    {
        return new ProgramNode($this->parseStatement());
    }

    /**
     * @return StatementNode
     */
    protected function parseStatement()
    {
        $node = null;

        if ($this->nextIsAssignment()) {
            $node = $this->parseAssignment();
        } else {
            $node = $this->parseExpression();
        }

        $this->match('STATEMENT_TERMINATOR');

        return new StatementNode($node);
    }

    protected function nextIsAssignment()
    {
        $token = $this->peek()->getTokenType()->getName();
        $nextToken = $this->peek(2)->getTokenType()->getName();

        return $token === 'IDENTIFIER' && $nextToken === 'ASSIGN_OPERATOR';
    }

    /**
     * @return AssignmentNode
     */
    protected function parseAssignment()
    {
        $identifier = new IdentifierNode($this->match('IDENTIFIER')->getValue());

        $this->match('ASSIGN_OPERATOR');

        $expression = $this->parseExpression();

        return new AssignmentNode($identifier, $expression);
    }

    /**
     * @return ExpressionNode
     */
    protected function parseExpression()
    {
        return $this->parseEqualityExpression();
    }

    protected function parseEqualityExpression()
    {
        $leftExpression = $this->parseAdditiveExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'EQUALITY_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('EQUALITY_OPERATOR')->getValue();
            $rightExpression = $this->parseEqualityExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseAdditiveExpression()
    {
        $leftExpression = $this->parseMultiplicativeExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'ADDITIVE_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('ADDITIVE_OPERATOR')->getValue();
            $rightExpression = $this->parseAdditiveExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseMultiplicativeExpression()
    {
        $leftExpression = $this->parseParenExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'MULTIPLICATIVE_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('MULTIPLICATIVE_OPERATOR')->getValue();
            $rightExpression = $this->parseMultiplicativeExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseParenExpression()
    {
        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        switch ($tokenType) {
            case 'NUMBER':
                $this->discard();
                return new ExpressionNode(new NumberNode($nextToken->getValue()));
                break;
            case 'OPEN_PAREN':
                $this->discard();
                $expression = $this->parseExpression();
                $this->match('CLOSE_PAREN');

                return $expression;
                break;
            default:
                throw new \Exception(sprintf(
                    'Expected NUMBER or OPEN_PAREN, got "%s" instead',
                    $tokenType
                ));
                break;
        }
    }
}
