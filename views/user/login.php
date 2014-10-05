<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Authorization';
?>
<h1>Authorization page</h1>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'login') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
