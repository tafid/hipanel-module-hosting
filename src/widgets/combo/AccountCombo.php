<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;

/**
 * Class Account
 */
class AccountCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/account';

    /** @inheritdoc */
    public $name = 'login';

    /** @inheritdoc */
    public $url = '/hosting/account/search';

    /** @inheritdoc */
    public $_return = ['id', 'client', 'client_id', 'device', 'device_id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'login'];

    /**
     * @var string the type of client
     *             Used by [[getFilter]] to generate filter
     *
     * @see getFilter()
     */
    public $accountType;

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'client' => 'client/client',
            'server' => 'server/server',
            'type'   => ['format' => $this->accountType],
        ]);
    }

    public function getPluginOptions($config)
    {
        return parent::getPluginOptions([
            'clearWhen' => ['client/client', 'server/server'],
            'affects'   => [
                'client/seller' => 'seller',
                'client/client' => 'client',
                'server/server' => 'device',
            ]
        ]);
    }
}