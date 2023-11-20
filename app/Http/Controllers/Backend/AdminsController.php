<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $admins = Admin::all();
        return view('backend.pages.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $roles  = Role::all();
        return view('backend.pages.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        // Validation Data
        $request->validate([
            // 'name' => 'required|max:50',
            'first_name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:admins',
            'username' => 'required|max:100|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        $input = $request->all();
        if ($request->hasFile('profile_image')) {

            $profileImage = $request->file('profile_image');
            $profileImageName = time().$profileImage->getClientOriginalName();
            $profileImage->move('uploads', $profileImageName); 
            $input['profile_image'] = $profileImageName;
            
        }
        
        
        if ($request->hasFile('identity_image')) {

            $profileImage = $request->file('identity_image');
            $profileImageName = time().$profileImage->getClientOriginalName();
            $profileImage->move('uploads', $profileImageName); 
            $input['identity_image'] = $profileImageName;

        }
        $input['password'] = Hash::make($request->password);

        $input['name'] = $input['first_name'];

        $input['name'] .= !empty($input['last_name'])?' '.$input['last_name']:'';
        
        $input['current_state'] = !empty($input['current_state'])?implode(',',$input['current_state']):'';
        $input['current_district'] = !empty($input['current_district'])?implode(',',$input['current_district']):'';
        $input['municipality_panchayat_current'] = !empty($input['municipality_panchayat_current'])?implode(',',$input['municipality_panchayat_current']):'';
        // Create New Admin
        $admin = new Admin();
        $admin->fill($input);
        // $admin->name = $request->name;
        // $admin->username = $request->username;
        // $admin->email = $request->email;
        // $admin->password = Hash::make($request->password);
        $admin->save();

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }
        $role = $admin->roles->first();
        $roleName = $role->name ?? '';
        $setting = new Settings();
        $setting->user_id = $admin->id;
        $setting->user_type = $roleName;
        $setting->save();

        session()->flash('success', 'Admin has been created !!');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        $admin = Admin::find($id);
        $roles  = Role::all();
        return view('backend.pages.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin. Please create new one if you need to test !');
            return back();
        }

        // Create New Admin
        $admin = Admin::find($id);

        // Validation Data
        $request->validate([
           // 'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:admins,email,' . $id,
            //'username' => 'required|max:100|username|unique:admins,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->name = $request->get('first_name','').' '.$request->get('last_name','');
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->current_state = !empty($request->current_state)?implode(',',$request->current_state):'';
        $admin->current_district = !empty($request->current_district)?implode(',',$request->current_district):'';
        $admin->municipality_panchayat_current = !empty($request->municipality_panchayat_current)?implode(',',$request->municipality_panchayat_current):'';

        $admin->save();

        $admin->roles()->detach();
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', 'Admin has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to delete this Admin as this is the Super Admin. Please create new one if you need to test !');
            return back();
        }

        $admin = Admin::find($id);
        if (!is_null($admin)) {
            $admin->delete();
        }

        session()->flash('success', 'Admin has been deleted !!');
        return back();
    }

    public function ChangePassword(Request $request)
    {
        // Validation Data
        $request->validate([
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);

        $current_user = $this->user;//Auth::user();
        //print_r($current_user);die;
        if (Hash::check($request->current_password, $current_user->password)) {
            $current_user->update([
                'password'=>bcrypt($request->new_password)
            ]);
            return back()->with('success', 'Password successfully updated.');
        }
        else{
            return back()->with('error', 'Current password does not matched.');
        }

    }

    public function ChangePasswordPage()
    {
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $admins = Admin::all();
        return view('backend.pages.changepassword.index', compact('admins'));
    }
}
