<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostagemResource;
use App\Models\Postagens;
use Illuminate\Http\Request;

class PostagensController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    public function index()
    {
        return PostagemResource::collection(Postagens::all());
    }
    public function store(Request $request)
    {
        $postagens = Postagens::create(
        [
            'user_id' => auth()->user()->id,
            'titulo' => $request->titulo,
            'local' => $request->local,
            'imagem' => $request->imagem,
            'descricao' => $request->descricao
        ]);

        return new PostagemResource($postagens);
    }
    public function show($id)
    {
        return new PostagemResource(Postagens::FindOrFail($id));
    }

    public function update(Request $request, $id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::find($id);
            $postagem->titulo = is_null($request->titulo) ? $postagem->titulo : $request->titulo;
            $postagem->local = is_null($request->local) ? $postagem->local : $request->local;
            $postagem->imagem = is_null($request->imagem) ? $postagem->imagem : $request->imagem;
            $postagem->descricao = is_null($request->descricao) ? $postagem->descricao : $request->descricao;
            $postagem->save();

            return response()->json([
                'code'=> "200",
                'success'=>true,
                'message' => 'Postagem atualizada com sucesso'
            ], 200);
        }else{
            return response()->json([
                'code'=>404,
                "success"=> false,
                'message' => 'Postagem não encontrada!'
            ],404);
        }
    }
    public function delete($id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::find($id);
            $postagem->delete();

            return response()->json([
                "message" => "Postagem excluída com sucesso!"
            ], 202);
        }else{
            return abort(404, 'Not Found');
        }
    }
}