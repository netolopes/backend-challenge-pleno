<?php

namespace App\Services\Contracts;

interface ICategoriaService
{
    public function list();
    public function add(string $nome, string $descricao);
    public function listBy(int $id);
    public function edit(int $id, string $nome, string $descricao);
    public function delete(int $id);
 }
