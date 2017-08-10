<?php
/* @var $this CabangController */
/* @var $model Cabang */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', [
    'id' => 'cabang-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => ['class' => 'form-horizontal']
        ]);
?>

<div class="box-body">

    <?php echo $form->errorSummary($model, 'Error: Perbaiki input', null, ['class' => 'callout callout-danger']); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'nama', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'nama', ['class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'autofocus' => 'autofocus']); ?>
            <?php echo $form->error($model, 'nama', ['class' => 'error']); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'alamat', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'alamat', ['class' => 'form-control', 'size' => 60, 'maxlength' => 500]); ?>
            <?php echo $form->error($model, 'alamat', ['class' => 'error']); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'telpon', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'telpon', ['class' => 'form-control', 'size' => 60, 'maxlength' => 500]); ?>
            <?php echo $form->error($model, 'telpon', ['class' => 'error']); ?>
        </div>
    </div>

</div>
<div class="box-footer">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan', ['class' => 'btn btn-info pull-right']); ?>
</div>

<?php
$this->endWidget();
