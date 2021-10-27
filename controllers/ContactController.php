<?php

namespace app\controllers;

use app\models\Contact;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ContactController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $contacts = Contact::find()->where(['user_id' => \Yii::$app->user->id])->all();
        $model = new \app\models\Contact();
        if(!empty($_GET['delete'])){
            $contact = Contact::findOne($_GET['delete']);
            $contact->delete();
            $this->redirect('contact');
        }
        if(!empty($_GET['update'])){
            if ($model->load(Yii::$app->request->post())) {
                $contact = Contact::findOne($_GET['update']);
                if(!empty($model->fio)) $contact->fio = $model->fio;
                if(!empty($model->phone)) $contact->phone = $model->phone;
                if(!empty($model->address)) $contact->address = $model->address;
                $contact->update();
                $this->redirect('contact');
            }
        }
        if(!empty($_GET['add_contact'])) {
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->id;
                if ($model->validate()) {
                    $model->save();
                    $this->redirect('contact');
                }
            }
        }
        return $this->render('index', compact('contacts', 'model'));
    }
}
