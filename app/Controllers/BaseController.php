<?php

namespace app\Controllers;

use app\core\base\Controller;

class BaseController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
    }
}
