<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/17/19
 * Time: 4:32 PM
 */

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $viewPath = '/settings/';

    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->post();
            foreach($data['setting'] as $id => $values) {
                $setting = Setting::find($id);
                if(!empty($setting)) {
                    $setting->value = $values['value'];
                    $setting->save();
                    $this->activityLog::addModifyActivityLog('Modify settings', $this->user->id);
                }
            }
        }

        $data = Setting::all();

        return view($this->viewPath . 'index', [
            'title' => 'All Settings',
            'description' => 'Showing all settings',
            'data' => $data
        ]);
    }
}