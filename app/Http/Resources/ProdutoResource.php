<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
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
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo,
            'cor' => $this->cor,
            'tamanho' => $this->tamanho,
            'valor' => $this->valor,
            'categoria_id' => $this->categoria_id,
            'nome_categoria' =>  $this->nome_categoria
        ];
    }
}
