<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Select
{
    use ToStringTrait;
    use ConditionsTrait;

    private const SELECT = "SELECT ";
    private const SELECT_ALL = "SELECT * FROM ";
    private const SELECT_COUNT = 'SELECT COUNT(*) FROM ';

    private string $query = '';
    private string $table = '';
    private ?string $preLetter = null;

    private bool $methodSelectCalled = false;

    /**
     * Select constructor.
     *
     * @param string $table The table name.
     * @param string|null $preLetter The prefix letter.
     */
    public function __construct(string $table, ?string $preLetter = null)
    {
        $this->table = $table;
        $this->preLetter = $preLetter;

        if (!$this->methodSelectCalled) {
            $this->selectAll();
        }
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getTable(): string
    {
        $table = $this->preLetter ? $this->table . ' ' . $this->preLetter : $this->table;
        return $table;
    }

    public function withPreLetter(string $letter = 'p'): self
    {
        $this->preLetter = $letter;
        return $this;
    }

    public function getPdoLetter(): string
    {
        return $this->preLetter;
    }

    public function selectAll(): self
    {
        $this->methodSelectCalled = true;
        $this->query = self::SELECT_ALL . $this->getTable();
        return $this;
    }

    public function selectColumns(string|array $columns): self
    {
        $this->methodSelectCalled = true;
        if (is_array($columns)) {
            $columns = $this->columnsList($columns, $this->preLetter);
        }
        $this->query = self::SELECT . $columns . " FROM " . $this->getTable();
        return $this;
    }

    public function countAll(): self
    {
        $this->methodSelectCalled = true;
        $this->query = self::SELECT_COUNT . $this->getTable();
        return $this;
    }

    public function where($condition): self
    {
        $condition = $this->setConditions($condition);
        $this->query .= " WHERE " . $condition;
        return $this;
    }

    public function whereId(int|string $id): self
    {
        $this->query .= " WHERE id = {$id}";
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->query .= " ORDER BY " . $column . " " . $direction;
        return $this;
    }

    public function join(string $table, string $condition): self
    {
        $this->query .= " JOIN " . $table . " ON " . $condition;
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->query .= " GROUP BY " . $column;
        return $this;
    }

    public function having(string $condition): self
    {
        $this->query .= " HAVING " . $condition;
        return $this;
    }

    public function limit(int $from,?int $to = null): self
    {
        $this->query .= " LIMIT  $from" ;
        if($to){
            $this->query .= ",$to";
        }
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->query .= " OFFSET " . $offset;
        return $this;
    }

    public function __toString(): string
    {
        return $this->query ;
    }
}
