<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GreetingController extends Controller {

    /**
     * @return Response
     */
    public function index()
    {
        return view('hello.greeting', ['name' => 'Janus Nic']);
    }

}
