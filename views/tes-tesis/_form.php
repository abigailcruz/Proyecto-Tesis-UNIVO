<?php

use app\models\TinTipoInvestigacion;
use kartik\daterange\DateRangePicker;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crear / Editar registro</h3>
            </div>
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::activeLabel($model, 'tes_codigo', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'tes_codigo', ['showLabels' => false])->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= Html::activeLabel($model, 'test_tema', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'test_tema', ['showLabels' => false])->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::activeLabel($model, 'tes_codtin', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'tes_codtin', ['showLabels' => false])->widget(Select2::class, [
                                'data' => ArrayHelper::map(TinTipoInvestigacion::find()->all(), 'tin_codigo', 'tin_nombre'),
                                'language' => 'es',
                                'options' => ['placeholder' => '- Seleccionar Tipo de Investigacion -'],
                                'pluginOptions' => ['allowClear' => true],
                                
                            ]); ?>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Guardar' : '<i class="fa fa-save"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-ban"></i> Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
                    </div>
                </form>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

