<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<div id="row-flashmessages" class="row no-gap">
	<div class="col-md-12">
		<?php foreach (Yii::$app->session->getAllFlashes() as $type => $messages): ?>
			<?php foreach ($messages as $message): ?>
				<div class="alert alert-<?= $type ?>"><?= $message ?></div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
</div>