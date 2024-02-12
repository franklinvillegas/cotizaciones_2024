<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoSiga;
use App\Models\DetallePedidoSiga;


class PedidoSigaController extends Controller
{
    //listar los pedidos de Siga
      public function listar(){
        $lista = PedidoSiga::select();
        return $lista->get();
    }
    public function listarImprimir($id){
        $lista = PedidoSiga::select()->with(['detallePedidoSiga'])->where('id',$id);
        return $lista->get();
    }

    public function crear(Request $request){
        try {
            
            $nuevo = new PedidoSiga($request->data);       
            $nuevo->save();
            if($request->detalle){
                foreach ($request->detalle as $row) {
                    $nuevoDetalle = new DetallePedidoSiga($row);
                    $nuevoDetalle->id_pedido = $nuevo->id;
                    $nuevoDetalle->save();
                } 
            }
            return response()->json(['message' => 'La importación se generó correctamente', 'identificador' => $nuevo->id]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al realizar la importación: ' . $e->getMessage()], 500);
        }
    }
}
