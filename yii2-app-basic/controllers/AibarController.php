<?php

namespace app\controllers;


use app\models\Praktika;
use app\models\PraktikaForm;
use Symfony\Component\Mime\Email;
use yii\web\Controller;
use Google_Client;
use Google_Service_Oauth2;
use app\models\AibarUser;
use Yii;


class AibarController extends Controller
{
    public $email;
    private $_user = false;

    public function actionPraktika()
    {
        $id = 'айди практики: ';
        $model = new PraktikaForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id .= $model->praktika_id;
        }
        return $this->render('praktikaForm', ['model' => $model, 'id' => $id]);

    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model=new AibarUser;
        $clientID = "211377655141-rmf1153l0kamtqvsufojbf217hpttjmj.apps.googleusercontent.com";
        $secret = "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";

        // Google API Client
        $gclient = new Google_Client();

        $gclient->setClientId($clientID);
        $gclient->setClientSecret($secret);
        $gclient->setRedirectUri('http://localhost/yii-test/yii2-app-basic/web/aibar/login');


        $gclient->addScope('email');
        $url=$gclient->createAuthUrl();
        if (isset($_GET['code'])) {
            // Get Token
            $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

            // Check if fetching token did not return any errors
            if (!isset($token['error'])) {
                // Setting Access token
                $gclient->setAccessToken($token['access_token']);

                // store access token
                $_SESSION['access_token'] = $token['access_token'];

                // Get Account Profile using Google Service
                $gservice = new Google_Service_Oauth2($gclient);

                // Get User Data
                $udata = $gservice->userinfo->get();
                $this->email = $udata['email'];

                $user=$model->findIdentityByEmail($this->email);
                if(!$user){
                    $model->email=$this->email;
                    $model->save();
                    $user=$model->findIdentityByEmail($this->email);
                    Yii::$app->user->login($user);
                }
                else{
                    Yii::$app->user->login($user);
                }
                return $this->redirect(['./']);
            }
        }
        return $this->render('login',['url'=>$url]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}