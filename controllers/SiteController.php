<?php

namespace app\controllers;

use app\models\GroupTask;
use app\models\Task;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        $tasks = [];
//        $tasksTitle = '';
        //echo '<pre>'.print_r($tasksToday).'</pre>';
        if(!empty($_GET['t'])) {
            $typeTasks = $_GET['t'];
            switch ($typeTasks) {
                case 'today':
                    $tasksTitle = 'Сегодня';
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id, 'date' => date("Y-m-d")])->all();
                    break;
                case 'prev':
                    $tasksTitle = 'Прошедшее';
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id])->all();
                    foreach ($tasks as $taskIndex => $task){
                        if($task['date'] >= date("Y-m-d")){
                            unset($tasks[$taskIndex]);
                        }
                    }
                    break;
                default:
                    $tasksTitle = 'Группа '.$typeTasks;
                    $group_id = GroupTask::findOne(['name' => $typeTasks])->id;
                    $tasks = Task::find()->asArray()->where(['user_id' => Yii::$app->user->id, 'group_id' => $group_id])->all();
            }
            return $this->render('index', compact('tasks','tasksTitle'));
        }
        else return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user = new User();
                $user->username = $model->username;
                $user->password = $model->password;
                $user->generateAuthKey();
                $user->save();
                $this->redirect('/web/site/login');
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
