<?php
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

?>

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
            
            <ul class="list-group">
            	<? foreach ($products as $product): ?>
            	<li class="list-group-item">
            		<a href="<?= Url::to(['product/edit', 'id'=>$product->id]) ?>">
            			<i class="glyphicon glyphicon-pencil"></i>
            			<?php if ($product->i18n): ?>
            				<?= $product->i18n->title ?>
            			<?php else: ?>
            				<i><?= Yii::t('common', 'Translation missing!') ?></i>
            			<?php endif; ?>
            		</a>
            	</li>
            	<? endforeach; ?>
            </ul>
            
        </div>
    </div>
</div>
