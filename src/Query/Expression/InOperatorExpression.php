<?php
namespace Vimeo\MysqlEngine\Query\Expression;

use Vimeo\MysqlEngine\Parser\ExpressionParser;
use Vimeo\MysqlEngine\TokenType;
use Vimeo\MysqlEngine\Processor\SQLFakeRuntimeException;
use Vimeo\MysqlEngine\Parser\SQLFakeParseException;

final class InOperatorExpression extends Expression
{
    /**
     * @var array<int, Expression>|null
     */
    public $inList = null;

    /**
     * @var Expression
     */
    public $left;

    /**
     * @var bool
     */
    public $negated = false;

    public function __construct(Expression $left, bool $negated = false)
    {
        $this->left = $left;
        $this->negated = $negated;
        $this->name = '';
        $this->precedence = ExpressionParser::OPERATOR_PRECEDENCE['IN'];
        $this->operator = 'IN';
        $this->type = TokenType::OPERATOR;
    }

    /**
     * @return void
     */
    public function negate()
    {
        $this->negated = true;
    }

    /**
     * @return bool
     */
    public function isWellFormed()
    {
        return $this->inList !== null;
    }

    /**
     * @param array<int, Expression> $list
     *
     * @return void
     */
    public function setInList(array $list)
    {
        $this->inList = $list;
    }

    public function setNextChild(Expression $expr, bool $overwrite = false) : void
    {
        $this->inList = [$expr];
    }
}
