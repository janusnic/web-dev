<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\User;

//use Title;

class UsersController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
   }

   public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());

        flash()->success('User has been created!');

        return redirect('admin/users');
    }


   public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());
        flash()->success('User has been updateed!');

        return redirect('admin/users');
    }


}
