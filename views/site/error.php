<?php

use app\widgets\Menu;

/**
 * @var app\components\View $this
 */
?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>
			<i class="glyphicon glyphicon-thumbs-down" style="color:red"></i>
			Upps!
			<small>An error occured<small></h1>

		<pre><?= $message ?></pre>
	</div>
</div>
