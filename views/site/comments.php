<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.05.2017
 * Time: 18:16
 */
use yii\widgets\LinkPager;
?>

<h1>Комментарии</h1>
<ul>
<?php foreach ($comments as $comment) : ?>
    <li><b><?=$comment->name?>: </b><?=$comment->text?></li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>