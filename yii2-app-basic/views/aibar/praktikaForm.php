<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Praktika;

?>

<?php

if(Yii::$app->session->hasFlash('success'))
{
    echo Yii::$app->session->getFlash('success');
}

?>



<div class="position-absolute top-50 start-50 translate-middle">
    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'praktika_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Praktika::find()->all(),'id','name'),
    'language' => 'ru',
    'options' => ['placeholder' => 'Практика'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    ]); 
    ?>

    <?= Html::submitButton('Нажать чтобы узнать айдишник',['class'=>'btn btn-success ']); ?>
    <?php ActiveForm::end();?>
    <p><?php echo $id; ?></p>
</div>