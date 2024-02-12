<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PedidoSiga;


class RequerimientoSigaController extends Controller
{
    // listar requerimientos SIGA

    public function listar(){
      $lista = DB::connection('sqlsrv2')->select("select spc.NRO_CONSOLID as nro_cmn,spc.ESPEC_TECNICAS as descripcion,spc.FECHA_CONS as fecha_pedido, spc.TIPO_BIEN as tipo,
      spc.ANO_EJE as ano_eje, spc.ESTADO as estado, spc.NRO_PAAC as consolidado,  spc.SEC_EJEC as codigo_ejecutora,
      CASE 
        WHEN spc.ESTADO =1 THEN 'Pendiente'
        WHEN spc.ESTADO = 2 THEN 'Proc. Selección'
      WHEN spc.ESTADO =3 THEN 'Orden Generada'
        WHEN spc.ESTADO = 4 THEN 'Ajuste x Centro Costo'
      WHEN spc.ESTADO =5 THEN 'Ajuste x CCMN'
        WHEN spc.ESTADO = 6 THEN 'Autorizado'
      WHEN spc.ESTADO = 7 THEN 'Anulado'
        ELSE 'NO IDENTIFICADO'
      END AS estadoDesc
      from SIG_PAAC_CONSOLIDADO spc 
      where spc.ANO_EJE=2024 and spc.TIPO_CONSOLID!=1  order by nro_cmn desc");
      return $lista;
  }

    public function listarDetalle($ano_eje, $nro_cmn){
      $lista = DB::connection('sqlsrv2')->select('select spc.NRO_CONSOLID as nro_cmn, 
      spc.NRO_PAAC as consolidado, spc.SEC_EJEC as codigo_ejecutora,spc.FECHA_CONS as fecha_pedido,
      spc.ANO_EJE as ano_eje, spc.ESTADO as estado, spi.CANTIDAD as cantidad, um.ABREVIATURA as unidad_medida,
      bs.NOMBRE_ITEM as descripcion,bs.NOMBRE_ITEM as especificaciones, spi.PRECIO_UNIT as precio_unitario,spi.PRECIO_UNIT*spi.CANTIDAD as precio_total
      from ((SIG_PAAC_CONSOLIDADO spc inner join SIG_PAAC_ITEM spi on spc.NRO_CONSOLID=spi.NRO_CONSOLID)
      inner join CATALOGO_BIEN_SERV bs on spi.grupo_bien+spi.clase_bien+spi.FAMILIA_BIEN+spi.ITEM_BIEN=
      bs.grupo_bien+bs.clase_bien+bs.FAMILIA_BIEN+bs.ITEM_BIEN AND spi.TIPO_BIEN=bs.TIPO_BIEN ) inner join UNIDAD_MEDIDA um
      on bs.UNIDAD_MEDIDA=um.UNIDAD_MEDIDA
      
      where spc.ANO_EJE='.$ano_eje.' and spi.ANO_EJE='.$ano_eje.' and spi.NRO_CONSOLID='.$nro_cmn.' and spc.TIPO_CONSOLID!=1  order by nro_cmn');
      return $lista;
    }
}
