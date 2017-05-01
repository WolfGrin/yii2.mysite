<?php
/**
 * Created by PhpStorm.
 * User: WolfGrin
 * Date: 01.05.2017
 * Time: 19:08
 */

use yii\helpers\Html;   //необходим для вывода кнопки Submit
use yii\widgets\ActiveForm; //подключаем виджет отвечающий за работу формы

?>
<?php if($name && $email): ?>
<p>Вы ввели имя <b><?=$name?></b> и email <b><?=$email?></b></p>
<?php endif; ?>

<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); //в скобках атрибут для формы ?>
    <?= $f->field($form, 'name') ?>
    <?= $f->field($form, 'email') ?>
    <?= $f->field($form, 'file')->fileInput() ?>
    <?= Html::submitButton('Отправить'); ?>
<?php ActiveForm::end(); ?>
