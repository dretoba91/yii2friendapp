<?php

namespace app\controllers;


use yii;
use yii\web\controller;
use app\models\User;
use app\models\Friends;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;

use yii\db\ActiveQuery;

class FriendsappController extends Controller
{

    public function actionIndex()    
    {
        $user = User::findOne(Yii::$app->user->identity->id);

        $query = User::find()->where(['<>', 'id' , Yii::$app->user->identity->id]);


        $FRIENDquery = Friends::find();
        $status_ACCEPTED = FRIENDS::ACCEPTED;
        $status_PENDING = FRIENDS::PENDING;

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);

        $users = $query->orderBy('id')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        return $this->render('index', [
            'user' => $user,
            'users' => $users,
            'pagination' => $pagination,
            'FRIENDquery' =>$FRIENDquery,
            'status_ACCEPTED' => $status_ACCEPTED,
            'status_PENDING' => $status_PENDING
        ]);
    }

    public function actionUserfriends($id)
    {
        // querying the friends table 
        $query = Friends::find()->where(['or', 'user_id' => $id, 'friend_id' => $id])->all();
        
        $status_PENDING = FRIENDS::PENDING;
        $status_REJECTED = FRIENDS::REJECTED;
        return $this->render('userfriends', 
            [
                'query'=> $query,
                'status_REJECTED' => $status_REJECTED,
                'status_PENDING' => $status_PENDING
            ]
        );
    }

    public function actionAdd($id)
    {
        // querying the friends table 
        $query = Friends::find()->where(['user_id' => Yii::$app->user->identity->id])->where(['friend_id' => $id]);

        //checking condition for the friend status before performing actionAdd
        //getting status value from the Friends model
        if($query->count() == 0){
            $add = new Friends();
            $add->user_id = Yii::$app->user->identity->id;
            $add->friend_id = $id;
            $add->status = Friends::PENDING;

            $add->save();         
            Yii::$app->getSession()->setFlash('success', 'Friend request sent');
            return $this->redirect('index');

        } elseif($query->count() > 0){
            $add = $query->one();
            $add->status = Friends::PENDING;           
            $add->save();
            Yii::$app->getSession()->setFlash('success', 'Friend rquest sent');
            return $this->redirect('index');

         } else{

            Yii::$app->getSession()->setFlash('error', 'you cannot add friend');
            return $this->redirect('index');
        }

    }

    public function actionLeavingrequest($id)
        {
            //get   friend request

            $user = User::findOne($id);

            return $this->render('leavingrequest', ['user'=> $user]);
        }


    public function actionCancel($id, $friends)
    {
        // inspecting the status column to confirm friends status
        $inspect = Friends::find()->where(['user_id' => $id])->where(['friend_id' => $friends])->count();

        //checking condition for the friend status before performing actionReject
        if($inspect == 1){
            $cancel = Friends::find()
            ->where(
                ['user_id' => $id]
            )->where(['friend_id' => $friends])
            ->one();

            //getting status value from the Friends model
            $cancel->status = Friends::REJECTED;

            $cancel->save();         
            Yii::$app->getSession()->setFlash('sucess', 'Friend rquest rejected');

            return $this->redirect('leavingrequest?id='.$id);
        }
    }

    public function actionIncomingrequest($id)
    {
        $user = User::findOne($id);

        return $this->render('incomingrequest', ['user'=> $user]);
    }

    public function actionAccept($id, $friends)
    {
       // inspecting the status column to confirm friends status
       $inspect = Friends::find()->where(['user_id' => $id])->where(['friend_id' => $friends])->count();

       if($inspect > 0){     

        $Accept = Friends::find()->where(['user_id' => $id])->where(['friend_id' => $friends])->one();
        //getting status value from the Friends model
        $Accept->status = Friends::ACCEPTED;

        $Accept->save();         
        Yii::$app->getSession()->setFlash('success', 'Friend Request ACCEPTED');
        return $this->redirect('index');

        } else{
             Yii::$app->getSession()->setFlash('error', 'An error occur');
             return $this->redirect('index');
        }
    }

    public function actionReject($id, $friends)
    {
        $inspect = Friends::find()->where(['user_id' => $id])->where(['friend_id' => $friends])->count();

        if($inspect > 0){     

           $Reject = Friends::find()->where(['user_id' => $id])->where(['friend_id' => $friends])->one();
           //getting status value from the Friends model
           $Reject->status = Friends::REJECTED;
          

           $Reject->save();         
           Yii::$app->getSession()->setFlash('success', 'Friend Request REJECTED');
           return $this->redirect('index.php/friendsapp');
        }else{
           Yii::$app->getSession()->setFlash('error', 'An error occur');
           return $this->redirect('index.php/friendsapp');
       }

    }

    

}