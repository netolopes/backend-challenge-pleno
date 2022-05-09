<?php
namespace App\Services\Categoria;

use App\Repositories\Contracts\ICategoriaRepository;
use App\Services\Contracts\ICategoriaService;
use Illuminate\Support\Facades\Hash;

class CategoriaService implements ICategoriaService
{

    protected $categoriaRepository;

    public function __construct
    (
        ICategoriaRepository $categoriaRepository
    ) {
       $this->categoriaRepository = $categoriaRepository;
    }

    public function list()
    {
        $data = $this->categoriaRepository->list();
        return $data;
    }


    public function add(string $nome, string $descricao)
    {

        $data = $this->categoriaRepository->add($nome, $descricao);
        return $data;
    }


    public function listBy(int $id)
    {
        $data = $this->categoriaRepository->listBy($id);
        return $data;
    }

    public function edit(int $id, string $nome, string $descricao)
    {

        $data = $this->categoriaRepository->edit($id,$nome, $descricao);
        return $data;
    }

    public function delete(int $id)
    {
        $data = $this->categoriaRepository->delete($id);
        return $data;
    }

}
