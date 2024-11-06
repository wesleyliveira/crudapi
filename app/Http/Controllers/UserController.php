<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users= User::orderBy("id","desc")->paginate(2); 
        // RETORNA USUÁRIOS EM JSON  
        return response()->json([
        'status' => true,
        'users'=> $users,
        ],200);
    }

    public function show(User $user)    : JsonResponse
    {
        //RETORNA OS DETALHES EM JSON
        return response()->json([
            'status' => true,
            'user'=> $user,
            ],200);
    }


}
