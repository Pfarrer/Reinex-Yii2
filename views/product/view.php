<?php
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var app\components\View $this
 */

?>

<?= $this->render("/site/_menu.php") ?>

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
