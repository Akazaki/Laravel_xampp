<?php
namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

class WowController extends Controller
{   
    function __construct()
    {
        $isAuthenticated = $this->authService->authorize($req->all());
        
        if($isAuthenticated) {
            $role = $this->authService->getUserRole($req->input('user_id'));
            switch($role) {
                case 'admins':
                    return redirect($this->admin_redirectTo);
                case 'teachers':
                    return redirect($this->teacher_redirectTo);
                case 'parents':
                    return redirect($this->parent_redirectTo);
            }
        } else {
            return redirect()->back()->with('error_msg', config('errors.auth_failed'));
        }
    }

    public function index()
    {
        return view('wow/login');
    }
}