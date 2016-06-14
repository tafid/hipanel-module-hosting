<?php
$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'models' => $models,
    'currencyTypes' => reset($models)->scenario === 'update' ? $currencyTypes : null,
]); ?>