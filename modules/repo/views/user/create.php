<?php

use app\models\User;
use yii\helpers\Html;


/** @var User $model */
?>
    <div class="user-create">
        <?php yii\widgets\Pjax::begin(['id' => 'user-create-container']) ?>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'options' => ['data-pjax' => true]
        ]); ?>
        <div class="row user-repo-add">
            <div class="col-md-7">
                <?= $form->field($model, 'name')->textInput(); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'type')->dropDownList(User::getTypes()); ?>
            </div>
            <div class="col-md-2 button-block">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']); ?>
            </div>
        </div>
        <?php $form->end(); ?>
        <?php yii\widgets\Pjax::end() ?>
    </div>

<?php

$this->registerJs(
    '$("document").ready(function(){ 
		$("#user-create-container").on("pjax:end", function() {
			$.pjax.reload({container:"#user-table-container"});
		});
    });'
);
?>