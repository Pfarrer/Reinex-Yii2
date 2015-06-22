<?php
namespace app\models;

use app\components\MetaModel;

/**
 * Class DownloadMeta
 *
 * @property int sort
 * @property string filename
 * @property int filesize
 *
 * @property DownloadI18n i18n
 * @property DownloadI18n i18n_any
 */
class DownloadMeta extends MetaModel
{
	public function init()
	{
		parent::init();
		$this->on(self::EVENT_AFTER_DELETE, [$this, 'handleAfterDelete']);
	}

	public function rules()
	{
		return [
			[['sort', 'filesize'], 'integer'],
			['filename', 'string'],
		];
	}

	public function handleAfterDelete($event)
	{
		@unlink('uploads/files/'.$this->filename);
	}

	protected function getI18nClassname()
	{
		return DownloadI18n::className();
	}
}