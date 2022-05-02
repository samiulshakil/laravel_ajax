<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Traits\Uploadable;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    use Uploadable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $result = User::Create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => 'default.png',
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'status' => 0,
        ]);

        if($request->hasFile('avatar')){
            $avatar = $this->upload_file($request->file('avatar'), 'user_image');
            $result->avatar = $avatar;
            $result->save();
        }

        if ($result) {
            $output = ['status' => 'success', 'message' => 'Data has been saved successfully'];
        } else {
            $output = ['status' => 'error', 'message' => 'Data cannot save'];
        }
        return response()->json($output);
    } 

    /**
     * Display the specified resource...
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
