<?php
namespace app\widgets;

use yii\base\Widget;

class ContactList extends Widget {

	public $contacts;

	public function run() {
		echo $this->render('contact_list', [
			'contacts' => $this->contacts,
		]);
	}
	
}

