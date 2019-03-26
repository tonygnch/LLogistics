<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 12:45 AM
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $viewPath = '/users/';

    /**
     * Index action for users
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = User::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Users',
            'description' => 'Showing all users',
            'data' => $data
        ]);
    }

    /**
     * Add action for users
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $user = new User();

            foreach ($data as $property => $value) {
                $user->{$property} = $value;
            }

            $user->setResetHash($data['email']);

            $user->save();

            $this->activityLog::addAddActivityLog('Add user "' . $data['email'] . '"', $this->user->id);

            return redirect(route('users'));
        } else {
            $roles = $this->getRolesAsObject();

            $inputs = [
                'Username' => (object)[
                    'name' => 'username',
                    'type' => 'text',
                    'required' => true
                ],

                'Email' => (object)[
                    'name' => 'email',
                    'type' => 'email',
                    'required' => true
                ],

                'First Name' => (object)[
                    'name' => 'first_name',
                    'type' => 'text',
                    'required' => true
                ],

                'Last Name' => (object)[
                    'name' => 'last_name',
                    'type' => 'text',
                    'required' => false
                ],

                'Role' => (object)[
                    'name' => 'role',
                    'type' => 'select',
                    'values' => $roles,
                    'required' => true
                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add User',
                'inputs' => $inputs,
                'action' => route('addUser'),
                'description' => 'Add new user'
            ]);
        }
    }

    /**
     * Add action for users
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var user $user */
        $user = user::find($id);

        if ($request->isMethod('POST')) {
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $user->update($data);

            $this->activityLog::addModifyActivityLog('Modify user "' . $data['email'] . '"', $this->user->id);

            return redirect(route('users'));
        } else {
            if (!empty($user)) {
                $roles = $this->getRolesAsObject();

                $inputs = [
                    'Username' => (object)[
                        'name' => 'username',
                        'type' => 'text',
                        'value' => $user->usename,
                        'required' => true
                    ],

                    'Email' => (object)[
                        'name' => 'email',
                        'type' => 'email',
                        'value' => $user->email,
                        'required' => true
                    ],

                    'First Name' => (object)[
                        'name' => 'first_name',
                        'type' => 'text',
                        'value' => $user->first_name,
                        'required' => true
                    ],

                    'Last Name' => (object)[
                        'name' => 'last_name',
                        'type' => 'text',
                        'value' => $user->last_name,
                        'required' => false
                    ],

                    'Role' => (object)[
                        'name' => 'role',
                        'type' => 'select',
                        'values' => $roles,
                        'required' => true
                    ]
                ];

                return view($this->viewPath . 'modify', [
                    'title' => 'Modify user',
                    'description' => 'Modify user ' . $user->name,
                    'data' => $user,
                    'action' => route('modifyUser', $user->id),
                    'inputs' => $inputs,
                ]);
            } else {
                return redirect(route('users'));
            }
        }
    }

    /**
     * Delete action for users
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete($id)
    {
        /** @var User $user */
        $user = User::find($id);
        if (!empty($user)) {
            $user->delete();
            $this->activityLog::addDeleteActivityLog('Delete user "' . $user->email . '"', $this->user->id);
        }

        return redirect(route('users'));
    }

    /**
     * Reset user password
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reset($id)
    {
        /** @var User $user */
        $user = User::find($id);
        if (!empty($user)) {
            $user->setResetHash($user->email);
            $user->save();
        }

        return redirect(route('users'));
    }
}