<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Closure;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->userRepo = $userRepo;

    }
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
    public function store(Request $request)
    {
        //
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


    public function getUserForType($type)
    {
        $auditors = $this->userRepo->listUserCondition($type);

        return $auditors;
    }

    public function getUserAuthenticated()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        if (Auth::user()->id) {
            $user = Auth::user();
            return $user;
        }
    }
}
