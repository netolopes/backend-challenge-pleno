<?php

namespace App\Repositories\Contracts;



interface ICategoriaRepository
{

    public function list();
    public function add(string $nome, string $descricao);
    public function listBy(int $id);
    public function edit(int $id,string $nome, string $descricao);
    public function delete(int $id);

}
