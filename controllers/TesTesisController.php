<?php

namespace app\controllers;

use app\models\TesTesis;
use app\models\TesTesisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\CoreController;
use Exception;
use Yii;

/**
 * TesTesisController implements the CRUD actions for TesTesis model.
 */
class TesTesisController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TesTesis models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TesTesisSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TesTesis model.
     * @param int $tes_codigo Tes Codigo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tes_codigo)
    {
        return $this->render('view', [
            'model' => $this->findModel($tes_codigo),
        ]);
    }

    /**
     * Creates a new TesTesis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TesTesis();

        if ($model->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->tes_fecha_ing = date('Y-m-d H:i:s');
                $model->tes_fecha_mod = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    throw new Exception(implode('<br />', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0, false)));
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                $controller = Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
                CoreController::getErrorLog(\Yii::$app->user->identity->id, $e, $controller); 
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('succes', 'Registro creado exitosamente. ');
            return $this->redirect(['view', 'tes_codigo' => $model->tes_codigo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TesTesis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $tes_codigo Tes Codigo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tes_codigo)
    {
        $model = $this->findModel($tes_codigo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tes_codigo' => $model->tes_codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TesTesis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $tes_codigo Tes Codigo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tes_codigo)
    {
        $this->findModel($tes_codigo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TesTesis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $tes_codigo Tes Codigo
     * @return TesTesis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tes_codigo)
    {
        if (($model = TesTesis::findOne(['tes_codigo' => $tes_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
