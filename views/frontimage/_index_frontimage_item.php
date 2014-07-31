<?php
use app\helpers\Url;

/**
 * @var app\components\View $this
 */
?>

<a href="<?= Url::to(['edit', 'id'=>$meta->id]) ?>">
	<i class="glyphicon glyphicon-pencil"></i>
    <?= $meta->i18n ? $meta->i18n->name : '<i>'.Yii::t('common', 'Translation missing!').'</i>' ?>
</a>

<input type="hidden" name="frontimages_sort[]" value="<?= $meta->id ?>" />

<div class="pull-right">
	<a class="danger" href="<?= Url::to(['delete', 'id'=>$meta->id]) ?>" onclick="return confirm('Wirklich löschen?')">
		<i class="glyphicon glyphicon-trash"></i>
	</a>
</div>