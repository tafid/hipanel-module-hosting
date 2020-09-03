<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\DataColumn;
use Yii;
use yii\bootstrap\Progress;

class UtilizationColumn extends DataColumn
{
    public $format = 'html';

    public function init()
    {
        parent::init();
        $this->label = Yii::t('hipanel.hosting.ipam', 'Utilization');
    }

    public function getDataCellValue($model, $key, $index)
    {
        $prc = $model->utilization;
        switch ($prc) {
            case $prc >= 0 && $prc <= 40:
                $level = 'progress-bar-success';
                break;
            case $prc >= 41 && $prc <= 70:
                $level = 'progress-bar-warning';
                break;
            case $prc >= 71 && $prc <= 100:
                $level = 'progress-bar-danger';
                break;
        }

        return Progress::widget([
            'percent' => $prc,
            'label' => $prc . '%',
            'barOptions' => ['class' => $level],
            'options' => ['style' => 'background-color: grey;'],
        ]);
    }
}
