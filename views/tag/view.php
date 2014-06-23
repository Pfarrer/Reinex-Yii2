<?php
use \Yii;
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
        
        	<h1><?= Yii::t('tag', 'Category') ?> <i><?= $i18n->name ?></i></h1>

			<?php if (!empty($i18n->body)): ?>
			<div class="well">
				<?= $this->textile($i18n->body) ?>
			</div>
			<?php endif; ?>
			
        </div>

    </div>
</div>
