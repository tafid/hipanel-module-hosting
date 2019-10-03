<?php

namespace hipanel\modules\stock\models;

use hipanel\base\ModelTrait;
use hipanel\modules\stock\helpers\ProfitColumns;

/**
 * Class OrderWithProfit
 * @package hipanel\modules\stock\models
 *
 * @property string $currency
 * @property string $total
 * @property string $uu
 * @property string $stock
 * @property string $rma
 * @property string $rent_price
 * @property string $rent_charge
 * @property string $leasing_price
 * @property string $leasing_charge
 * @property string $buyout_price
 * @property string $buyout_charge
 */
class OrderWithProfit extends Order
{
    use ModelTrait;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'currency',
                    'total_price',
                    'uu_price',
                    'stock_price',
                    'rma_price',
                    "rent_price",
                    "rent_charge",
                    "leasing_price",
                    "leasing_charge",
                    "buyout_price",
                    "buyout_charge",
                ],
                'safe',
            ]
        ]);
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels(ProfitColumns::getLabels());
    }
}
