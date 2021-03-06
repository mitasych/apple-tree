<?php

namespace backend\controllers;

use backend\models\EatForm;
use backend\services\AppleService;
use Yii;
use common\models\Apple;
use common\models\search\AppleSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * @var AppleService
     */
    private $appleService;

    /**
     * AppleController constructor.
     * @param $id
     * @param $module
     * @param AppleService $appleService
     * @param array $config
     */
    public function __construct($id, $module, AppleService $appleService, $config = [])
    {
        $this->appleService = $appleService;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerate(int $count = null)
    {
        $this->appleService->generateApples($count);

        return $this->redirect('index');
    }

    /**
     * Deactivates an existing Apple model.
     * If deactivation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->appleService->removeApple($id);

        return $this->redirect(['index']);
    }

    /**
     * Drops the apple to the ground
     * @param int $id
     * @return string|\yii\web\Response
     * @throws MethodNotAllowedHttpException
     */
    public function actionFall(int $id)
    {
        if (Yii::$app->request->isAjax) {

            try {
                $this->appleService->fallApple($id);

                return Json::encode(['success' => true]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());

                return $this->redirect('index');
            }
        }
        else {
            throw new MethodNotAllowedHttpException();
        }
    }

    /**
     * Changes apple size
     * @param int $id
     * @return string|\yii\web\Response
     * @throws MethodNotAllowedHttpException
     */
    public function actionEat(int $id)
    {
        if (Yii::$app->request->isAjax) {
            try {
                $apple = $this->findModel($id);
                $form = new EatForm($apple);
                if ($form->load(Yii::$app->request->post()) && $form->validate()) {

                    try {
                        $this->appleService->eatApple($form);
                        return 'success';
                    } catch (\DomainException $e) {
                        Yii::$app->session->setFlash('error', $e->getMessage());

                        return $this->redirect('index');
                    }
                }
                return $this->renderAjax('eat_form', ['model' => $form]);
            } catch (NotFoundHttpException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());

                return $this->redirect('index');
            }
        }
        else {
            throw new MethodNotAllowedHttpException();
        }
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested apple does not exist.'));
    }
}
