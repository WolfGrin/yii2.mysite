<?php
/**
 * Created by PhpStorm.
 * User: WolfGrin
 * Date: 05.05.2017
 * Time: 2:15
 */

namespace app\components;

use yii\helpers\Html;
use yii\base\Widget;

class Hello extends Widget
{
    public $message;

    public function run() {
        // <p><b><?=$message? ></b></p>
        $b = Html::tag("b", $this->message);
        $p = Html::tag("p", $b);

        return $p;
    }
}
