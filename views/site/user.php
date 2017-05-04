<?php
/**
 * Created by PhpStorm.
 * User: WolfGrin
 * Date: 04.05.2017
 * Time: 0:25
 */
use \app\components\Hello;
?>

<?=$name?>

<div>Виджет говрит: <?=Hello::widget(['message' => "Hello World"])?></div>
