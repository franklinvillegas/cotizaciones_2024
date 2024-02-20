<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotizacionPropuesta;
use App\Models\PublicacionCotizacion;
use App\Models\DetallePropuesta;
use Illuminate\Support\Facades\DB;


class CotizacionPropuestaController extends Controller
{
   
    public function crear(Request $request){
         try {
          $nuevo = new CotizacionPropuesta($request->all());
          $nuevo->fecha_propuestas = now();
          // Documentos
          $cotizacion_archivo=$request->cotizacion_archivo;
          if($cotizacion_archivo != 'undefined' || !$cotizacion_archivo ){  
              $extension = $request->file('cotizacion_archivo')->getClientOriginalExtension();
              $filename = uniqid();
              $file = $request->file('cotizacion_archivo')->move('DocumentosPropuesta', $filename.".".$extension);
              $path = $filename.".".$extension;
              $nuevo->cotizacion_archivo = $path;
          }
          $cotizacion_ficharuc=$request->cotizacion_ficharuc;
          if($cotizacion_ficharuc != 'undefined' || !$cotizacion_ficharuc ){  
              $extension = $request->file('cotizacion_ficharuc')->getClientOriginalExtension();
              $filename = uniqid();
              $file = $request->file('cotizacion_ficharuc')->move('DocumentosPropuesta', $filename.".".$extension);
              $path = $filename.".".$extension;
              $nuevo->cotizacion_ficharuc = $path;
          }
          $cotizacion_rnp=$request->cotizacion_rnp;
          if($cotizacion_rnp != 'undefined' || !$cotizacion_rnp ){  
              $extension = $request->file('cotizacion_rnp')->getClientOriginalExtension();
              $filename = uniqid();
              $file = $request->file('cotizacion_rnp')->move('DocumentosPropuesta', $filename.".".$extension);
              $path = $filename.".".$extension;
              $nuevo->cotizacion_rnp = $path;
          }
          $cotizacion_cci=$request->cotizacion_cci;
          if($cotizacion_cci != 'undefined' || !$cotizacion_cci ){  
              $extension = $request->file('cotizacion_cci')->getClientOriginalExtension();
              $filename = uniqid();
              $file = $request->file('cotizacion_cci')->move('DocumentosPropuesta', $filename.".".$extension);
              $path = $filename.".".$extension;
              $nuevo->cotizacion_cci = $path;
          }
          $cotizacion_anexo=$request->cotizacion_anexo;
          if($cotizacion_anexo != 'undefined' || !$cotizacion_anexo ){  
              $extension = $request->file('cotizacion_anexo')->getClientOriginalExtension();
              $filename = uniqid();
              $file = $request->file('cotizacion_anexo')->move('DocumentosPropuesta', $filename.".".$extension);
              $path = $filename.".".$extension;
              $nuevo->cotizacion_anexo = $path;
          }
          $nuevo->save();
          $detalle_propuesta = json_decode($request->input('detalle_propuesta'));
          foreach ($detalle_propuesta as $detalle) {
            $nuevoDetalle = new DetallePropuesta();
            $nuevoDetalle->descripcion = $detalle->id;
            $nuevoDetalle->cantidad = $detalle->cantidad;
            $nuevoDetalle->precio_unitario = $detalle->precio_unitario_propuesta;
            $nuevoDetalle->precio_total = $detalle->cantidad * $detalle->precio_unitario_propuesta;
            $nuevoDetalle->id_propuesta = $nuevo->id;
            $nuevoDetalle->save();
          }

          return response()->json(['message' => 'La propuesta se creó correctamente', 'identificador' => $nuevo->id]);

        } catch (\Exception $e) {
            // Manejar el error de guardado
            return response()->json(['error' => 'Error al guardar la propuesta: ' . $e->getMessage()], 500);
        }
   }

   public function listarPropuestaUser($id){
    try {
      $user = auth()->user();
      if($user->tipo_usuario != 2) {
        return response()->json(['error' => 'El usuario no es de tipo proveedor'], 500);
      } else {
        $lista = PublicacionCotizacion::select()->with(['cotizacion.pedidoSiga.detallePedidoSiga','cotizacionPropuesta.detallePropuesta','cotizacionPropuesta.proveedor'])->where('id',$id);
        return $lista->get();
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error en la propuesta: ' . $e->getMessage()], 500);
   }
  }
}
