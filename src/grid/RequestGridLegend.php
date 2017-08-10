<?php

namespace hipanel\modules\hosting\grid;

use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;

class RequestGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => ['hipanel:hosting', 'Scheduled time:'],
                'tag' => 'h4',
            ],
            [
                'label' => ['hipanel:hosting', 'Already'],
                'color' => '#E0E0E0',
                'rule' => false,
                'columns' => ['time'],
            ],
            [
                'label' => ['hipanel:hosting', 'Deferred'],
                'color' => '#AAAAFF',
                'rule' => false,
                'columns' => ['time'],
            ],
            [
                'label' => ['hipanel:hosting', 'State:'],
                'tag' => 'h4',
            ],
            [
                'label' => ['hipanel:hosting', 'New'],
                'color' => '#FFFF99',
                'rule' => $this->model->state === 'new',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'In progress'],
                'color' => '#AAFFAA',
                'rule' => $this->model->state === 'progress',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Done'],
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Error'],
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'error',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Buzzed'],
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'buzzed',
                'columns' => ['state'],
            ],
        ];
    }
}