<?php

namespace App\Repositories\Contracts;



interface IProdutoRepository
{

    public function list();
    public function add(string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id);
    public function listBy(int $id);
    public function edit(int $id,string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id);
    public function delete(int $id);

}
