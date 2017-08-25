<?php


namespace carono\yii2helpers;


use yii\base\Action;
use yii\helpers\Inflector;

class BreadcrumbsHelper
{
    /**
     * @param Action $action
     * @param array $params
     */
    public static function formCrumbs($action, $params)
    {
        $name = 'crumb' . Inflector::camelize($action->getUniqueId());
        $class = get_called_class();
        if (method_exists($class, $name)) {
            $reflectionMethod = new \ReflectionMethod($class, $name);
            $data = [];
            foreach ($reflectionMethod->getParameters() as $p) {
                $data[] = isset($params[$p->getName()]) ? $params[$p->getName()] : null;
            }
            $action->controller->getView()->params['breadcrumbs'] = call_user_func_array([$class, "$name"], $data);
        }
    }
}