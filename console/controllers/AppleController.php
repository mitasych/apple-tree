<?php

namespace console\controllers;

use console\services\AppleConsoleService;
use yii\console\Controller;

/**
 * Class AppleController
 * @package console\controllers
 */
class AppleController extends Controller
{
    private $appleService;

    public function __construct($id, $module, AppleConsoleService $appleService, $config = [])
    {
        $this->appleService = $appleService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Promotes rotting apples
     */
    public function actionRot()
    {
        $this->appleService->rotApples();
    }
}