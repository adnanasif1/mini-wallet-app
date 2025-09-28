<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::select('id', 'name', 'email', 'balance')->get();

        return response()->json($users);
    }
}
