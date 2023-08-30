<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-17 15:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:46:42
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use yii\rbac\Item;

/**
 * RoleController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class RoleController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * {}
     */
    public function labels(): array
    {
        return[
            'Item' => 'Role',
            'Items' => 'Roles',
        ];
    }

    /**
     * {}
     */
    public function getType(): int
    {
        return Item::TYPE_ROLE;
    }
}
