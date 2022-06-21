<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostagemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'local' => $this->local,
            'imagem' => $this->imagem,
            'descricao' => $this->descricao,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'user' => $this->user
        ];
    }
}
