<?php


namespace carono\yii2helpers;


use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Query;

class QueryHelper
{
    /**
     * @param ActiveRecord $model
     * @param Query $query
     * @param null $alias
     * @param null $db
     */
    public static function regular($model, $query, $alias = null, $db = null)
    {
        /**
         * @var ActiveRecord $class
         */
        $alias = $alias ? $alias : $model::tableName();
        $class = get_class($model);
        $db = $db ?: \Yii::$app->db;
        foreach ($model->safeAttributes() as $attribute) {
            if ($column = $db->getTableSchema($class::tableName())->getColumn($attribute)) {
                $value = $model->getAttribute($attribute);
                if ($column->type == 'text' || $column->type == 'string') {
                    if ($db->driverName == 'pgsql') {
                        $query->andFilterWhere(['ilike', "[[$alias]].[[$attribute]]", $value]);
                    } else {
                        $query->andFilterWhere(['like', "[[$alias]].[[$attribute]]", $value]);
                    }
                } else {
                    $query->andFilterWhere(["[[$alias]].[[$attribute]]" => $value]);
                }
            }
        }
    }
}