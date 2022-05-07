<?php
namespace App\Repositories\Produto;

use App\Models\Produto;
use App\Repositories\Contracts\IProdutoRepository;
use Illuminate\Support\Facades\DB;

class ProdutoRepository implements IProdutoRepository {

    protected $produto;

    public function __construct
    (
       Produto $produto
    ) {
       $this->produto = $produto;
    }

    public function list()
    {
     //   return $this->produto::paginate(10);
        $data =  $this->produto::query()
        ->join('categorias as c','c.id','=','produtos.categoria_id')
        ->select(['produtos.id','produtos.nome','produtos.descricao','tipo','cor','tamanho','valor','categoria_id','c.nome as nome_categoria'])
        ->orderBy('produtos.id', 'desc')
        ->paginate(10);
    return $data;
    }

    public function add(string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id)
    {
        $result = $this->produto::create([
            'nome' => $nome,
            'descricao' => $descricao,
            'tipo' => $tipo,
            'cor' => $cor,
            'tamanho' => $tamanho,
            'valor' => $valor,
            'categoria_id' => $categoria_id
        ]);

       return $result;
    }

    public function listBy(int $id)
    {
            $data =  $this->produto::query()
                ->join('categorias as c','c.id','=','produtos.categoria_id')
                ->select(['produtos.id','produtos.nome','produtos.descricao','tipo','cor','tamanho','valor','categoria_id','c.nome as nome_categoria'])
                ->findOrFail($id);
            return $data;
    }

    public function edit(int $id,string $nome, string $descricao, string $tipo, string $cor, string $tamanho, float $valor, int $categoria_id)
    {
        $obj =  $this->produto::findOrFail($id);
        $obj->nome = $nome;
        $obj->descricao = $descricao;
        $obj->tipo  = $tipo;
        $obj->cor = $cor;
        $obj->tamanho = $tamanho;
        $obj->valor = $valor;
        $obj->categoria_id = $categoria_id;

        if( $obj->save() ){
            return  $obj;
        }
    }

    public function delete(int $id){

        $obj =  $this->produto::findOrFail($id);

          if( $obj->delete() ){
           return  $obj;
         }
   }


}

