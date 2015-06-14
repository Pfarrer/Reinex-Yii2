<?php namespace app\widgets;

class ContactList extends \yii\base\Widget
{
	public $contacts;

	public function run()
	{
		$this->view->registerCssFile('css/contacts.css');
		return $this->render('contact_list', [
			'contacts' => $this->contacts,
		]);
	}
}