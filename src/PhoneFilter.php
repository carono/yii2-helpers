<?php

namespace carono\yii2helpers;

use carono\yii2helpers\PhoneHelper;
use yii\validators\FilterValidator;

class PhoneFilter extends FilterValidator
{
    public function init()
    {
        $this->filter = function ($value) {
            return PhoneHelper::normalNumber($value);
        };
        parent::init();
    }

}