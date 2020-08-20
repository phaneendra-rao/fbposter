<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', 1)->get();
        return UserResource::collection($users);
    }
}
