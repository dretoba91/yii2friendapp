<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\LoginForm;

class UserController extends \yii\web\Controller
{

    public function actionRegister()
    {
	     $user = new user();

	    if ($user->load(Yii::$app->request->post())) {
	        if ($user->validate()) {
	            // Save Record
	            $user->save();
	            //send message
	            yii::$app->getSession()->setFlash('success', 'You are Registered');

	            return $this->redirect('login');
	        }
	    }

	    return $this->render('register', [
	        'user' => $user,
	    ]);
	}
	
	public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(array('index.php/friendsapp'));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
	}
	
	public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

}