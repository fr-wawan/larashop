<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-users')) return $next($request);

            abort(403, 'Anda tidak memiliki akses');
        });
    }
   
    public function index(Request $request)
    {
        $users = User::paginate(10);

        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');

        if($filterKeyword){
            if($status){
                $users = User::where('name','LIKE',"%$filterKeyword%")->where('status', $status)->paginate(10);
            }
        }else{
            $users = User::where('name','LIKE',"%$filterKeyword%")->paginate(10);

        }

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $validateData = $request->validate([
            'name' => 'required |min:5|max:100',
            'username' => 'required | unique:users',
            'email' => 'required|email:dns|unique:users',
            'address' => 'required',
            'phone' => 'required|digits_between:10,12',
            'avatar' => 'image|file|max:1024',
            'password' => 'required|confirmed'
        ]);

        if($request->file('avatar')){
            $validateData['avatar'] = $request->file('avatar')->store('users_images','public');
        }

        $validateData['roles'] = json_encode($request->get('roles'));
        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);


        return redirect()->route('users.create')->with('status', 'User  successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        Validator::make($request->all(),[
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => 'required|digits_between:10,12',
            "address" => 'required|min:20|max:200'

        ])->validate();

        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->roles = json_encode($request->get('roles'));
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->status = $request->get('status');
        
        if($request->file('avatar')){
            if($user->avatar  && file_exists(storage_path('app/public' . $user->avatar))){
                Storage::delete('public/' . $user->avatar);
            }

            $file = $request->file('avatar')->store('users_images','public');

            $user->avatar = $file;
        }

        $user->save();

        return redirect()->route('users.edit',[$id])->with('status', 'User  successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->avatar){
            Storage::delete('public/' . $user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User  successfully deleted');
    }
}
