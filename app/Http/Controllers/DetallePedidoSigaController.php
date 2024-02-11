<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePedidoSiga;


class DetallePedidoSigaController extends Controller
{
    //
    public function listarDetalle($id){
        $lista = DetallePedidoSiga::select()->where('id_pedido',$id)->get();
        return $lista;
    }
}