<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile';
?>
<h1>Profile page</h1>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->label('Change your name:'); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
