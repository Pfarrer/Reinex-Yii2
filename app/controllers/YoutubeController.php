<?php
namespace app\controllers;

use yii\web\Controller;

class YoutubeController extends Controller
{
	public function actionIndex()
	{
		return $this->redirect('https://www.youtube.com/channel/UCC50sZe3kHfvykz8-NIj2UA');
	}
}