<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Http\Requests\CategoriaRequest;
use App\Services\Contracts\ICategoriaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    protected $categoriaService;

    public function __construct
    (
        ICategoriaService $categoriaService
    )
    {
        $this->categoriaService = $categoriaService;
    }


    public function index()
    {
        if(request()->ajax()) {
            return Datatables()->of(Categoria::select('*'))
            ->addColumn('action', 'categoria.categoria-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

         try{

             $data = $this->categoriaService->list();
             return CategoriaResource::collection($data);

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


    public function store(CategoriaRequest $request)
    {

        try{
            DB::beginTransaction();

            $data = (object)$request->only([
                'nome',
                'descricao'
            ]);

            $data = $this->categoriaService->add($data->nome,$data->descricao);

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

            $data = $this->categoriaService->listBy($id);
            return new CategoriaResource($data);

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


    public function update(CategoriaRequest $request)
    {

        try{

            $data = (object)$request->only([
                'id',
                'nome',
                'descricao'
            ]);

            $data = $this->categoriaService->edit($data->id,$data->nome,$data->descricao);
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

            $data = $this->categoriaService->delete($data->id);
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
