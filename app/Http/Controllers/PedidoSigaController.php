<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoSiga;


class PedidoSigaController extends Controller
{
    //listar los pedidos de Siga
      public function listar(){
        $lista = PedidoSiga::select();
        return $lista->get();
    }
}