<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.04.2017
 * Time: 12:26
 */

namespace app\models;

use Yii;
use yii\base\Model;

class MyForm extends Model
{
    public $name;
    public $email;
    public $file;

    public function rules() {
        return [
            [['name', 'email'], 'required', 'message' => 'Незаполненное поле'],
            ['email', 'email', 'message' => 'Не корректный e-mail адрес!'],
            [['file'], 'file', 'extensions' => 'jpg, png']
        ];
    }

}

?>