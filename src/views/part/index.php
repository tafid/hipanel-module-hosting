<?php

use hipanel\helpers\Url;
use hipanel\modules\stock\grid\PartGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Parts');
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->breadcrumbs->setItems([
    $this->title,
]); ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
        <?php $box->beginActions() ?>
            <?= $box->renderCreateButton(Yii::t('app', 'Create part')) ?>
            <?= $box->renderSearchButton() ?>
            <?= $box->renderSorter([
                'attributes' => [
                    'id',
                    'model_type', 'model_brand',
                    'partno', 'serial',
                    'create_time', 'move_time',
                ],
            ]) ?>
            <?= $box->renderPerPage() ?>
            <?= $box->renderRepresentation() ?>
        <?php $box->endActions() ?>

        <?php $box->beginBulkActions() ?>

        <div class="dropdown" style="display: inline-block">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= Yii::t('app', 'Bulk actions') ?>&nbsp;
                <span class="caret"></span>
            </button>
            <?= Dropdown::widget([
                'encodeLabels' => false,
                'items' => [
                    ['label' => Yii::t('app', 'Reserve'), 'url' => '#', 'linkOptions' => ['data-action' => 'reserve']],
                    ['label' => Yii::t('app', 'Unreserve'), 'url' => '#', 'linkOptions' => ['data-action' => 'unreserve']],
                    ['label' => Yii::t('app', 'RMA'), 'url' => '#', 'linkOptions' => ['data-action' => 'rma']],
                    '<li role="presentation" class="divider"></li>',
                    ['label' => Yii::t('app', 'Update'), 'url' => '#', 'linkOptions' => ['data-action' => 'update']],
                    ['label' => Yii::t('app', 'Move by one'), 'url' => '#', 'linkOptions' => ['data-action' => 'move']],
                ],
            ]); ?>
        </div>
        <?= AjaxModal::widget([
            'bulkPage' => true,
            'id' => 'bulk-set-price-modal',
            'scenario' => 'bulk-set-price',
            'actionUrl' => ['bulk-set-price'],
            'size' => Modal::SIZE_LARGE,
            'header' => Html::tag('h4', Yii::t('app', 'Set price'), ['class' => 'modal-title']),
            'toggleButton' => ['label' => Yii::t('app', 'Set price'), 'class' => 'btn btn-default'],
        ]) ?>

        <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(compact(['types', 'locations', 'brands'])) ?>
    <?php $box->end() ?>
    <?php $box->beginBulkForm() ?>
        <?= PartGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'locations' => $locations,
            'summaryRenderer' => function ($grid) use ($local_sums, $total_sums) {
                if (is_array($total_sums)) {
                    foreach ($total_sums as $cur => $sum) {
                        if ($cur && $sum>0) {
                            $totals .= ' &nbsp; <b>' . Yii::$app->formatter->asCurrency($sum, $cur) . '</b>';
                        }
                    }
                }
                if (is_array($local_sums)) {
                    foreach ($local_sums as $cur => $sum) {
                        if ($cur && $sum>0) {
                            $locals .= ' &nbsp; <b>' . Yii::$app->formatter->asCurrency($sum, $cur) . '</b>';
                        }
                    }
                }

                return $grid->parentSummary() .
                    ($totals ? Yii::t('app', 'TOTAL') . ':' . $totals : null) .
                    ($locals ? '<br><span class="text-muted">' . Yii::t('app', 'on screen') . ':' . $locals . '</span>' : null)
                ;
            },
            'columns' => $representation=='report' ? [
                'checkbox',
                'model_type', 'model_brand',
                'partno', 'serial',
                'create_date', 'price', 'place',
            ] : [
                'checkbox',
                'main', 'partno', 'serial',
                'last_move', 'move_type_label',
                'move_date', 'order_data', 'DC_ticket_ID',
                'actions',
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end() ?>