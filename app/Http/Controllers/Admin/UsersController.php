<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        # withTrashed()  - include soft deleted records
        $all_users = $this->user->withTrashed()->latest()->paginate(5);

        return view('admin.users.index')
                ->with('all_users', $all_users);
    }


    public function deactivate($id)
    {
        $this->user->destroy($id);

        return redirect()->back();
    }


    public function activate($id)
    {
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        # onlyTrashed() - retrieves soft deleted records only
        # restore() - this will set deteled_at column to NULL

        return redirect()->back();
    }
}
