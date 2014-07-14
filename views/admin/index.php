<?php

use app\helpers\Url;
use app\widgets\Menu;

/**
 * @var yii\web\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
           	<h1>Admin Dashboard</h1>

			<ul class="list-group">
				
				<li class="list-group-item">
					<a href="<?= Url::to(['/product']) ?>">
						<?= \Yii::t('product', 'Products') ?>
					</a>
					<span class="badge">0</span>
				</li>
				
				<li class="list-group-item">
					<a href="<?= Url::to(['/tag']) ?>">Tags</a>
					<span class="badge">0</span>
				</li>
				
			</ul>
            
        </div>
    </div>
</div>
