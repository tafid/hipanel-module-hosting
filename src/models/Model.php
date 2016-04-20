<?php

/*
 * Stock Module for Hipanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-stock
 * @package   hipanel-module-stock
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\stock\models;

use hipanel\base\Model as YiiModel;
use hipanel\base\ModelTrait;
use Yii;
use yii\helpers\Html;

class Model extends YiiModel
{
    use ModelTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Search
            [[
                'id',
                'state_label',
                'brand_label',
                'url',
                'descr',
                'short',
                'is_favourite',
                'profile',
                'profile_id',
                'last_prices',
                'model',
                'model_like',
                'type',
                'types',
                'state',
                'states',
                'brand',
                'brands',
                'tag',
                'tags',
                'tags_all',
                'prop_tag',
                'prop_tags',
                'prop_tags_all',
                'partno',
                'url_like',
                'partno_like',
                'descr_like',
                'short_like',
                'brand_like',
                'group_like',
                'with_counters',
                'with_prices',
                'tariff_id',
                'show_system',
                'show_hidden_from_user',
                'dcs',
                'counters',

                'dtg',
                'sdg',
                'm3',
            ], 'safe'],
            // Create & Update
            [[
                'id',
                'type',
                'partno',
                'brand',
                'model',
                'url',
                'descr',
                'short',
                'is_favourite',
                'profile',
                'tags',
                'prop_tags',
                'props',
                // Chassis
                'UNITS_QTY',
                '35_HDD_QTY',
                '25_HDD_QTY',
                // Server
                'units_qty',
                '35_hdd_qty',
                '25_hdd_qty',
                'ram_qty',
                'cpu_qty',
                // CPU
                // HDD
                'FORMFACTOR',
                // Motherboard
                'RAM_AMOUNT',
                'RAM_QTY',
                'CPU_QTY',
                // RAM
                'RAM_VOLUME',
            ], 'safe', 'on' => ['create', 'update']],
            [[
                'type',
                'brand',
                'model',
                'partno',
            ], 'required', 'on' => ['create']],
            [[
                'model',
                'partno',
            ], 'required', 'on' => ['update']],
            // Hide & Show
            ['id', 'required', 'on' => ['mark-hidden-from-user', 'unmark-hidden-from-user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'partno_like' => Yii::t('app', 'Part No.'),
            'partno' => Yii::t('app', 'Part No.'),
            'brand_like' => Yii::t('app', 'Brand'),
            'show_hidden_from_user' => Yii::t('app', 'Show hidden'),
            'descr_like' => Yii::t('app', 'Description'),
            'short_like' => Yii::t('app', 'Short'),
            'group_like' => Yii::t('app', 'Group'),
            'model_like' => Yii::t('app', 'Model'),
            'profile' => Yii::t('app', 'Group'),
            // Chassis
            'UNITS_QTY' => Yii::t('app', 'Units'),
            '35_HDD_QTY' => Yii::t('app', '3.5" HDD'),
            '25_HDD_QTY' => Yii::t('app', '2.5" HDD'),
            // Server
            'units_qty' => Yii::t('app', 'Units'),
            '35_hdd_qty' => Yii::t('app', '3.5" HDD'),
            '25_hdd_qty' => Yii::t('app', '2.5" HDD'),
            'ram_qty' => Yii::t('app', 'RAM slots'),
            'cpu_qty' => Yii::t('app', 'CPU quantity'),
            // CPU
            'prop_tags' => Yii::t('app', 'Prop tags'),
            // HDD
            'FORMFACTOR' => Yii::t('app', 'Form factor'),
            // Motherboard
            'RAM_AMOUNT' => Yii::t('app', 'Max RAM'),
            'RAM_QTY' => Yii::t('app', 'RAM slots'),
            'CPU_QTY' => Yii::t('app', 'CPU sockets'),
            // RAM
            'RAM_VOLUME' => Yii::t('app', 'RAM volume'),
            'dcs' => 'DCS',
            // ---
            'dtg' => Yii::t('app', 'USA Equinix DC10'),
            'sdg' => Yii::t('app', 'NL Amsterdam SDG'),
            'm3' => Yii::t('app', 'NL Amsterdam M3'),
        ]);
    }

//    public static function getDcs()
//    {
//        return Ref::getList('type,dc');
//    }

    public function getDcs($dc)
    {
        $out = '';
        if ($this['counters'][$dc]['rma']) {
            $out .= Html::tag('span', $this['counters'][$dc]['rma'], ['class' => 'text-danger']);
            // '<span style="color: red">' . $this['counters'][$dc]['rma'] . '</span>/';
        }
        $stock = $this['counters'][$dc]['stock'] - $this['counters'][$dc]['reserved'];
        $out .= $stock >= 0 ? $stock : 0;
        if ($this['counters'][$dc]['reserved']) {
            $out .= Html::tag('span', '+ ' . $this['counters'][$dc]['reserved'], ['class' => 'text-info']);
            //echo '+<span style="color: blue">' . $this['counters'][$dc]['reserved'] . '</span>';
        }
        return $out;
    }

    public function showModelPrices($data, $delimiter = ' / ')
    {
        $prices = [];
        if (is_array($data)) {
            foreach ($data as $currency => $price) {
                $prices[] = Yii::$app->formatter->format($price, ['currency', $currency]);
            }
            return implode($delimiter, $prices);
        }
        return '';
    }
}