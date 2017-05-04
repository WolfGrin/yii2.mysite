<?php

namespace app\controllers;

use app\models\MyForm;  //импорт пространства имен созданного нами модуля

//use GuzzleHttp\Psr7\UploadedFile;
use yii\data\Pagination;
use yii\web\UploadedFile;

use yii\helpers\Html;   //необходим для вызова метода Html::encode() - экранирует специальные символы
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Comments;


class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
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



    public function actionHello($message = "Hello world!")
    {
        return $this->render('hello', ['message' => $message]); // альтернатива ['message' => $message]     -    compact('message')
    }

    public function actionForm(){
        $form = new MyForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $name = Html::encode($form->name);
            $email = Html::encode($form->email);

            $form->file = UploadedFile::getInstance($form, 'file');
            $form->file->saveAs('files/'.$form->file->baseName.'.'.$form->file->extension);
        }
        else {
            $name = '';
            $email = '';
        }
        return $this->render('form',
            [
                'form' => $form,
                'name' => $name,
                'email' => $email
            ]
        );
    }

    public function actionComments ()
    {
        $comments = Comments::find();

        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $comments->count()
        ]);

        $comments = $comments->offset($pagination->offset)->limit($pagination->limit)->all();

        $cookies = Yii::$app->request->cookies;


        return $this->render('comments', [
            'comments' => $comments,
            'pagination' => $pagination,
            'name' => Yii::$app->session->get('name'),
            'name2' => $cookies->getValue('name')
        ]);
    }

    public function actionUser ()
    {
        $name = Yii::$app->request->get('name', 'Гость');

        $session = Yii::$app->session;
        $session->set('name', $name);

        //if($session->has('name'))
        //$session->remove('name');

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'name',
            'value' => $name
        ]));

        //$cookies->remove('name');

        return $this->render('user', [
            'name' => $name
        ]);
    }
}