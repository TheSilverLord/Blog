<?php
namespace Blog\Models;

use Blog\Services\Db;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getId(): int { return $this->id; }
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;', [':id' => $id], static::class);
        return $entities ? $entities[0] : null;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;' , [], static::class);
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value LIMIT 1;',
        [':value' => $value], static::class);
        if ($result === []) { return null; }
        return $result[0];
    }

    abstract protected static function getTableName(): string;

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];
        foreach ($properties as $property)
        {
            $propertyName = $property->getName();
            $mappedProperties[$propertyName] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) { $this->update($mappedProperties); }
        else { $this->insert($mappedProperties); }
    }

    private function update(array $mappedProperties): void
    {
        $columnsToParams = [];
        $paramsToValues = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value)
        {
            $param = ':param' . $index;
            $columnsToParams[] = $column . '=' . $param;
            $paramsToValues[$param] = $value;
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columnsToParams) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $paramsToValues, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        $paramsNames = [];
        $paramsToValues = [];
        foreach ($filteredProperties as $columnName => $value)
        {
            $columns[] = '`' . $columnName . '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $paramsToValues[$paramName] = $value;
        }

        $columnsUnited = implode(', ', $columns);
        $paramsUnited = implode(', ', $paramsNames);
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsUnited . ') VALUES (' . $paramsUnited . ');';
        $db = Db::getInstance();
        $db->query($sql, $paramsToValues, static::class);
        $this->id = $db->getLastInsertId();
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM `' . static::getTableName() . '` WHERE id = :id', [':id' => $this->id]);
        $this->id = null;
    }
}
?>