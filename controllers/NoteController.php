<?php

namespace app\controllers;

use app\models\Note;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class NoteController extends \yii\web\Controller
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
        $notes = Note::find()->where(['user_id' => \Yii::$app->user->id])->all();
        $model = new \app\models\Note();
        if(!empty($_GET['delete'])){
            $note = Note::findOne($_GET['delete']);
            $note->delete();
            $this->redirect('note');
        }
        if(!empty($_GET['update'])){
            if ($model->load(Yii::$app->request->post())) {
                $note = Note::findOne($_GET['update']);
                if(!empty($model->text)) $note->text = $model->text;
                $note->update();
                $this->redirect('note');
            }
        }
        if(!empty($_GET['add_note'])) {
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->id;
                if ($model->validate()) {
                    $model->save();
                    $this->redirect('note');
                }
            }
        }
        return $this->render('index', compact('notes', 'model'));
    }
}
