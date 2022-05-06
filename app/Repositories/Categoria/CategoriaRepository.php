<?php
namespace App\Repositories\Categoria;

use App\Models\Categoria;
use App\Repositories\Contracts\ICategoriaRepository;
use Illuminate\Support\Facades\DB;

class CategoriaRepository implements ICategoriaRepository {

    protected $categoria;

    public function __construct
    (
       Categoria $categoria
    ) {
       $this->categoria = $categoria;
    }

    public function list()
    {
        return $this->categoria::paginate(10);
    }

    public function add(string $nome, string $descricao)
    {
        $result = $this->categoria::create([
            'nome' => $nome,
            'descricao' => $descricao
        ]);

        $data = [
            'nome' => $nome,
            'descricao' => $descricao
        ];


       return $result;
    }

    public function listBy(int $id)
    {
        $data =  $this->categoria::select(['id','nome','descricao'])->findOrFail($id);
        return $data;
    }

    public function edit(int $id,string $nome, string $descricao)
    {
        $obj =  $this->categoria::findOrFail($id);
        $obj->nome = $nome;
        $obj->descricao = $descricao;

        if( $obj->save() ){
            return  $obj;
        }
    }

    public function delete(int $id){

        $obj =  $this->categoria::findOrFail($id);

          if( $obj->delete() ){
           return  $obj;
         }
   }


}

