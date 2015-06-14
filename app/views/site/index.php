<?php
/** @var $this yii\web\View */
/** @var $contacts app\models\MetaContact[] */
?>
	 
<div class="section row" data-anchor="contact">
	<h1><?= Yii::t('menu', 'Contact') ?></h1>
	<?= \app\widgets\ContactList::widget(['contacts' => $contacts]) ?>
</div>
