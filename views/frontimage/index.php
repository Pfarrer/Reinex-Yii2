<?php

use app\helpers\Url;
use app\widgets\Menu;

/**
 * @var app\components\View $this
 * @var app\models\Metaproduct[] $products
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1>Frontimages</h1>
            
            <div>
            	<a href="<?= Url::to(['create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('tag', 'Create a Frontimage') ?>
            	</a>
            </div>

            <ul class="list-group">
				<?php foreach ($metas as $id=>$fimage): ?>
            	<li class="list-group-item">
            		<a href="<?= Url::to(['edit', 'id'=>$fimage->id]) ?>">
            			<i class="glyphicon glyphicon-pencil"></i>
            			<?php if ($fimage->i18n): ?>
            				<?= $fimage->i18n->name ?>
            			<?php else: ?>
            				<i><?= Yii::t('common', 'Translation missing!') ?></i>
            			<?php endif; ?>
            		</a>

					<div class="pull-right">
						<a class="danger" href="<?= Url::to(['delete', 'id'=>$fimage->id]) ?>" onclick="return confirm('Wirklich löschen?')">
							<i class="glyphicon glyphicon-trash"></i>
						</a>
					</div>

				</li>
            	<?php endforeach; ?>
            </ul>
            
        </div>
    </div>
</div>
