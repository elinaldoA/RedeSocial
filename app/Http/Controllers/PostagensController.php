<?php

namespace App\Http\Controllers;

use App\Models\Postagens;
use Illuminate\Http\Request;
use App\Http\Resources\Postagens as PostagensResource;

class PostagensController extends Controller
{
    public function getAllPostagens()
    {
        $postagens = Postagens::get()->toJson(JSON_PRETTY_PRINT);
        return response($postagens, 200);
    }

    public function createPostagens(Request $request)
    {
        $postagem = new Postagens;
        $postagem->titulo = $request->titulo;
        $postagem->local = $request->local;
        $postagem->imagem = $request->imagem;
        $postagem->descricao = $request->descricao;
        $postagem->save();

        return response()->json([
            "message" => "Postagem criada com sucesso!"
        ], 201);
    }

    public function getPostagens($id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($postagem, 200);
        }else{
            return response([
                "message" => "Postagem não encontrada!"
            ], 404);
        }
    }

    public function updatePostagens(Request $request, $id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::find($id);
            $postagem->titulo = is_null($request->titulo) ? $postagem->titulo : $request->titulo;
            $postagem->local = is_null($request->local) ? $postagem->local : $request->local;
            $postagem->imagem = is_null($request->imagem) ? $postagem->imagem : $request->imagem;
            $postagem->descricao = is_null($request->descricao) ? $postagem->descricao : $request->descricao;
            $postagem->save();

            return response()->json([
                "message" => "Postagem atualizada com sucesso!"
            ], 200);
        }else{
            return response()->json([
                "message" => "Postagem não encontrada!"
            ], 404);
        }
    }

    public function deletePostagens($id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::find($id);
            $postagem->delete();

            return response()->json([
                "message" => "Postagem excluída com sucesso!"
            ], 202);
        }else{
            return response([
                "message" => "Postagem não encontrada"
            ], 404);
        }
    }
}
