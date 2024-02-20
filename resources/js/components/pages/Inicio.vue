<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -10px;">
        <h4 class="text-color-2 mb-3 ">SISTEMA DE COTIZACIONES</h4></div>
        <hr>
        <div class="row p-t">
            <div class="col-md-5">
                <label for="" class="form-label">Estado</label>
                <select class="form-control" v-model="listaCotizaciones.filtrosBusqueda.tipo" @change="listarCotizaciones">
                    <option value="Disponible">Disponible</option>
                    <option value="">-- Todos --</option>
                </select>
            </div>
        </div>
        <div class="table-responsive m-t">
            <vue-good-table
            :columns="listaCotizaciones.columns"
            :rows="listaCotizaciones.data"
            :search-options="{
                enabled: true,
                placeholder: 'Buscar en la tabla',
            }"
            :pagination-options="{
                enabled: true,
                mode: 'pages',
                nextLabel: 'Sig',
                prevLabel: 'Ant',
                rowsPerPageLabel: 'Registros por página',
                ofLabel: 'de',
                pageLabel: 'Página', // for 'pages' mode
                allLabel: 'Todo',
            }"
            >
            <template slot="table-row" slot-scope="props">
                <!-- <span v-if="props.column.field == 'publicacion_cotizacion.fecha_fin'">
                    {{ formatdate(props.row.publicacion_cotizacion.fecha_fin) }}
                </span> -->
                <span v-if="props.column.field == 'options'">
                    <button
                    class="btn btn-success btn-sm btn-icon"
                    @click.prevent="detalle(props.row, props.index)"
                    data-toggle="tooltip"
                    title="Agregar"
                    >
                    Detalle
                    </button>
                    <button
                    class="btn btn-danger btn-sm btn-icon"
                    @click.prevent="cotizar(props.row, props.index)"
                    data-toggle="tooltip"
                    title="Agregar"
                    >
                    Cotizar
                    </button>                
                </span>
            </template>
            </vue-good-table>
        </div>
  <!-- Modal Detalle -->
    <template id="detalle">
      <div
        class="modal fade"
        id="modal-detalle"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="modal-publicar">
              <div class="modal-header">
                <h5
                  align="center"
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modalDetalle.titulo"
                ></h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" data-vv-scope="form_registro_grado_curso">
                  <div class="row">
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Unidad Ejecutora: </strong>
                        GERENCIA SUB REGIONAL CHANKA
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Nro. de Identificacion: </strong>
                        000748
                      </p>
                    </div>
                  </div>
                  <div class="row" style="border: 2px solid black">
                    <div class="form-group col-2">
                      <p class="m-0">
                        <strong>Nro. Cons: </strong>
                        <label v-text="modalDetalle.detalles.consolidado"></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalDetalle.detalles.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento Pedido: </strong>
                        <label v-text="modalDetalle.detalles.nro_cmn"></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalDetalle.detalles.descripcion"
                        ></label>
                      </p>
                    </div>
                  </div>
                  <div class="table-responsive" style="max-height: 500px;">
                    <vue-good-table
                      :columns="listarPedidosDetalle.columns"
                      :rows="listarPedidosDetalle.data"
                      :sort-options="{
                        enabled: false,
                      }"
                    >
                    </vue-good-table>
                  </div>
                  <br />
                  <div class="row">
                    <div class="form-group col-12">
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Nro de Cotización: </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="nro_cotizacion"
                          v-model="modalDetalle.detalles.nro_cotizacion"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Fecha de Publicacion: </strong>
                        </label>
                        <input
                          type="datetime-local"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="fecha_publicacion"
                          v-model="modalDetalle.detalles.fecha_publicacion"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Fecha de Finalizacion: </strong>
                        </label>
                        <input
                          type="datetime-local"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          v-model="modalDetalle.detalles.fecha_fin"
                          name="fecha_fin"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Descripción: </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as="00000"
                          placeholder="00000"
                          v-model="modalDetalle.detalles.descripcion2"
                          name="descripcion2"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Documento: </strong>
                        </label>
                        <button type="button" class="btn btn-warning"  @click.prevent="verDocumento(modalDetalle.detalles.documento)">
                            Descargar
                        </button>
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>EE.TT.: </strong>
                        </label>
                        <button type="button" class="btn btn-warning" @click.prevent="verDocumento(modalDetalle.detalles.eett)">
                            Descargar
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-primary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  <!-- Modal Cotizar -->
    <template id="cotizar">
      <div
        class="modal fade"
        id="modal-cotizar"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="modal-publicar">
              <div class="modal-header">
                <h5
                  align="center"
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modalCotizar.titulo"
                ></h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" data-vv-scope="form_registro_grado_curso">
                  <div class="row">
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Unidad Ejecutora: </strong>
                        GERENCIA SUB REGIONAL CHANKA
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Nro. de Identificacion: </strong>
                        000748
                      </p>
                    </div>
                  </div>
                  <div class="row" style="border: 2px solid black">
                    <div class="form-group col-2">
                      <p class="m-0">
                        <strong>Nro. Cons: </strong>
                        <label v-text="modalCotizar.cotizar.consolidado"></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalCotizar.cotizar.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento Pedido: </strong>
                        <label v-text="modalCotizar.cotizar.nro_cmn"></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalCotizar.cotizar.descripcion"
                        ></label>
                      </p>
                    </div>
                  </div>
                  <br />
                  <div class="row">
                    <div class="form-group col-12" v-show="modalCotizar.vista == 1">
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Subir cotización: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-6"
                          name="cotizacion_archivo"
                          id="cotizacion_archivo"
                          accept="application/pdf" v-validate="'required|max:500'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Subir ficha RUC: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-6"
                          name="cotizacion_ficharuc"
                          id="cotizacion_ficharuc"
                          accept="application/pdf" v-validate="'required|max:500'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Subir RNP: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-6"
                          name="cotizacion_rnp"
                          id="cotizacion_rnp"
                          accept="application/pdf" v-validate="'required|max:500'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Subir Anexo 0X: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-6"
                          name="cotizacion_anexo"
                          id="cotizacion_anexo"
                          accept="application/pdf" v-validate="'required|max:500'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Subir CCI: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-6"
                          name="cotizacion_cci"
                          id="cotizacion_cci"
                          accept="application/pdf" v-validate="'required|max:500'"
                        />
                      </div>
                    </div>
                    <div class="form-group col-12" v-show="modalCotizar.vista == 2">
                      <div class="table-responsive">
                    <vue-good-table
                      :columns="listarPedidosCotizar.columns"
                      :rows="listarPedidosCotizar.data"
                      :sort-options="{ 
                        enabled: false,
                      }"
                      :pagination-options="{
                          enabled: true,
                          mode: 'pages',
                          nextLabel: 'Sig',
                          prevLabel: 'Ant',
                          rowsPerPageLabel: 'Registros por página',
                          ofLabel: 'de',
                          pageLabel: 'Página', // for 'pages' mode
                          allLabel: 'Todo',
                      }"
                    >
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'precio_unitario_propuesta'" @change="changePrecio(props.row[props.column.field], props.column.field, props.row.originalIndex)">
                            <input type="text" class="form-control" v-model="props.row.precio_unitario_propuesta">
                        </span>
                        <span v-else-if="props.column.field == 'precio_total'">
                            {{ props.row.cantidad * (props.row.precio_unitario_propuesta ? props.row.precio_unitario_propuesta : 0)  }}
                        </span>
                    </template>
                    </vue-good-table>
                  </div>
                  <br />
                      <div class="form-group d-flex col-12">
                        <label class="m-0 form-group col-9">
                          <strong>TOTAL: </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group col-3"
                          data-vv-as=""
                          placeholder=""
                          name="total"
                          v-model="modalCotizar.cotizar.total"
                          v-validate="'required'"
                        />
                      </div>
                      <div class="col-12 d-flex p-0">
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>Forma de pago: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="forma_pago"
                          v-model="modalCotizar.cotizar.forma_pago"
                          v-validate="'required'"
                          />
                        </div>
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>Garantía: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="garantia"
                          v-model="modalCotizar.cotizar.garantia"
                          v-validate="'required'"
                          />
                        </div>
                      </div>
                      <div class="col-12 d-flex p-0">
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>I.G.V: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="igv"
                          v-model="modalCotizar.cotizar.igv"
                          v-validate="'required'"
                          />
                        </div>
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>Plazo de entrega: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="plazo_entrega"
                          v-model="modalCotizar.cotizar.plazo_entrega"
                          v-validate="'required'"
                          />
                        </div>
                      </div>
                      <div class="col-12 d-flex p-0">
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>Tipo moneda: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="tipo_moneda"
                          v-model="modalCotizar.cotizar.tipo_moneda"
                          v-validate="'required'"
                          />
                        </div>
                        <div class="form-group col-6 d-flex">
                          <label class="m-0 form-group col-6">
                            <strong>Validez cotización: </strong>
                          </label>
                          <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as=""
                          placeholder=""
                          name="validez"
                          v-model="modalCotizar.cotizar.validez"
                          v-validate="'required'"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="guardarCotizacion">
                {{ modalCotizar.vista == 1 ? 'Siguiente' : 'Finalizar' }}
              </button>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  <!-- Modal Verificar de usuario login -->
    <template id="login">
      <div
        class="modal fade"
        id="modal-login"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="modal-publicar">
              <div class="modal-header">
                <h5
                  align="center"
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modalLogin.titulo"
                ></h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" data-vv-scope="form_registro_grado_curso">
                  <div class="row">
                    <div class="form-group col-12">
                      <div class="form-group mb-4 col-12 d-flex justify-content-center">
                        <label class="form-group mb-4">
                          <strong>VERIFICACIÓN DE USUARIO</strong>
                        </label>
                      </div>
                      <div class="form-group col-12 d-flex justify-content-center">
                        <label class="m-0 form-group col-3">
                          <strong>Ingrese RUC </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group form-control d-inline col-3"
                          data-vv-as=""
                          placeholder=""
                          name="usuario"
                          v-model="modalLogin.user.usuario"
                        />
                      </div>
                      <div class="form-group col-12 d-flex justify-content-center">
                        <label class="m-0 form-group col-3">
                          <strong>Contraseña </strong>
                        </label>
                        <input
                          type="password"
                          class="form-group form-control d-inline col-3"
                          data-vv-as=""
                          placeholder=""
                          name="ruc"
                          v-model="modalLogin.user.password"
                        />
                      </div>
                      <div class="form-group col-12 d-flex justify-content-center">
                        <label class="m-0 form-group col-3">
                        </label>
                        <button type="button" class="btn btn-warning col-3 col mb-4" @click.prevent="acceder(modalLogin.user)">
                            Acceder
                        </button>
                      </div>
                      <div class="form-group col-12 d-flex justify-content-center">
                        <label class="m-0 form-group col-3">
                          <strong>¿Eres nuevo usuario? </strong>
                        </label>
                        <button type="button" class="btn btn-primary col-3 col" @click.prevent="verDocumento(modalDetalle.detalles.eett)">
                            Registrate aquí
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-primary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  <!-- Modal Verificar de usuario registrar -->
    <template id="registrar">
      <div
        class="modal fade"
        id="modal-registrar"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="modal-publicar">
              <div class="modal-header">
                <h5
                  align="center"
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modalDetalle.titulo"
                ></h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" data-vv-scope="form_registro_grado_curso">
                  <div class="row">
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Unidad Ejecutora: </strong>
                        GERENCIA SUB REGIONAL CHANKA
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Nro. de Identificacion: </strong>
                        000748
                      </p>
                    </div>
                  </div>
                  <div class="row" style="border: 2px solid black">
                    <div class="form-group col-2">
                      <p class="m-0">
                        <strong>Nro. Cons: </strong>
                        <label v-text="modalDetalle.detalles.consolidado"></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalDetalle.detalles.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento Pedido: </strong>
                        <label v-text="modalDetalle.detalles.nro_cmn"></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalDetalle.detalles.descripcion"
                        ></label>
                      </p>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <vue-good-table
                      :columns="listarPedidosDetalle.columns"
                      :rows="listarPedidosDetalle.data"
                      :sort-options="{
                        enabled: false,
                      }"
                    >
                    </vue-good-table>
                  </div>
                  <br />
                  <div class="row">
                    <div class="form-group col-12">
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Nro de Cotización: </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="nro_cotizacion"
                          v-model="modalDetalle.detalles.nro_cotizacion"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Fecha de Publicacion: </strong>
                        </label>
                        <input
                          type="datetime-local"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="fecha_publicacion"
                          v-model="modalDetalle.detalles.fecha_publicacion"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Fecha de Finalizacion: </strong>
                        </label>
                        <input
                          type="datetime-local"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          v-model="modalDetalle.detalles.fecha_fin"
                          name="fecha_fin"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Descripción: </strong>
                        </label>
                        <input
                          type="text"
                          class="form-group col-6"
                          data-vv-as="00000"
                          placeholder="00000"
                          v-model="modalDetalle.detalles.descripcion2"
                          name="descripcion2"
                          v-validate="'required'" disabled
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Documento: </strong>
                        </label>
                        <button type="button" class="btn btn-warning"  @click.prevent="verDocumento(modalDetalle.detalles.documento)">
                            Descargar
                        </button>
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>EE.TT.: </strong>
                        </label>
                        <button type="button" class="btn btn-warning" @click.prevent="verDocumento(modalDetalle.detalles.eett)">
                            Descargar
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-primary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
    </div>
</template>

<script>

import Helper from "../../services/Helper";

import Multiselect from "vue-multiselect";
import DateRangePicker from 'vue2-daterange-picker'

import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import Crypt from "../../services/Crypt";

    export default {
        name:'Usuarios',
        components:{
            Multiselect, DateRangePicker,
        },
        data(){
            return{
                listaCotizaciones:{
                    data: [],
                    columns:[
                        {label: 'Nro', field: 'nro_cotizacion',},
                        {label: 'Descripción', field: 'pedido_siga.descripcion',},
                        {label: 'Finaliza', field: 'publicacion_cotizacion.fecha_fin',formatfn: this.formatdate,},
                        {label: 'Opciones', field: 'options',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        ocupacion:'',
                        fechaIni: '',
                        fechaFin: '',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                listarPedidosDetalle: {
                    data: [],
                    columns: [
                    { label: "Cantidad Requerida", field: "cantidad" },
                    { label: "Unidad de Medida", field: "unidad_medida" },
                    { label: "Descripcion", field: "descripcion" },
                    ],
                    total: 0,
                    filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "id",
                    regPagina: "10",
                    },
                    deshabilitarEdicion: false,
                },
                listarPedidosCotizar: {
                    data: [],
                    columns: [
                    { label: "Cantidad Requerida", field: "cantidad" },
                    { label: "Unidad de Medida", field: "unidad_medida" },
                    { label: "Descripcion", field: "descripcion" },
                    { label: "Precio Unitario", field: "precio_unitario_propuesta" },
                    { label: "Precio Total", field: "precio_total" },
                    ],
                    total: 0,
                    filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "id",
                    regPagina: "10",
                    },
                    deshabilitarEdicion: false,
                },
                desabilitado: false,
                botonesActive: {
                    todos: true,
                    misMenciones: false,
                },
                mensaje: {
                    mensaje: '',
                },
                modalDetalle: {
                    tipo: "",
                    titulo: "",
                    nivelID: null,
                    detalles: {
                      id: "",
                      nro_cmn: "",
                      descripcion: "",
                      tipo: "",
                      options: "",
                    },
                },
                modalCotizar: {
                    tipo: "",
                    titulo: "",
                    vista: 1,
                    cotizar: {
                      id: "",
                      nro_cmn: "",
                      consolidado: "",
                      descripcion: "",
                      tipo: "",
                      options: "",
                    },
                },
                modalLogin: {
                    tipo: "",
                    titulo: "",
                    user: {
                     usuario: "",
                     password: "",
                    },
                },
                dateRange: {
                    startDate: '',
                    endDate: '', //endDate: '2019-12-28',
                },
                comboOcupacion:[],
                ocupacionesSel: null,
                rowSelect:'',
                indexSelect:'',
                proveedor:'',
            }
        },
        created(){
          console.log()
          this.proveedor = this.$store.getters.getAuthUser('proveedor');
           this.listarCotizaciones();
        },
        methods:{
            listarCotizaciones(){
                axios.get("api/cotizacionPublico/listar"+Helper.getFilterURL(this.listaCotizaciones.filtrosBusqueda))
                .then((response) => {
                    this.listaCotizaciones.data =  response.data;
                
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
            detalle(row, index) {
                console.log('row', row)
                $("#modal-detalle").modal("show");
                this.limpiarFormulario();
                axios
                .get("api/pedidoSigaPublico/listarImprimir/" + row.pedido_siga.id)
                .then((response) => {
                console.log(response.data);
                this.listarPedidosDetalle.data = response.data[0].detalle_pedido_siga;
                this.modalDetalle = {
                    titulo: "Solicitud de Cotización",
                    tipo: "ver",
                    detalles: {
                    id: row.id,
                    nro_cmn: row.pedido_siga.nro_cmn,
                    fecha_pedido: row.pedido_siga.fecha_pedido,
                    descripcion: row.pedido_siga.descripcion,
                    ano_eje: row.ano_eje,
                    tipo: row.pedido_siga.tipo,
                    consolidado: row.pedido_siga.consolidado,
                    estado: row.estado,
                    nro_cotizacion: row.nro_cotizacion,
                    fecha_publicacion: row.publicacion_cotizacion?.fecha_publicacion,
                    fecha_fin: row.publicacion_cotizacion?.fecha_fin,
                    descripcion2: row.pedido_siga.descripcion,
                    documento: row.publicacion_cotizacion?.documento_cotizacion[0]?.url_documento,
                    eett: row.publicacion_cotizacion?.documento_cotizacion[1]?.url_documento,
                    },
                    deshabilitado: true,
                };
                })
                .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
                });
            },

            verDocumento(documento){
                let $ruta
                // axios.get('api/documento/abrirDocumento/'+documento)
                //     .then(response => {if(response)
                //     $ruta = response.data.ruta; 
                //     var docDireccion = $ruta+documento+'.pdf'; 
                // window.open(docDireccion,"resizeable,scrollbar"); 
                // })
                //     .catch(function (error){
                //             toastr['error'](error);                     
                //         });

                var docDireccion = 'Documentos/'+documento; 
                window.open(docDireccion,"resizeable,scrollbar"); 
            },

            cotizar(row, index) {
              this.rowSelect = row;
              this.indexSelect = index;
              if(!this.$store.getters.getAuthUser('identificador')){
                console.log('no está autenticado')
                $("#modal-login").modal("show");
                this.modalLogin = {
                    titulo: "Sistema de cotización",
                    tipo: "ver",
                    user: {
                    ruc: "",
                    password: "",
                    },
                    deshabilitado: true,
                };
              } else {
                axios
                .get("api/cotizacionPropuesta/listarPropuestaUser/" + row.publicacion_cotizacion.id)
                .then((response) => {
                  console.log('entra a repsonse');
                console.log(response.data);
                $("#modal-cotizar").modal("show");
                this.limpiarFormulario();

                response.data[0].detalle_pedido_siga = response.data[0].cotizacion.pedido_siga.detalle_pedido_siga.map((e) => { e.precio_unitario_propuesta = ''; return e;} )
                this.listarPedidosCotizar.data = response.data[0].detalle_pedido_siga;
                this.modalCotizar = {
                    titulo: "Sistema de cotización",
                    tipo: "ver",
                    vista: 1,
                    cotizar: {
                      id: row.id,
                      nro_cmn: row.pedido_siga.nro_cmn,
                      fecha_pedido: row.pedido_siga.fecha_pedido,
                      descripcion: row.pedido_siga.descripcion,
                      ano_eje: row.ano_eje,
                      estado: row.estado,
                      garantia: '',
                      igv: '',
                      forma_pago: '',
                      tipo_moneda: '',
                      plazo_entrega: '',
                      validez: '',
                      total: '',
                      id_publicacion:  row.publicacion_cotizacion.id,
                      id_proveedor:this.proveedor
                    },
                    deshabilitado: true,
                };
                })
                .catch((error) => {
                this.$toastr.w(error.response.data.error);
                });
              }
            },

            guardarCotizacion(){
              if(this.modalCotizar.vista == 1){
                this.modalCotizar.vista = 2;
              } else if(this.modalCotizar.vista == 2 ){

                let _this = this;
                let data = new FormData();
                data.append('cotizacion_archivo', document.getElementById('cotizacion_archivo').files[0]);
                data.append('cotizacion_ficharuc', document.getElementById('cotizacion_ficharuc').files[0]);
                data.append('cotizacion_rnp', document.getElementById('cotizacion_rnp').files[0]);
                data.append('cotizacion_cci', document.getElementById('cotizacion_cci').files[0]);
                data.append('cotizacion_anexo', document.getElementById('cotizacion_anexo').files[0]);
                data.append('estado',_this.modalCotizar.cotizar.estado);
                data.append('garantia',_this.modalCotizar.cotizar.garantia);
                data.append('igv',_this.modalCotizar.cotizar.igv);
                data.append('forma_pago',_this.modalCotizar.cotizar.forma_pago);
                data.append('tipo_moneda',_this.modalCotizar.cotizar.tipo_moneda);
                data.append('plazo_entrega',_this.modalCotizar.cotizar.plazo_entrega);
                data.append('validez',_this.modalCotizar.cotizar.validez);
                data.append('total',_this.modalCotizar.cotizar.total);
                data.append('id_publicacion',_this.modalCotizar.cotizar.id_publicacion);
                data.append('id_proveedor',_this.modalCotizar.cotizar.id_proveedor);
                data.append('detalle_propuesta',JSON.stringify(_this.listarPedidosCotizar.data));
                console.log('detalle propuesta',_this.listarPedidosCotizar.data);

                axios
                  .post("api/cotizacionPropuesta/crear",data)
                  .then((response) => {
                    this.$toastr.s(response.data.message);
                    $("#modal-cotizar").modal("hide");
                    document.getElementById('cotizacion_archivo').value='';
                    document.getElementById('cotizacion_ficharuc').value='';
                    document.getElementById('cotizacion_rnp').value='';
                    document.getElementById('cotizacion_cci').value='';
                    document.getElementById('cotizacion_anexo').value='';
                  })
                  .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                  });
              }
            },

            changePrecio(changedData, column, row) {
            this.listarPedidosCotizar.data[row][column] = changedData
            },

            acceder(){
              axios.post("api/auth/admin", this.modalLogin.user)
              .then((response) => {
                  this.$toastr.s(response.data.message);
                  localStorage.setItem("token_laravel", response.data.token_laravel);
                  axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("token_laravel");
                  axios.get("api/auth/user")
                  .then((response) => {
                      console.log('usuario',response);
                      let usuario = response.data;
                      this.proveedor = usuario.id_proveedor;
                      this.$store.dispatch('setAuthUserDetail',{//aqui extrae la info el usuario y lo asigno a la variable
                          identificador: Crypt.encrypt(usuario.id),
                          email: usuario.email,
                          // nombres: usuario.persona.nombres,
                          // apellidos: usuario.persona.apellido_pat+' '+usuario.persona.apellido_mat,
                          usuario: usuario.usuario,
                          avatar: usuario.avatar,
                          rol: usuario.tipo_usuario,
                          proveedor: usuario.id_proveedor
                      });
                      $("#modal-login").modal('hide');
                      console.log('deberia ingresar')
                      this.cotizar(this.rowSelect, this.indexSelect);
                  })
                  .catch((error) => {
                      console.log(error);
                      this.$toastr.e(error.response.data.message);
                  });
              })
              .catch((error) => {
                  console.log(error);
                  this.$toastr.e(error.response.data.message);
              });
            },
            
            formatdate(value) {
                console.log('entro aqui', value)
                return moment(value).format("mmmm dd yyyy")
             },
            formatauthority(value) {
                return `item ${value}`;
            },
           
            seleccionoFecha(evt){
                this.listaCotizaciones.filtrosBusqueda.fechaIni = Helper.formatearSoloFechaGenerico(evt.startDate);
                this.listaCotizaciones.filtrosBusqueda.fechaFin = Helper.formatearSoloFechaGenerico(evt.endDate);
                this.listarCotizaciones();
            },
            seleccionoOcupacion(){
                this.listaCotizaciones.filtrosBusqueda.ocupacion = (this.ocupacionesSel.map((elem) => elem.id)).join(',');
                this.listarCotizaciones();
            },
            limpiarFormulario(){
                this.modal = {
                    tipo:  '',
                    titulo:  '',
                    usuarioID: null,
                    usuario:{
                        email: '',
                        nombres: '',
                        num_docid: '',
                        apellidos: '',
                        password: '',
                        tipo_usuario: '',
                        editarPassword: true,
                        es_admin: true
                    }
                },
                this.$validator.reset();
            },
            nuevoUsuario(){
                $("#modal-administrador").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo usuario';
                this.modal.tipo = 'nuevo';
                
            },
            ver(row, index){
                if(row.es_admin == true){
                    $("#modal-administrador").modal('show');
                    this.limpiarFormulario();
                    this.modal = {
                        tipo: 'ver',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }
                else{
                    $("#modal-usuario").modal('show');
                    this.limpiarFormulario();
                    this.modalUsuario = {
                        tipo: 'ver',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuarioOcupacionSel: this.comboOcupacion.find(item => item.id == row.ocupacion_id),
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }


            },
            editar(row, index){
                if(row.es_admin == true){
                    $("#modal-administrador").modal('show');
                    this.limpiarFormulario();
                    this.modal = {
                        tipo: 'editar',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }
                else{
                    $("#modal-usuario").modal('show');
                    this.limpiarFormulario();
                    this.modalUsuario = {
                        tipo: 'editar',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuarioOcupacionSel: this.comboOcupacion.find(item => item.id == row.ocupacion_id),
                        usuario:{
                            email: row.email,
                            nombres: row.nombres,
                            apellidos: row.apellidos,
                            puesto_actual: row.puesto_actual,
                            usuario: row.usuario,
                        }
                    }
                }

            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    console.log(this.modal.usuario);
                    if (result) {  
                        axios.post("api/usuario/crear", this.modal.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-administrador").modal('hide');
                            this.listarCotizaciones();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            modificar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {  
                        axios.put("api/usuario/modificar/" + this.modal.usuarioID, this.modal.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-administrador").modal('hide');
                            this.listarCotizaciones();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            modificarUsuario(){
                this.$validator.validateAll('form_registro_usuario').then(result => {
                    if (result) {  
                        axios.put("api/usuario/modificar/" + this.modalUsuario.usuarioID, this.modalUsuario.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-usuario").modal('hide');
                            this.listarCotizaciones();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            inactivar(row, index){
                axios.put("api/usuario/inactivar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    this.listarCotizaciones();
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            activar(row, index){
                axios.put("api/usuario/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            enviarMensaje(row, index){
               this.$router.push({
                    name: "Mensajes",
                    params: {
                        usuario_id: row.id,
                        nombre: row.nombres + ' ' + row.apellidos,
                    }
                });
            },
             buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra');
                            this.limpiarFormularioBuscar()
                            this.modal.tipo='nuevo';
                            }
                            else{
                                console.log(response.data);
                            this.modal.usuario.nombres=response.data.nombres;
                            this.modal.usuario.apellidos=response.data.apellido_pat+' '+response.data.apellido_mat;  

                            this.modal.usuario.id_per=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            exportar(){
                if(this.listaCotizaciones.filtrosBusqueda.fechaIni){
                    this.listaCotizaciones.filtrosBusqueda.fechaIni
                    this.listaCotizaciones.filtrosBusqueda.fechaFin
                }

                let url = process.env.MIX_APP_URL + '/exportar/usuarios' + Helper.getFilterURL(this.listaCotizaciones.filtrosBusqueda);
                window.open(url);
            }
        },
    }
</script>
<style >
.calendars > .ranges {
      padding-left: 0%;
      padding-right: 0%;
      max-width: 23%;
} 
.daterangepicker.show-calendar .ranges {
    margin-top: 8px;
    width: 23%;
    max-width: 23%;
}
</style>