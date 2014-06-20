<?php
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
        	<h1><?= $i18n->name ?></h1>

			<div class="well">
				<?= $i18n->text ?>
			</div>
        </div>

    </div>
</div>
