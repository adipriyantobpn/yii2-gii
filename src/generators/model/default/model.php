<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $rulesFromRelation string[] list of validation rules which generated from related tables */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $uniqueIndexes array list of unique indexes for particular table, including primary-key (name => [columns]) */
/* @var $uniqueIndexesSorted array uniquely-merged & sorted list of unique indexes for particular table, including primary-key (name => [columns]) */

use yii\helpers\VarDumper;

echo "<?php\n";
?>

<?php
// COMPLETED_TODO - code that generated for debugging purpose SHOULD BE CONFIGURABLE via boolean property
echo $generator->generateDebugMessageGroup('unique-indexes', [
    // COMPLETED_TODO - track unique-indexes from tables & the sorted one (for debugging purpose)
    'uniqueIndexes' => VarDumper::dumpAsString($uniqueIndexes),
    'uniqueIndexesSorted' => VarDumper::dumpAsString($uniqueIndexesSorted),
]);
echo $generator->generateDebugMessageGroup('relations (provided by standard model-generator)', [
    // COMPLETED_TODO - track relation array provided by model generator & the sorted one (for debugging purpose)
    'relations' => VarDumper::dumpAsString($relations),
]);

// COMPLETED_TODO - sort relations
$relations = $generator->sortRelation($relations);
// COMPLETED_TODO - code that generated for debugging purpose SHOULD BE CONFIGURABLE via boolean property
echo $generator->generateDebugMessageGroup('relations-sorted (after sorted in the template)', [
    // COMPLETED_TODO - track relation array provided by model generator & the sorted one (for debugging purpose)
    'relationsSorted' => VarDumper::dumpAsString($relations),
]);
echo $generator->generateDebugMessageGroup('table schema', [
    // COMPLETED_TODO - track standard properties, provided by model-generator (for debugging purpose)
    'tableSchema' => VarDumper::dumpAsString($tableSchema),
]);
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if (!$generator->doNotGenerateGetDbInTheBaseModel && $generator->db !== 'db'): // COMPLETED_TODO - static::getDb() generation in the base model SHOULD BE CONFIGURABLE via boolean property ?>

    /**
     * @return null|\yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

<?php // @TODO - rules() generation SHOULD BE CONFIGURABLE, whether it is generated in extended model, instead of in base model ?>
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    /**
     * {@inheritdoc}
     *
     * Returns list of the columns whose values have been populated into this record.
     */
    public function fields()
    {
        $parentFields = parent::fields();
        $fields = array_merge($parentFields, [
<?php $baseClassReflection = new \ReflectionClass($generator->baseClass); if ($baseClassReflection->hasMethod('getInfo')): ?>
            'info' => function ($model) { /** @var $model \<?= $generator->baseClass ?> */
                return $model->getInfo();
            },
<?php endif; ?>
<?php foreach ($properties as $property => $data): ?>
            // '<?= $property ?>' => '<?= $property ?>',
<?php endforeach; ?>
        ]);

<?php // @TODO - authentication & other sensitive column names SHOULD BE LISTED here by using regex ?>
        /* Should remove fields that contain sensitive information */
        // unset(
        //     $fields['auth_key'], // EXAMPLE
        //     $fields['password_hash'],
        //     $fields['password_reset_token']
        // );

        return $fields;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the list of the relations that have been populated into this record.
     */
    public function extraFields()
    {
        $parentExtraFields = parent::extraFields();
        $extraFields = array_merge($parentExtraFields, [
<?php foreach ($relations as $name => $relation): ?>
            // '<?= lcfirst($name) ?>' => '<?= lcfirst($name) ?>',
<?php endforeach; ?>
        ]);

        return $extraFields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php // COMPLETED_TODO - extended model/query regeneration SHOULD BE CONFIGURABLE via boolean property ?>
<?php if ($queryClassName && !$generator->extendedModelNs): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    // -- CUSTOM QUERY should be placed below --

    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
<?php if (!empty($relations)): ?>

    // -- RELATION FUNCTIONS should be placed below --
<?php endif; ?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
}
