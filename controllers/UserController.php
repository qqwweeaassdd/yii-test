<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Register;
use app\models\LoginForm;
use app\models\ProfileForm;
use app\models\User;

class UserController extends Controller
{
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
     * Index page action
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Registration page action
     * @return string
     */
    public function actionRegister()
    {
        // user authorized
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Register();

        // TODO: think about user who tries to register twice but didn't confirmed
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Data is correct.

            $model->secure = md5(time() . rand(100, 999));
            $model->used = false;
            if (!$model->save()) {
                $model->addError('email', 'DB error. Try later.');
            } else {
                // Send email
                // TODO: Send email

                // TODO: temporary email replacement
                return $this->redirect([
                    'register-success', 
                    'secure' => $model->secure, 
                    'email' => $model->email, 
                ]);
            }
        }

        // either the page is initially displayed or there is some validation error
        // Use $model->getErrors()

        return $this->render('register', ['model' => $model]);
    }

    /**
     * Registration page action
     * @return string
     */
    public function actionRegisterSuccess()
    {
        // user authorized
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // we will use almost the same url for confirming
        // TODO: adequate url generating
        $confirmUrl = 'http://' . $_SERVER['SERVER_NAME']
            . str_replace('register-success&', 'register-confirm&', $_SERVER['REQUEST_URI']);

        return $this->render('register-message', ['confirmUrl' => $confirmUrl]);
    }

    /**
     * Registration page action
     * @return string
     */
    public function actionRegisterConfirm()
    {
        // user authorized
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $get = Yii::$app->request->get();
        if ($get && Register::checkConfirm($get['email'], $get['secure'])) {
            // TODO: user register
            User::register($get['email']);

            return $this->redirect(['profile']);
        }

        return $this->goHome();
    }

    /**
     * Profile page action
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        // user authorized
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // TODO: get real user
        $user = User::findIdentity('qwe02@mail.ru');

        if (Yii::$app->request->post()) {
            if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                $user->update();
            }
        }

        return $this->render('profile', ['model' => $user]);
    }

    /**
     * Login page action
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        // User is authorized
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


//print_r($user); die('+'.$user);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // user authorized
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * User logout action
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
