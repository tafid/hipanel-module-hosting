<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\hosting\widgets\account\State;
use hipanel\modules\hosting\widgets\account\Type;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;

class AccountGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'account'       => [
                'class'             => MainColumn::className(),
                'label'             => Yii::t('app', 'Account'),
                'attribute'         => 'login',
                'filterAttribute'   => 'login_like',
            ],
            'state'         => [
                'class'             => RefColumn::className(),
                'format'            => 'raw',
                'i18nDictionary'    => 'hipanel/hosting',
                'value'             => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'             => 'state,account',
            ],
            'server'        => [
                'class'             => ServerColumn::className()
            ],
            'sshftp_ips'    => [
                'attribute'         => 'sshftp_ips',
                'format'            => 'raw',
                'value'             => function ($model) {
                    return ArraySpoiler::widget([
                        'data'         => $model->sshftp_ips,
                        'visibleCount' => 3
                    ]);
                }
            ],
            'actions'       => [
                'class'             => ActionColumn::className(),
                'template'          => '{view} {delete}'
            ],
            'type'          => [
                'class'             => RefColumn::className(),
                'i18nDictionary'    => 'hipanel/hosting',
                'format'            => 'raw',
                'value'             => function ($model) {
                    return Type::widget(compact('model'));
                },
                'gtype'             => 'type,account',
            ],
        ];
    }
}