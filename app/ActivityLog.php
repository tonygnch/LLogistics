<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/26/19
 * Time: 11:02 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    public $timestamps = false;

    protected $fillable = [
        'action',
        'description',
        'user',
        'date'
    ];

    /**
     * Add modify activity log
     * @param string $description
     * @param int $user
     * @return void
     */
    public static function addAddActivityLog($description, $user) {
        $activityLog = new ActivityLog();

        $activityLog->action = 'Add';
        $activityLog->description = $description;
        $activityLog->user = $user;
        $activityLog->date = date('Y-m-d H:i:s');

        $activityLog->save();
    }

    /**
     * Add modify activity log
     * @param string $description
     * @param int $user
     * @return void
     */
    public static function addModifyActivityLog($description, $user) {
        $activityLog = new ActivityLog();

        $activityLog->action = 'Modify';
        $activityLog->description = $description;
        $activityLog->user = $user;
        $activityLog->date = date('Y-m-d H:i:s');

        $activityLog->save();
    }

    /**
     * Add delete activity log
     * @param string $description
     * @param int $user
     * @return void
     */
    public static function addDeleteActivityLog($description, $user) {
        $activityLog = new ActivityLog();

        $activityLog->action = 'Delete';
        $activityLog->description = $description;
        $activityLog->user = $user;
        $activityLog->date = date('Y-m-d H:i:s');

        $activityLog->save();
    }

    /**
     * Add login activity log
     * @param string $description
     * @param int $user
     * @return void
     */
    public static function addLoginActivityLog($description, $user) {
        $activityLog = new ActivityLog();

        $activityLog->action = 'LogIn';
        $activityLog->description = $description;
        $activityLog->user = $user;
        $activityLog->date = date('Y-m-d H:i:s');

        $activityLog->save();
    }
}