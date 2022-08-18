<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-18 14:31:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-18 16:54:19
 */

namespace swooleService\db;

use Swoole\Table as SwooleTable;

class Table
{
    public const TYPE_INT = 1;

    public const TYPE_STRING = 3;

    public const TYPE_FLOAT = 2;

    /**
     * Registered swoole tables.
     *
     * @var array
     */
    protected $tables = [];

    /**
     * Add a swoole table to existing tables.
     *
     * @return Table
     */
    public function add(string $name, SwooleTable $table)
    {
        $this->tables[$name] = $table;

        return $this;
    }

    /**
     * Get a swoole table by its name from existing tables.
     *
     * @return SwooleTable $table
     */
    public function get(string $name)
    {
        return $this->tables[$name] ?? null;
    }

    /**
     * Get all existing swoole tables.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->tables;
    }

    /**
     * Dynamically access table.
     *
     * @return SwooleTable
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }
}
