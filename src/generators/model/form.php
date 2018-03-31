<?php

use yii\gii\generators\model\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\model\Generator */

echo $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->dropDownList([
    Generator::RELATIONS_NONE => 'No relations',
    Generator::RELATIONS_ALL => 'All relations',
    Generator::RELATIONS_ALL_INVERSE => 'All relations with inverse',
]);
echo $form->field($generator, 'generateRelationsFromCurrentSchema')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'generateExtendedFile')->checkbox();
echo $form->field($generator, 'extendedModelNs');
echo $form->field($generator, 'extendedQueryNs');
echo $form->field($generator, 'doNotGenerateGetDbInTheBaseModel')->checkbox();
echo $form->field($generator, 'regenerateExtendedFile')->checkbox();
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
echo $form->field($generator, 'useSchemaName')->checkbox();

$this->registerJs(<<<JS
yii.giiExt = (function ($) {
    // model generator: toggle extended-files field
    $('form #generator-generateextendedfile').change(function () {
        $('form .field-generator-regenerateextendedfile').toggle($(this).is(':checked'));
        $('form .field-generator-extendedmodelns').toggle($(this).is(':checked'));
        $('form .field-generator-extendedqueryns').toggle($(this).is(':checked'));
        $('form .field-generator-donotgenerategetdbinthebasemodel').toggle($(this).is(':checked'));
    }).change();
})(jQuery);
JS
,\yii\web\View::POS_END, 'yii.giiExt');
