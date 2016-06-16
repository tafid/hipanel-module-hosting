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
use hipanel\grid\RefColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class RequestGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'classes' => [
                'label' => Yii::t('app', 'Action'),
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) {
                    return sprintf('%s, %s', $model->object_class, $model->action);
                },
            ],
            'server' => [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::className(),
            ],
            'account' => [
                'enableSorting' => false,
                'class' => AccountColumn::className()
            ],
            'object' => [
                'enableSorting' => false,
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-external-link"></i>&nbsp;' . $model->object_name,
                        ['/hosting/' . $model->object_class . '/view', 'id' => $model->object_id],
                        ['data-pjax' => 0]
                    );
                }

            ],
            'time' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                }
            ],
            'state' => [
                'class' => RefColumn::className(),
                'i18nDictionary' => 'hipanel/hosting',
                'gtype' => 'state,request',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->state_label;
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
            ],
        ];
    }
}
