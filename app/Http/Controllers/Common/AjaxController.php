<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 2:51 PM
 */

namespace App\Http\Controllers\Common;


use App\Cost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    /**
     * Get table last id
     * @param string $table
     * @return int|mixed
     */
    public function getTableLastId($table) {
        return $this->getTableLastId($table);
    }

    /**
     * Delete cost
     * @param int $id
     * @return void
     */
    public function deleteCost($id) {
        $cost = Cost::find($id);
        if(!empty($cost))
            $cost->delete();
    }
}