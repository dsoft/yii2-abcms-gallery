<?php

namespace abcms\gallery\module;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'abcms\gallery\module\controllers';
    
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'album';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
