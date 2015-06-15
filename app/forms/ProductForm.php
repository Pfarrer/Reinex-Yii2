<?php
namespace app\forms;

use app\models\User;
use Yii;
use yii\base\Model;

class ProductForm extends Model
{
    public $product_meta;
    public $product_i18n;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
}