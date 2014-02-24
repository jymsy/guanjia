<?php
namespace houtaiguanjia\controllers;

use Sky\base\Controller;
class GuideController extends Controller{
	public $layout='column1';
	public function getPageTitle()
	{
		if($this->action->id==='Index')
			return '后台管家-网址导航';
		else
			return '后台管家-'.ucfirst($this->action->id);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
}