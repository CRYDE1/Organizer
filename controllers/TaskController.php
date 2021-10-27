<?php

namespace app\controllers;

use app\models\GroupTask;
use app\models\Task;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class TaskController extends \yii\web\Controller
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

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!empty($_GET['t'])) {
            $typeTasks = $_GET['t'];
            switch ($typeTasks) {
                case 'all':
                    $tasksTitle = 'Все';
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id])->all();
                    break;
                case 'today':
                    $tasksTitle = 'Сегодня';
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id, 'date' => date("Y-m-d")])->all();
                    break;
                case 'prev':
                    $tasksTitle = 'Прошедшее';
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id])->all();
                    foreach ($tasks as $taskIndex => $task) {
                        if ($task['date'] >= date("Y-m-d")) {
                            unset($tasks[$taskIndex]);
                        }
                    }
                    break;
                default:
                    $tasksTitle = 'Группа ' . $typeTasks;
                    $group_id = GroupTask::findOne(['name' => $typeTasks])->id;
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id, 'group_id' => $group_id])->all();
            }
            if (!empty($_GET['sortBy'])) {
                $sortBy = $_GET['sortBy'];
                switch ($sortBy) {
                    case 'priority':
                        usort($tasks, function ($a, $b) {
                            if ($a['priority'] == $b['priority']) {
                                return 0;
                            } else {
                                return $a['priority'] < $b['priority'] ? 1 : -1;
                            }
                        });
                        break;
                }
            }
            if (!empty($_POST['selectTask'])) {
                $group = new GroupTask([
                    'name' => $_POST['nameGroup'],
                    'user_id' => Yii::$app->user->id
                ]);
                if ($group->save()) {
                    foreach ($_POST['selectTask'] as $value) {
                        $task = Task::findOne(['id' => $value]);
                        $task->group_id = $group->id;
                        $task->save();
                    }
                    $this->redirect('?t=' . $_GET['t']);
                }
            }
            $model = new \app\models\Task();
            if (!empty($_GET['deleteGroup'])) {
                $Grouptask = GroupTask::findOne($_GET['deleteGroup']);
                $Grouptask->delete();
                $this->redirect('?t=all');
            }
            if (!empty($_GET['file'])) {
                $task = Task::findOne($_GET['file']);
                if (!empty($_FILES["Task"])) {
                    ($_FILES["Task"]["name"]["file"] ? $task->file = UploadedFile::getInstance($task, 'file') : "");
                    if ($task->file && $task->validate()) {
                        $task->file->saveAs(Yii::getAlias('@app/files/' . $task['user_id'] . '_' . $task->file->baseName . '.' . $task->file->extension));
                        $task->update();
                    }
                    $this->redirect('?t=' . $_GET['t']);
                }
            }
            if (!empty($_GET['deleteFile'])) {
                $task = Task::findOne($_GET['deleteFile']);
                unlink(Yii::getAlias('@app/files/' . $task['user_id'] . '_' . $task->file));
                $task->file = null;
                $task->save();
                $this->redirect('?t=' . $_GET['t']);
            }
            if (!empty($_GET['priority'])) {
                if ($model->load(Yii::$app->request->post())) {
                    $task = Task::findOne($_GET['priority']);
                    if (!empty($model->priority)) $task->priority = $model->priority;
                    $task->update();
                    $this->redirect('?t=' . $_GET['t']);
                }
            }
            if (!empty($_GET['inc_exp'])) {
                if ($model->load(Yii::$app->request->post())) {
                    $task = Task::findOne($_GET['inc_exp']);
                    if (!empty($model->income)) $task->income = $model->income;
                    if (!empty($model->expense)) $task->expense = $model->expense;
                    $task->update();
                    $this->redirect('?t=' . $_GET['t']);
                }
            }
            if (!empty($_GET['delete'])) {
                $task = Task::findOne($_GET['delete']);
                $task->delete();
                $this->redirect('?t=' . $_GET['t']);
            }
            if (!empty($_GET['update'])) {
                if ($model->load(Yii::$app->request->post())) {
                    $task = Task::findOne($_GET['update']);
                    if (!empty($model->title)) $task->title = $model->title;
                    if (!empty($model->description)) $task->description = $model->description;
                    $task->update();
                    $this->redirect('?t=' . $_GET['t']);
                }
            }
            if (!empty($_GET['add_task'])) {
                if ($model->load(Yii::$app->request->post())) {
                    $model->user_id = Yii::$app->user->id;
                    if ($model->validate()) {
                        $model->save();
                        $this->redirect('?t=' . $_GET['t']);
                    }
                }
            }
            return $this->render('index', compact('tasks', 'tasksTitle', 'model'));
        } else return $this->render('index');
    }
}
