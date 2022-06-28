<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostagemResource;
use App\Models\Postagens;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostagensController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    public function index()
    {
        $postagens = Postagens::all();
        return $this->sendResponse(PostagemResource::collection($postagens),'Posts Retrieved Successfully.');
    }
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'title' => 'required',
            'place' => 'required',
            'image' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $postagens = Postagens::create($input);
   
        return $this->sendResponse(new PostagemResource($postagens), 'Post Created Successfully.');
    }
    public function show($id)
    {
        $postagens = Postagens::find($id);
  
        if (is_null($postagens)) {
            return $this->sendError('Post not found.');
        }
   
        return $this->sendResponse(new PostagemResource($postagens), 'Post Retrieved Successfully.');
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'user_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $postagens = Postagens::find($id);   
        $postagens->title = $input['title'];
        $postagens->place = $input['place'];
        $postagens->image = $input['image'];
        $postagens->description = $input['description'];
        $postagens->save();
   
        return $this->sendResponse(new PostagemResource($postagens), 'Post Updated Successfully.');
    }
    public function delete($id)
    {
        if(Postagens::where('id', $id)->exists()){
            $postagem = Postagens::find($id);
            $postagem->delete();
            
            return $this->sendResponse([], 'Post deleted successfully!');
        }else{
            return $this->sendError('Post not found.');
        }
    }
}