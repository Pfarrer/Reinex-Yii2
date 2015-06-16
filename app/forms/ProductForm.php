<?php
namespace app\forms;

use app\models\Image;
use app\models\ProductI18n;
use app\models\ProductMedia;
use app\models\ProductMeta;
use Yii;
use yii\base\Model;

class ProductForm extends Model
{
	/**
	 * @var ProductMeta
	 */
	public $meta;

	/**
	 * @var ProductI18n
	 */
	public $i18n;

	/**
	 * @var Image[]
	 */
	public $images;

	/**
	 * @var ProductMedia[]
	 */
	public $medias;

	public function init()
	{
		parent::init();

		if (!Yii::$app->request->isPost) {
			// Init with default values
			$this->meta = new ProductMeta();
			$this->i18n = new ProductI18n();
			$this->images = [];
			$this->medias = [];
		}
	}

    public function rules()
    {
        return [
        ];
    }
}