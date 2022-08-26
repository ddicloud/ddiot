<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-18 14:34:02
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-26 14:35:15
 */

namespace swooleService\interfaces;

use Swoole\Table as SwooleTable;
use swooleService\db\Table;

trait InteractsWithSwooleTable
{
    /**
     * @var Table
     */
    public  $currentTable;

    /**
     * Register customized swoole tables.
     */
    public  function prepareTables(array $tables)
    {
        $this->currentTable = new Table();
        $this->registerTables($tables);
    }

    /**
     * Register user-defined swoole tables.
     */
    public  function registerTables(array $tables)
    {
        foreach ($tables as $key => $value) {
            $table = new SwooleTable($value['size']);
            $columns = $value['columns'] ?? [];
            foreach ($columns as $column) {
                if (isset($column['size'])) {
                    $table->column($column['name'], $column['type'], $column['size']);
                } else {
                    $table->column($column['name'], $column['type']);
                }
            }
            $table->create();

            $this->currentTable->add($key, $table);
        }
    }
}
