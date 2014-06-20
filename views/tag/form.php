<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\widgets\Menu;

/**
 * @var yii\web\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        	<h1><?= \Yii::t('tag', $meta->id ? 'Edit tag' : 'Create a tag') ?></h1>
        
            <?php $form = ActiveForm::begin([
            	'id' => 'login-form',
            	'type' => ActiveForm::TYPE_HORIZONTAL,
            ]) ?>
            
                <?= $form->field($i18n, 'name') ?>
				<?= $form->field($i18n, 'text')->textarea(['rows'=>20]) ?>
                
				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
