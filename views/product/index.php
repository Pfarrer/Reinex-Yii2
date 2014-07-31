<?php
use app\helpers\Url;
use app\widgets\Menu;

/**
 * @var app\components\View $this
 */
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1><?= Yii::t('product', 'Products') ?></h1>
            
            <div>
            	<a href="<?= Url::to(['product/create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('product', 'Create a product') ?>
            	</a>
            </div>

			<?= $this->renderFile('@app/views/product/_products_list.php', ['products'=>$products]) ?>
            
        </div>
    </div>
</div>
