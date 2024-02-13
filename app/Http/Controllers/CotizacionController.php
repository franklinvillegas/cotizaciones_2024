<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\PublicacionCotizacion;
use Illuminate\Support\Facades\DB;


class CotizacionController extends Controller
{
    // listar cotizaciones

      public function listar(){
        $lista = Cotizacion::select()->with(['pedidoSiga:id,nro_cmn,descripcion','publicacionCotizacion']);
        return $lista->get();
    }
      public function publicar(Request $request){
        try {
          $nuevoCotizacion = new Cotizacion();
          $nuevoCotizacion->estado = $request->detalles["estado"];
          $nuevoCotizacion->nro_cotizacion = $request->detalles["numCotizacion"];
          $nuevoCotizacion->ano_eje = $request->detalles["ano_eje"];
          $nuevoCotizacion->id_pedido = $request->detalles["id"];
          $nuevoCotizacion->save();
          if ($nuevoCotizacion->id) {
            try {
            $nuevoPublicacionCotizacion = new PublicacionCotizacion;
            $fechaPublicacion = date_create($request->detalles["fechaPublicacion"]);
            $nuevoPublicacionCotizacion->fecha_publicacion=date_format($fechaPublicacion,"Y-m-d H:i:s");
            $fechaFinalizacion = date_create($request->detalles["fechaFinalizacion"]);
            $nuevoPublicacionCotizacion->fecha_fin=date_format($fechaFinalizacion,'Y-m-d H:i:s');
            $nuevoPublicacionCotizacion->id_cotizacion=$nuevoCotizacion->id;
            $nuevoPublicacionCotizacion->save();
            }
            catch (\Exception $e) {
              // Manejar el error de guardado
              return response()->json(['error' => 'Error al guardar la PUBLICACION: ' . $e->getMessage()], 500);
              }
          } 
          return response()->json(['message' => 'Se publicó correctamente', 'identificador' => $nuevoCotizacion->id]);

        } catch (\Exception $e) {
            // Manejar el error de guardado
            return response()->json(['error' => 'Error al guardar la cotización: ' . $e->getMessage()], 500);
        }
}
}
