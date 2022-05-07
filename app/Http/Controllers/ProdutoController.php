<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Http\Requests\ProdutoRequest;
use App\Services\Contracts\IProdutoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    protected $produtoService;

    public function __construct
    (
        IProdutoService $produtoService
    )
    {
        $this->produtoService = $produtoService;
    }


    public function index()
    {

        if(request()->ajax()) {

            $data =  Produto::query()
            ->join('categorias as c','c.id','=','produtos.categoria_id')
            ->select(['produtos.id','produtos.nome','produtos.descricao','tipo','cor','tamanho','valor','categoria_id','c.nome as nome_categoria'])
            ->orderBy('produtos.id', 'desc')
            ->get();

            return Datatables()->of($data)
            ->addColumn('action', 'produto.produto-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

         try{

            //  $data = $this->produtoService->list();
            //  return ProdutoResource::collection($data);

         } catch (\Exception $e) {
             return response()->json(
                 [
                     'success' => false,
                     'error' => $e->getMessage()
                 ],
                 403
             );
         }
    }


    public function store(ProdutoRequest $request)
    {

        try{
            DB::beginTransaction();

            $data = (object)$request->only([
                'nome',
                'descricao',
                'tipo',
                'cor',
                'tamanho',
                'valor',
                'categoria_id'
            ]);

            $data = $this->produtoService->add($data->nome,$data->descricao,$data->tipo, $data->cor, $data->tamanho, $data->valor, $data->categoria_id);

            DB::commit();

            return $data;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json(
                [
                    'success' => false,
                    'error' => $e->getMessage()
                ],
                403
            );
        }

    }


    public function show($id)
    {
        try{

            $data = $this->produtoService->listBy($id);
            return new ProdutoResource($data);

        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $e->getMessage()
                ],
                403
            );
        }
    }


    public function update(ProdutoRequest $request)
    {

        try{

            $data = (object)$request->only([
                'id',
                'nome',
                'descricao',
                'tipo',
                'cor',
                'tamanho',
                'valor',
                'categoria_id'
            ]);

            $data = $this->produtoService->edit($data->id,$data->nome,$data->descricao,$data->tipo, $data->cor, $data->tamanho, $data->valor, $data->categoria_id);
            return $data;

        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $e->getMessage()
                ],
                403
            );
        }

    }

    public function destroy(Request $request)
    {
        try{

            $data = (object)$request->only([
                'id'
            ]);

            $data = $this->produtoService->delete($data->id);
            return $data;

        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $e->getMessage()
                ],
                403
            );
        }
    }

}
