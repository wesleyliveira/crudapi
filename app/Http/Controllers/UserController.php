<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'DESC')->paginate(2);

        // RETORNA USUÁRIOS EM JSON  
        return response()->json([
            'status' => true,
            'users' => $users,
        ], 200);
    }

    public function show(User $user): JsonResponse #METODO PARA MOSTRAR OS DADOS
    {
        //RETORNA OS DETALHES EM JSON
        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
    }

    public function store(UserRequest $request): JsonResponse #METODO PARA ADICIONAR OS DADOS:
    {

        DB::beginTransaction();  #METODO PARA INICIAR TRANSAÇÃO
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            DB::commit();

            #RETORNO DO SUCESSO:
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário cadastrado!",
            ], 201);
        } catch (Exception $e) {

            #DEU ERRO:             
            DB::rollBack();

            #RETORNO DO ERRO:
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado!",
            ], 400);
        }
    }


    public function update(UserRequest $request, User $user): JsonResponse
    { #METODO PARA ATUALIZAR OS DADOS:

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            
            DB::commit();

            #RETORNO DO SUCESSO:
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário Editado!",
            ], 200);
        } catch (Exception $e) {
            #DEU ERRO:             
            DB::rollBack();

            #RETORNO DO ERRO:
            return response()->json([
                'status' => false,
                'message' => "Usuário não editado!",
            ], 400);
        }
    }
    public function destroy(User $user): JsonResponse #APAGAR DADOS
    {
        try {
            $user->delete();
            return response()->json([
                'status'=> true,
                'user'=> $user,
                'message'=> 'Usuário apagado com sucesso',
            ], 200);

    }catch(Exception $e) {
        return response()->json([
            "status"=> false,
            "message"=> "Usuário excluído!",
            ] , 400);
        }
    }
}
