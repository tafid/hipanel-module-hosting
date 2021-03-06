<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

class ServiceDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
        $actions = ServiceActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, []);
        unset($items['view']);

        return $items;
    }
}
