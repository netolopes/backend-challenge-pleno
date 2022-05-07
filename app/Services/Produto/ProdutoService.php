<?php
namespace App\Services\Produto;

use App\Repositories\Contracts\IProdutoRepository;
use App\Services\Contracts\IProdutoService;
use Illuminate\Support\Facades\Hash;

class ProdutoService implements IProdutoService
{

    protected $produtoRepository;

    public function __construct
    (
        IProdutoRepository $produtoRepository
    ) {
       $this->produtoRepository = $produtoRepository;
    }

    public function list()
    {
        $data = $this->produtoRepository->list();
        return $data;
    }


    public function add(string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id)
    {

        $data = $this->produtoRepository->add($nome, $descricao, $tipo, $cor, $tamanho, $valor, $categoria_id);
        return $data;
    }


    public function listBy(int $id)
    {
        $data = $this->produtoRepository->listBy($id);
        return $data;
    }

    public function edit(int $id, string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id)
    {

        $data = $this->produtoRepository->edit($id,$nome, $descricao, $tipo, $cor, $tamanho, $valor, $categoria_id);
        return $data;
    }

    public function delete(int $id)
    {
        $data = $this->produtoRepository->delete($id);
        return $data;
    }

}
