<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 24-Jan-19
 * Time: 13:12
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

    protected $viewPath = '/home/';

    /**
     * Home index action
     */
    public function index()
    {
        return view($this->viewPath . 'index', ['title' => 'Home', 'main' => true]);
    }
}