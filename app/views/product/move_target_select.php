<?php
use app\assets\FancyboxAsset;
use app\components\Url;
use app\models\Image;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\widgets\GoBackButton;
use app\widgets\ImageList;
use app\widgets\ImageUpload;
use app\widgets\ImageWidget;
use Embed\Embed;
use kartik\sortable\Sortable;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\components\View $this */
?>

<div class="row clearfix">

	<h1 class="col-md-12">Move <?= sizeof($image_selected) ?> Images</h1>

	<div class="col-md-12">
		<?php $form = ActiveForm::begin([
			'id' => 'image-move',
			'action' => Url::to(['edit_images', 'id'=>$id]),
		]) ?>

		<input type="hidden" name="action" value="move">

		<?php foreach ($image_selected as $image_id): ?>
			<input type="hidden" name="image_selected[]" value="<?= $image_id ?>">
		<?php endforeach; ?>

		<ul class="list-group">
			<?php foreach ($products as $meta): ?>

				<li class="list-group-item">
					<label>
						<input type="radio" name="target_id" value="<?= $meta->id ?>">
						<?= $meta->i18n ? $meta->i18n->name : 'Keine Übersetzung vorhanden' ?>
					</label>

					<ul class="list-group">
						<?php foreach ($meta->children as $meta): ?>

							<li class="list-group-item">
								<label>
									<input type="radio" name="target_id" value="<?= $meta->id ?>">
									<?= $meta->i18n ? $meta->i18n->name : 'Keine Übersetzung vorhanden' ?>
								</label>
							</li>

						<?php endforeach; ?>
					</ul>
				</li>

			<?php endforeach; ?>
		</ul>

		<?= GoBackButton::widget() ?>

		<div class="form-group pull-right">
			<?= Html::submitButton(Yii::t('common', 'Move'), ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end() ?>
	</div>

</div>