<?php

namespace app\modules\user\controllers;

use app\models\helpers\ResponceCode;
use app\models\UserInfo;
use yii\web\UploadedFile;
use app\models\SignupForm;
use app\models\UploadImage;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserInfoController implements the CRUD actions for User model.
 */
class UserInfoController extends Controller
{
    public const EVENT_RETURN_VALID_ERROR_FOR_AJAX = 'valid_error';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        // $searchModel = new UserSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        $models = User::find()->where(['status' => User::STATUS_ACTIVE])->with('userinfo')->all();
        
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'models' => $models,
            ]);
        }
        return $this->render('index', [
            'models' => $models,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $userAttr = new UserInfo();
        $imageModel = new UploadImage();
        if (Yii::$app->request->isPost) {
            return User::createUser($model, $userAttr, $imageModel);   
        }

        Yii::$app->assetManager->bundles = [
            'yii\web\YiiAsset' => false,
        ];

        return $this->renderAjax('create', [
            'model' => $model,
            'userAttr' => $userAttr,
            'imageModel' => $imageModel,
        ]);
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userAttr = $model->userinfo;
        $imageModel = new UploadImage();
        
        if (Yii::$app->request->isPost) {
            return UserInfo::updateUserInfo($userAttr, $imageModel, $model->id);
        }
        
        return $this->render('create', [
            'model' => $model,
            'userAttr' => $userAttr,
            'imageModel' => $imageModel,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            return $this->findModel($id)->delete() ? ResponceCode::OK : ResponceCode::ERROR;
        }
        return ResponceCode::ERROR;
    }
    /**
     * To fired user
     * @return ResponceCode
     */
    public function actionToFire()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            return $this->findModel($id)->toFire() ? ResponceCode::OK : ResponceCode::ERROR;
        }
        return ResponceCode::ERROR;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
