<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var User $model */

$this->title = 'Пользователи';
?>
    <div class="user-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php echo $this->render('create', ['model' => $model]); ?>

        <?php Pjax::begin(['id' => 'user-table-container']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout'=> "{items}\n{pager}",
            'columns' => [
                'id',
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'contentOptions' => [
                        'style' => 'text-align: center'
                    ],
                    'buttons' => [
                        'delete' => function ($url) {
                            return Html::a(
                                '<button class="btn alert-danger">Удалить</button>',
                                false,
                                [
                                    'class' => 'pjax-delete-link',
                                    'delete-url' => $url,
                                    'pjax-container' => 'user-table-container',
                                ]
                            );
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end() ?>
    </div>
<?php
$this->registerJs('
    $(".user-index").on("click", ".pjax-delete-link", function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr("delete-url");
        var result = confirm("Подтверждаете удаление?");            
        var pjaxContainer = $(this).attr("pjax-container");         
        console.log("sd");           
        if(result) {
            $.ajax({
                url: deleteUrl,
                type: "post",
                error: function(xhr, status, error) {
                    alert("Ошибка." + xhr.responseText);
                }
            }).done(function(data) {
                $.pjax.reload({container: "#user-table-container", timeout: false});
            });
        }
    });
');