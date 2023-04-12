<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user.inde|user.create|user.edit|user.show|user.destroy', ['only' => ['index']]);
        $this->middleware('permission:user.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user.show', ['only' => ['show']]);
        $this->middleware('permission:user.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();

        if (auth()->user()->role_id == 1) {
            $data = $user->get();
        } else {
            $data = $user->where('id', auth()->user()->id)->get();
        }

        return view('users.index', compact('data'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $ans = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $request['role_id'],
            'status' => 2
        ]);

        if($ans){
        session(['success' => 'User was created successfully!']);
        }else{
        session(['error' => 'User can not create!']);
        }
        return redirect('/users');
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
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
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
        $data = $request->all();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required'],
        ]);

        
        $ans = User::find($id)->update($data);

        if($ans){
            session(['success' => 'User was updated successfully!']);
        }else{
            session(['error' => 'User can not update!']);
        }

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ressult = User::find($id)->delete();
        if($ressult)
            return back()->with('success','User was deleted successfully!');
        else return back()->with('error','Can not delete, try again!');
    }
}
