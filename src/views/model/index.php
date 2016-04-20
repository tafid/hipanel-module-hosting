<?php
use hipanel\helpers\Url;
use hipanel\modules\stock\grid\ModelGridView;
use hipanel\modules\stock\models\Model;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title = Yii::t('app', 'Models');
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->breadcrumbs->setItems([
    $this->title,
]); ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
<?php $box->beginActions() ?>
<?= $box->renderCreateButton(Yii::t('app', 'Create model')) ?>

<?= $box->renderSearchButton() ?>
<?= $box->renderSorter([
    'attributes' => [
        'type',
        'brand',
        'model',
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php $box->endActions() ?>
<?php $box->renderBulkActions([
    'items' => [
        $box->renderBulkButton(Yii::t('app', 'Show for users'), Url::to('@model/unmark-hidden-from-user')),
        $box->renderBulkButton(Yii::t('app', 'Hide from users'), Url::to('@model/mark-hidden-from-user')),
        $box->renderBulkButton(Yii::t('app', 'Update'), Url::to('@model/update')),
    ],
]) ?>
<?= $box->renderSearchForm(compact(['types', 'brands'])) ?>
<?php $box->end() ?>
<?php $box->beginBulkForm() ?>
<?= ModelGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        'checkbox',
        'type',
        'brand',
        'model',
        'descr',
        'partno',
        'dtg',
        'sdg',
        'm3',
        'last_prices',
        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end() ?>