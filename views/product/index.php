<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            
            <div>
            	<a href="<?= Url::to(['product/create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i> Produkt erstellen
            	</a>
            </div>
            
            <ul>
            	<? foreach ($products as $product): ?>
            	<li>
            		<a href="<?= Url::to(['product/edit', 'id'=>$product->id]) ?>">
            			<?= $product->i18n->title ?>
            		</a>
            	</li>
            	<? endforeach; ?>
            </ul>
            
        </div>
    </div>
</div>
