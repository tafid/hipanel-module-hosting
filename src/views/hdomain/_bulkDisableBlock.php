<?php
use hipanel\helpers\Url;
use hipanel\widgets\ArraySpoiler;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'id' => 'bulk-disable-block-form',
    'action' => Url::toRoute('bulk-disable-block'),
    'enableAjaxValidation' => false,
]) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('hipanel:hosting', 'Affected domains') ?></div>
        <div class="panel-body">
            <?= ArraySpoiler::widget([
                'data' => $models,
                'visibleCount' => count($models),
                'formatter' => function ($model) {
                    return $model->domain;
                },
                'delimiter' => ',&nbsp; '
            ]); ?>
        </div>
    </div>

<?php foreach ($models as $item) : ?>
    <?= Html::activeHiddenInput($item, "[$item->id]id") ?>
    <?= Html::activeHiddenInput($item, "[$item->id]domain") ?>
<?php endforeach; ?>

    <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'comment')->textInput([
                    'id' => 'domain-unblock-comment',
                    'name' => 'comment'
                ]); ?>
            </div>
    </div>

    <hr>
<?= Html::submitButton(Yii::t('hipanel', 'Unblock'), ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>
