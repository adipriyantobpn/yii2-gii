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

echo "<?php\n";
?>

namespace <?= $generator->extendedModelNs ?>;

use Yii;

/**
 * This is the extended model class for table "<?= $generator->generateTableName($tableName) ?>".
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
class <?= $className ?> extends <?= '\\' . ltrim($generator->ns .'\\'. $className, '\\') . "\n" ?>
{
<?php if ($generator->db !== 'db'): ?>
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>
<?php // @TODO - rules() generation SHOULD BE CONFIGURABLE, whether it is generated in extended model, instead of in base model ?>
<?php // COMPLETED_TODO - relation-based rules SHOULD HAVE GENERATED also in extended model ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = array_merge(parent::rules, [<?= empty($rulesFromRelation) ? '' : ("\n            " . implode(",\n            ", $rulesFromRelation) . ",\n        ") ?>]);

        return $rules;
    }
<?php // COMPLETED_TODO - relation functions SHOULD HAVE GENERATED also in extended model ?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php // COMPLETED_TODO - extended model/query regeneration SHOULD BE CONFIGURABLE via boolean property ?>
<?php if ($queryClassName && $generator->extendedQueryNs): ?>
<?php
    $queryClassFullName = ($generator->extendedModelNs === $generator->extendedQueryNs) ? $queryClassName : '\\' . $generator->extendedQueryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
