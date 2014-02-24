<?php
namespace houtaiguanjia\controllers;
use Sky\base\Controller;
use houtaiguanjia\models\LoginForm;
use Sky\Sky;
class DefaultController extends Controller{
	public $layout='column1';
	
	public function getPageTitle()
	{
		if($this->action->id==='index')
			return '后台管家';
		else
			return '后台管家-'.ucfirst($this->action->id);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionError()
	{
		if($error=Sky::$app->getErrorHandler()->error)
		{
			if(Sky::$app->getRequest()->getIsAjaxRequest())
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionLogin()
	{
		$model=new LoginForm();
		if(isset($_POST['houtaiguanjia_models_LoginForm']))
		{
			$model->attributes=$_POST['houtaiguanjia_models_LoginForm'];
			if($model->login())
			{
				$this->redirect(array('index'));
			}
		}
		
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout()
	{
		Sky::$app->getUser()->logout();
		$this->redirect(array('index'));
	}
	
}