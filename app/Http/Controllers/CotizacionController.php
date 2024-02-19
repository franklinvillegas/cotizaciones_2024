<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\PublicacionCotizacion;
use App\Models\DocumentoCotizacion;
use App\Models\CotizacionPropuesta;
use App\Models\DetallePropuesta;
use Illuminate\Support\Facades\DB;


class CotizacionController extends Controller
{
    // listar cotizaciones

      public function listar(){
        $lista = Cotizacion::select()->with(['pedidoSiga:id,nro_cmn,descripcion,tipo,fecha_pedido,consolidado','publicacionCotizacion','publicacionCotizacion.documentoCotizacion']);
        return $lista->get();
    }
    public function listarOfertas($id){
      $lista = PublicacionCotizacion::select()->with(['cotizacionPropuesta.proveedor'])->where('id',$id);

      return $lista->get();
    }
    public function listarOfertasComparar($id){
      
      try{
      $lista = PublicacionCotizacion::select()->with(['cotizacion.pedidoSiga.detallePedidoSiga.detallePropuesta','cotizacionPropuesta.detallePropuesta','cotizacionPropuesta.proveedor'])->where('id',$id);

      return $lista->get();
    }
    catch (\Exception $e) {
        return response()->json(['error' => 'Error al realizar la importación: ' . $e->getMessage()], 500);
    }
    }
    
      public function publicar(Request $request){
         try {
          $nuevoCotizacion = new Cotizacion();
          $nuevoCotizacion->estado = $request->estado;
          $nuevoCotizacion->nro_cotizacion = $request->numCotizacion;
          $nuevoCotizacion->ano_eje = $request->ano_eje;
          $nuevoCotizacion->id_pedido = $request->id;
          $nuevoCotizacion->save();
          if ($nuevoCotizacion->id) {
            try {
            $nuevoPublicacionCotizacion = new PublicacionCotizacion;
            $fechaPublicacion = date_create($request->fechaPublicacion);
            $nuevoPublicacionCotizacion->fecha_publicacion=date_format($fechaPublicacion,"Y-m-d H:i:s");
            $fechaFinalizacion = date_create($request->fechaFinalizacion);
            $nuevoPublicacionCotizacion->fecha_fin=date_format($fechaFinalizacion,'Y-m-d H:i:s');
            $nuevoPublicacionCotizacion->id_cotizacion=$nuevoCotizacion->id;
            $nuevoPublicacionCotizacion->save();

            $documento_url=$request->documento;
              if($documento_url != 'undefined' || !$documento_url ){  
                  $extension = $request->file('documento')->getClientOriginalExtension();
                  $filename = uniqid();
                  $file = $request->file('documento')->move('Documentos', $filename.".".$extension);
                  $path = $filename.".".$extension;
              }
              try {
              $nuevoDocumento = new DocumentoCotizacion();
              $nuevoDocumento->descripcion = "Documento";
              $nuevoDocumento->url_documento = $path;
              $nuevoDocumento->id_publicacion = $nuevoPublicacionCotizacion->id;
              $nuevoDocumento->save();
              $eett_url=$request->eett;
              if($eett_url != 'undefined' || !$eett_url ){  
                  $extension = $request->file('eett')->getClientOriginalExtension();
                  $filename = uniqid();
                  $file = $request->file('eett')->move('Documentos', $filename.".".$extension);
                  $path = $filename.".".$extension;
              }
              try {
              $nuevoEett = new DocumentoCotizacion();
              $nuevoEett->descripcion = "Documento";
              $nuevoEett->url_documento= $path;
              $nuevoEett->id_publicacion = $nuevoPublicacionCotizacion->id;
              $nuevoEett->save();
              return response()->json(['message' => 'Se Publicó Correctamente', 'identificador' => $nuevoEett->id]);
              }
              catch (\Exception $e) {
                // Manejar el error de guardado
                return response()->json(['error' => 'Error al guardar el Documento: ' . $e->getMessage()], 500);
                }
              }
              catch (\Exception $e) {
                // Manejar el error de guardado
                return response()->json(['error' => 'Error al guardar el Documento: ' . $e->getMessage()], 500);
                }
               
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
