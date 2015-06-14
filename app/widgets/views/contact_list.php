<?php
use \Yii;
use app\components\Url;

/** @var $this yii\web\View */
/** @var $contacts app\models\MetaContact[] */
?>
<div class="row" id="contacts">
	<?php foreach ($contacts as $contact): ?>
		<div class="contact col-md-6 col-lg-5 col-lg-push-1">
			<div class="clearfix">
				<div class="pull-left">
					<div class="profileimage"
						 style="background-image: url(<?= Url::base().'/images/profile-noimage.png' ?>)">
					</div>
				</div>
				<div class="pull-left">
					<strong class="name"><?= $contact->name ?></strong>

					<?php if ($contact->i18n): ?>
						<div class="department">
							<?= $contact->i18n->department ?>
						</div>
					<?php endif; ?>

					<div class="tel">
						<?= Yii::t('contact', 'Telefon: 0049 {0}', $contact->tel) ?>
					</div>

					<?php if ($contact->mobile): ?>
						<div class="mobile">
							<?= Yii::t('contact', 'Mobile: 0049 {0}', $contact->mobile) ?>
						</div>
					<?php endif; ?>
					
					<?php if ($contact->mail): ?>
						<div class="mail">
							<?= pfarrer\yii2\email\Obfuscator::widget([
								'email' => $contact->mail,
							]) ?>
						</div>
					<?php endif; ?>
					
					<?php if ($contact->skype): ?>
						<div class="skype">
							Skype: <a href="skype:<?= $contact->skype ?>"><?= $contact->skype ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
