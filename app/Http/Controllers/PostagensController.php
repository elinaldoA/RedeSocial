<?php

namespace App\Http\Controllers;

use App\Models\Postagens;
use Illuminate\Http\Request;
use App\Http\Resources\Postagens as PostagensResource;

class PostagensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postagens = Postagens::paginate(15);
        return PostagensResource::collection($postagens);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postagens = Postagens::create($request->all());
        return response()->json($postagens, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postagens = Postagens::findOrFail($id);
        return Postagens::find($postagens);
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
        $postagens = Postagens::findOrFail($id);
        $postagens->update($request->all());

        return $postagens;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postagem = Postagens::findOrFail($id);
        $postagem->delete();

        return 204;
    }
}
