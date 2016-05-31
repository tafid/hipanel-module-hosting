<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\ViewAction;
use hipanel\models\Ref;
use Yii;

class RequestController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/request/index'
                ]
            ],
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'objectOptions' => $action->controller->getObjectOptions(),
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
                'filterStorageMap' => [
                    'state' => 'hosting.request.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ]
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel/hosting', 'Deleted'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to delete request.')
            ],
        ];
    }

    public function getTypeOptions()
    {
        return Ref::getList('type,request', ['limit' => 'ALL', 'with_recursive' => true, 'select' => 'id']);
    }

    public function getStateOptions()
    {
        return Ref::getList('state,request');
    }

    public function getObjectOptions()
    {
        return [
            ' '         => Yii::t('app', 'All'),
            'db'        => Yii::t('app', 'Database'),
            'hdomain'   => Yii::t('app', 'Domain'),
            'device'    => Yii::t('app', 'Server'),
            'service'   => Yii::t('app', 'Service'),
        ];
    }
}
