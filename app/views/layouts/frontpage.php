<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@app/views/layouts/html.php') ?>
<div class="container-fluid" id="content">
	<?php $this->beginContent('@app/views/layouts/flashmessages.php') ?><?php $this->endContent() ?>
	<?= $content ?>
</div>
<?php $this->endContent() ?>
