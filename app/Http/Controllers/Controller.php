<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $constants;

    public function __construct()
    {
        $this->constants = $this->getConstants();
    }

    public function getConstants() {
        return require(__DIR__ . '../../../../config/constants.php');
    }
}
