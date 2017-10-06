<?php

namespace app\modules\cabinet\controllers;

use app\models\MoneyTransfer;
use app\models\TransferForm;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {

            $id = Yii::$app->user->getId();

            $modelUser = User::findOne($id);

            $modelTransfer = MoneyTransfer::find()->where(['from_user' => $id])->all();

            $transfer = new TransferForm();

            return $this->render('index', [
                'modelUser' => $modelUser,
                'modelTransfer' => $modelTransfer,
                'transfer' => $transfer,
            ]);

        }
    }

    public function actionTransfer()
    {
        $id = Yii::$app->user->getId();

        $modelTransfer = MoneyTransfer::find()->where(['from_user' => $id])->all();
        $moneyTransfer = new MoneyTransfer();
        $modelUser = User::findOne($id);

        $transfer = new TransferForm();

        $transferForm = Yii::$app->request->post('TransferForm');

        if (!User::find()->where(['username' => $transferForm['to_user']])->exists()) {

            if ($transferForm['to_user'] === '') {
                $length = 8;
                $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ';
                $numChars = strlen($chars);
                $string = '';

                for ($i = 0; $i < $length; $i++) {
                    $string .= substr($chars, rand(1, $numChars) - 1, 1);
                }

                $model = User::find()->where(['username' => $string])->exists();

                if (!$model) {
                    $user = new User();
                    $user->username = $string;
                    $user->setPassword('123');
                    $user->generateAuthKey();
                    $user->save();
                }

                $user->balance = $user->balance + (float)$transferForm['money'];
                $user->save();

            } else {
                $user = new User();
                $user->username = $transferForm['to_user'];
                $user->setPassword('123');
                $user->generateAuthKey();
                $user->save();
            }
        }

        if (User::find()->where(['username' => $transferForm['to_user']])->exists() && $modelUser->balance >= 0) {

            $toUser = User::find()->where(['username' => $transferForm['to_user']])->one();

            if (Yii::$app->request->isPost) {

                $user = User::findOne($id);

                $moneyUser = $user->balance - (float)$transferForm['money'];
                $user->balance = $moneyUser;
                $user->save();

                $toUser->balance = $toUser->balance + (float)$transferForm['money'];
                $toUser->save();
            }

            if ($moneyTransfer->validate() && Yii::$app->request->isPost && $id !== Yii::$app->request->post('TransferForm')) {

                $moneyTransfer->from_user = $id;
                $moneyTransfer->to_user = $toUser->id;
                $moneyTransfer->money = $transferForm['money'];

                $moneyTransfer->save();
            }

            $modelTransfer = MoneyTransfer::find()->where(['from_user' => $id])->all();
            $modelUser = User::findOne($id);

            return $this->render('index', [
                'modelUser' => $modelUser,
                'modelTransfer' => $modelTransfer,
                'transfer' => $transfer,
            ]);
        } else {
            return $this->render('index', [
                'modelUser' => $modelUser,
                'modelTransfer' => $modelTransfer,
                'transfer' => $transfer,
            ]);
        }
    }
}
