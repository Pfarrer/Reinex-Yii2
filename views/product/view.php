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
        	<h1><?= $meta->i18n->title ?></h1>

			<div class="well">
				<?= $this->textile($meta->i18n->body) ?>
			</div>

        </div>

    </div>
</div>
