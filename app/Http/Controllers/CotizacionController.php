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

  //   public function listar(){
  //     $lista = DB::connection('sqlsrv2')->select('select spc.NRO_CONSOLID as nro_cmn,spc.ESPEC_TECNICAS as descripcion, 
  //     spc.NRO_PAAC as consolidado, spc.SEC_EJEC as codigo_ejecutora,spc.FECHA_CONS as fecha_pedido,
  //     spc.ANO_EJE as ano_eje, spc.ESTADO as estado, spi.CANTIDAD as cantidad, um.ABREVIATURA as unidad_medida,
  //     bs.NOMBRE_ITEM as descripcionitem, spi.PRECIO_UNIT,spi.PRECIO_UNIT*spi.CANTIDAD as total
  //     from ((SIG_PAAC_CONSOLIDADO spc inner join SIG_PAAC_ITEM spi on spc.NRO_CONSOLID=spi.NRO_CONSOLID)
  //     inner join CATALOGO_BIEN_SERV bs on spi.grupo_bien+spi.clase_bien+spi.FAMILIA_BIEN+spi.ITEM_BIEN=
  //     bs.grupo_bien+bs.clase_bien+bs.FAMILIA_BIEN+bs.ITEM_BIEN AND spi.TIPO_BIEN=bs.TIPO_BIEN ) inner join UNIDAD_MEDIDA um
  //     on bs.UNIDAD_MEDIDA=um.UNIDAD_MEDIDA
      
  //     where spc.ANO_EJE=2024 and spi.ANO_EJE=2024 and spc.TIPO_CONSOLID!=1  order by nro_cmn');
  //     return $lista;
  // }
}
