<?php


namespace carono\yii2helpers;


use yii\db\ActiveRecord;

class SortHelper
{
    /**
     * @param ActiveRecord|string $class
     * @return array
     */
    public static function formAttributes($class)
    {
        $columns = $class::getDb()->getTableSchema($class::tableName())->getColumnNames();
        $result = [];
        foreach ($columns as $column) {
            $result[$column] = ['asc' => [$column => SORT_ASC], 'desc' => [$column => SORT_DESC]];
        }
        return $result;
    }

    public static function getRequestAttribute($withOrder = false)
    {
        $attr = \Yii::$app->request->get('sort');
        return $withOrder ? $attr : ltrim($attr, '-');
    }

    public static function getRequestOrder()
    {
        $attr = self::getRequestAttribute(true);
        if ($attr) {
            return strpos($attr, '-') === 0 ? SORT_DESC : SORT_ASC;
        } else {
            return false;
        }
    }
}