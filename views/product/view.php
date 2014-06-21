<?php
use \Yii;
use yii\helpers\Url;

use app\widgets\Menu;

/**
 * @var app\components\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div class="container">
    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
        	<?= $this->renderFile('@app/views/product/_product.php', ['meta'=>$meta]) ?>
		</div>
    </div>
</div>
