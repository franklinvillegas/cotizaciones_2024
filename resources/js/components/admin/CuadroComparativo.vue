<template>
  <div class="p-3 pt-5">
    <div class="col-md-12" style="margin-left: -10px">
      <h4 class="text-color-2 mb-3">CUADRO COMPARATIVO</h4>
    </div>
    <hr />

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
              @click.prevent="cuadroComparativo(props.row, props.index)"
              data-toggle="tooltip"
              title="Agregar"
            >
              C. C.
            </button>
          </span>
        </template>
      </vue-good-table>
    </div>
    <!-- Modal cuadroComparativo -->
    <template id="cuadroComparativo">
      <div
        class="modal fade"
        id="modal-cuadroComparativo"
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
                  v-text="modalCuadroComparativo.titulo"
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
                    <div class="form-group col-2">
                      <p class="m-0">
                        <strong>Nro. Cons: </strong>
                        <label
                          v-text="modalCuadroComparativo.detalles.consolidado"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalCuadroComparativo.detalles.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento CMN: </strong>
                        <label
                          v-text="modalCuadroComparativo.detalles.nro_cmn"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalCuadroComparativo.detalles.descripcion"
                        ></label>
                      </p>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <vue-good-table
                      :columns="listarProveedoresCuadroComparativo.columns"
                      :rows="listarProveedoresCuadroComparativo.data"
                      :line-numbers="true"
                      :sort-options="{
                        enabled: false,
                      }"
                    >
                      <template slot="table-row" slot-scope="props">
                        <!-- <span v-if="props.column.field == 'publicacion_cotizacion.fecha_fin'">
                    {{ formatdate(props.row.publicacion_cotizacion.fecha_fin) }}
                </span> -->
                        <span v-if="props.index== '5' && props.column.field!='descripcion' " @change="changeGanador(props.row[props.column.field], props.column.field, props.row.originalIndex)">
                           <input type="checkbox" v-bind:id="props.column.field" class="form-control" >
                        </span>
                      </template>
                    </vue-good-table>
                  </div>
                  <br />
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
              >
                Guardar
              </button><button
                type="button"
                class="btn btn-success"
                data-dismiss="modal"
              >
                Imprimir
              </button><button
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
import DateRangePicker from "vue2-daterange-picker";

import "vue2-daterange-picker/dist/vue2-daterange-picker.css";

export default {
  name: "Usuarios",
  components: {
    Multiselect,
    DateRangePicker,
  },
  data() {
    return {
      listaCotizaciones: {
        data: [],
        columns: [
          { label: "ID", field: "id" },
          { label: "CMN", field: "pedido_siga.nro_cmn" },
          { label: "Descripción", field: "pedido_siga.descripcion" },
          { label: "Tipo", field: "pedido_siga.tipo" },
          { label: "Opciones", field: "options" },
        ],
        total: 0,
        filtrosBusqueda: {
          tipo: "",
          ocupacion: "",
          fechaIni: "",
          fechaFin: "",
          orden: "asc",
          ordenPor: "id",
          regPagina: "10",
        },
        deshabilitarEdicion: false,
      },
      listarPedidosDetalle: {
        data: [],
        columns: [
          { label: "Cantidad Requerida", field: "cantidad" },
          { label: "Unidad de Medida", field: "unidad_medida" },
          { label: "Descripcion", field: "descripcion" },
          { label: "Precio Unitario", field: "precio_unitario" },
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
      listarProveedoresCuadroComparativo: {
        data: [],
        columns: [{ label: "Descripción", field: "descripcion" }],
        total: 0,
        filtrosBusqueda: {
          tipo: "",
          orden: "asc",
          ordenPor: "id",
          regPagina: "10",
        },
        deshabilitarEdicion: false,
      },
      listarPedidosCuadroComparativo: {
        data: [],
        columns: [
          { label: "Cantidad Requerida", field: "cantidad" },
          { label: "Unidad de Medida", field: "unidad_medida" },
          { label: "Descripcion", field: "descripcion" },
        ],
        total: 0,
        filtrosBusqueda: {
          tipo: "",
          orden: "des",
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
        mensaje: "",
      },
      modalCuadroComparativo: {
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
      dateRange: {
        startDate: "",
        endDate: "", //endDate: '2019-12-28',
      },
      comboOcupacion: [],
      ocupacionesSel: null,
    };
  },
  created() {
    this.listarCotizaciones();
  },
  methods: {
    listarCotizaciones() {
      axios
        .get(
          "api/cotizacionPublico/listar" +
            Helper.getFilterURL(this.listaCotizaciones.filtrosBusqueda)
        )
        .then((response) => {
          this.listaCotizaciones.data = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    cuadroComparativo(row, index) {
      $("#modal-cuadroComparativo").modal("show");
      this.limpiarFormulario();
      this.listarProveedoresCuadroComparativo.columns = [
        { label: "Descripción", field: "descripcion" },
      ];
      axios
        .get(
          "api/cotizacion/listarOfertasComparar/" +
            row.publicacion_cotizacion.id
        )
        .then((response) => {
          let cotizacion_propuesta = response.data[0].cotizacion_propuesta;
          this.listarProveedoresCuadroComparativo.data = response.data[0].cotizacion.pedido_siga.detalle_pedido_siga;
          console.log(this.listarProveedoresCuadroComparativo.data);
          let cant =   this.listarProveedoresCuadroComparativo.data.length;
            console.log('cant',cant);
           this.listarProveedoresCuadroComparativo.data[cant]={
            descripcion:"TOTAL",
            };
            this.listarProveedoresCuadroComparativo.data[cant+1]={
            descripcion:"Plazo de Entrega",
            };
            this.listarProveedoresCuadroComparativo.data[cant+2]={
            descripcion:"Validez de la cotizacion",
            };
            this.listarProveedoresCuadroComparativo.data[cant+3]={
            descripcion:"Seleccionar Ganador",
            };
            
          cotizacion_propuesta.forEach((element, index) => {
          let sumaTotal=0;

            this.listarProveedoresCuadroComparativo.data.forEach((e, i) => {
              e["proveedor" + element.proveedor.id] = element.detalle_propuesta[i]?.precio_total;
              sumaTotal+= parseFloat(e["proveedor" + element.proveedor.id]) ? parseFloat(e["proveedor" + element.proveedor.id]) : 0;

            });
            this.listarProveedoresCuadroComparativo.data[cant]["proveedor" + element.proveedor.id]=sumaTotal.toFixed(2);
            this.listarProveedoresCuadroComparativo.data[cant+1]["proveedor" + element.proveedor.id]=element.plazo_entrega;
            this.listarProveedoresCuadroComparativo.data[cant+2]["proveedor" + element.proveedor.id]=element.validez;
            this.listarProveedoresCuadroComparativo.data[cant+3]["proveedor" + element.proveedor.id]=element.ganador;
            
            this.listarProveedoresCuadroComparativo.columns.push({
              label: element.proveedor.razon_social,
              field: "proveedor" + element.proveedor.id,
            });
            
          });
          this.modalCuadroComparativo = {
            titulo: "Proveedores que ofertaron",
            tipo: "ver",
            detalles: {
              nro_cmn: row.pedido_siga.nro_cmn,
              fecha_pedido: row.pedido_siga.fecha_pedido,
              descripcion: row.pedido_siga.descripcion,
              consolidado: row.pedido_siga.consolidado,
            },
            deshabilitado: true,
          };
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    changeGanador(changedData, column, row) {
      console.log("cambio",changedData,"  -- ", column," .---", row);
      console.log(this.listarProveedoresCuadroComparativo);
            this.listarProveedoresCuadroComparativo.data[row][column] = changedData;
                  console.log(this.listarProveedoresCuadroComparativo);

            },
    verDetalle(row, index) {
      console.log("row", row);
      $("#modal-detalles").modal("show");
      this.limpiarFormulario();
      axios
        .get("api/pedidoSiga/listarImprimir/" + row.pedido_siga.id)
        .then((response) => {
          console.log(response.data);
          this.listarPedidosCuadroComparativo.data =
            response.data[0].detalle_pedido_siga;
          this.modalCuadroComparativo = {
            titulo: "Solicitud de Cotización",
            tipo: "ver",
            detalles: {
              id: response.data[0].id,
              nro_cmn: response.data[0].nro_cmn,
              fecha_pedido: response.data[0].fecha_pedido,
              descripcion: response.data[0].descripcion,
              ano_eje: response.data[0].ano_eje,
              tipo: response.data[0].tipo,
              estado: response.data[0].estado,
              consolidado: response.data[0].consolidado,
              nro_cotizacion: row.nro_cotizacion,
              fecha_publicacion: row.publicacion_cotizacion?.fecha_publicacion,
              fecha_fin: row.publicacion_cotizacion?.fecha_fin,
              descripcion2: row.pedido_siga.descripcion,
              documento:
                row.publicacion_cotizacion?.documento_cotizacion[0]
                  ?.url_documento,
              eett: row.publicacion_cotizacion?.documento_cotizacion[1]
                ?.url_documento,
            },
            deshabilitado: true,
          };
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },

    verDocumento(documento) {
      let $ruta;
      // axios.get('api/documento/abrirDocumento/'+documento)
      //     .then(response => {if(response)
      //     $ruta = response.data.ruta;
      //     var docDireccion = $ruta+documento+'.pdf';
      // window.open(docDireccion,"resizeable,scrollbar");
      // })
      //     .catch(function (error){
      //             toastr['error'](error);
      //         });

      var docDireccion = "Documentos/" + documento;
      window.open(docDireccion, "resizeable,scrollbar");
    },

    formatdate(value) {
      console.log("entro aqui", value);
      return moment(value).format("mmmm dd yyyy");
    },
    formatauthority(value) {
      return `item ${value}`;
    },

    seleccionoFecha(evt) {
      this.listaCotizaciones.filtrosBusqueda.fechaIni =
        Helper.formatearSoloFechaGenerico(evt.startDate);
      this.listaCotizaciones.filtrosBusqueda.fechaFin =
        Helper.formatearSoloFechaGenerico(evt.endDate);
      this.listarCotizaciones();
    },
    seleccionoOcupacion() {
      this.listaCotizaciones.filtrosBusqueda.ocupacion = this.ocupacionesSel
        .map((elem) => elem.id)
        .join(",");
      this.listarCotizaciones();
    },
    limpiarFormulario() {
      (this.modal = {
        tipo: "",
        titulo: "",
        usuarioID: null,
        usuario: {
          email: "",
          nombres: "",
          num_docid: "",
          apellidos: "",
          password: "",
          tipo_usuario: "",
          editarPassword: true,
          es_admin: true,
        },
      }),
        this.$validator.reset();
    },
    nuevoUsuario() {
      $("#modal-administrador").modal("show");
      this.limpiarFormulario();
      this.modal.titulo = "Nuevo usuario";
      this.modal.tipo = "nuevo";
    },
    ver(row, index) {
      if (row.es_admin == true) {
        $("#modal-administrador").modal("show");
        this.limpiarFormulario();
        this.modal = {
          tipo: "ver",
          titulo: "Editar usuario",
          usuarioID: row.id,
          usuario: {
            email: row.email,
            nombres: row.persona.nombres,
            apellidos:
              row.persona.apellido_pat + " " + row.persona.apellido_pat,
            tipo_usuario: row.tipo_usuario,
            num_docid: row.persona.num_docid,
            es_admin: true,
            editarPassword: true,
          },
        };
      } else {
        $("#modal-usuario").modal("show");
        this.limpiarFormulario();
        this.modalUsuario = {
          tipo: "ver",
          titulo: "Editar usuario",
          usuarioID: row.id,
          usuarioOcupacionSel: this.comboOcupacion.find(
            (item) => item.id == row.ocupacion_id
          ),
          usuario: {
            email: row.email,
            nombres: row.persona.nombres,
            apellidos:
              row.persona.apellido_pat + " " + row.persona.apellido_pat,
            tipo_usuario: row.tipo_usuario,
            num_docid: row.persona.num_docid,
            es_admin: true,
            editarPassword: true,
          },
        };
      }
    },
    editar(row, index) {
      if (row.es_admin == true) {
        $("#modal-administrador").modal("show");
        this.limpiarFormulario();
        this.modal = {
          tipo: "editar",
          titulo: "Editar usuario",
          usuarioID: row.id,
          usuario: {
            email: row.email,
            nombres: row.persona.nombres,
            apellidos:
              row.persona.apellido_pat + " " + row.persona.apellido_pat,
            tipo_usuario: row.tipo_usuario,
            num_docid: row.persona.num_docid,
            es_admin: true,
            editarPassword: true,
          },
        };
      } else {
        $("#modal-usuario").modal("show");
        this.limpiarFormulario();
        this.modalUsuario = {
          tipo: "editar",
          titulo: "Editar usuario",
          usuarioID: row.id,
          usuarioOcupacionSel: this.comboOcupacion.find(
            (item) => item.id == row.ocupacion_id
          ),
          usuario: {
            email: row.email,
            nombres: row.nombres,
            apellidos: row.apellidos,
            puesto_actual: row.puesto_actual,
            usuario: row.usuario,
          },
        };
      }
    },
    guardar() {
      this.$validator.validateAll("form_registro").then((result) => {
        console.log(this.modal.usuario);
        if (result) {
          axios
            .post("api/usuario/crear", this.modal.usuario)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-administrador").modal("hide");
              this.listarCotizaciones();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    modificar() {
      this.$validator.validateAll("form_registro").then((result) => {
        if (result) {
          axios
            .put(
              "api/usuario/modificar/" + this.modal.usuarioID,
              this.modal.usuario
            )
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-administrador").modal("hide");
              this.listarCotizaciones();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    modificarUsuario() {
      this.$validator.validateAll("form_registro_usuario").then((result) => {
        if (result) {
          axios
            .put(
              "api/usuario/modificar/" + this.modalUsuario.usuarioID,
              this.modalUsuario.usuario
            )
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-usuario").modal("hide");
              this.listarCotizaciones();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    inactivar(row, index) {
      axios
        .put("api/usuario/inactivar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          this.listarCotizaciones();
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
    },
    activar(row, index) {
      axios
        .put("api/usuario/activar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = true;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
    },
    enviarMensaje(row, index) {
      this.$router.push({
        name: "Mensajes",
        params: {
          usuario_id: row.id,
          nombre: row.nombres + " " + row.apellidos,
        },
      });
    },
    buscar(dni) {
      console.log("dni", dni);
      axios
        .get("api/persona/buscar/" + dni)
        .then((response) => {
          if (!response.data || response.data == "") {
            this.$toastr.w("La persona no se encuentra");
            this.limpiarFormularioBuscar();
            this.modal.tipo = "nuevo";
          } else {
            console.log(response.data);
            this.modal.usuario.nombres = response.data.nombres;
            this.modal.usuario.apellidos =
              response.data.apellido_pat + " " + response.data.apellido_mat;

            this.modal.usuario.id_per = response.data.id;
          }
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    exportar() {
      if (this.listaCotizaciones.filtrosBusqueda.fechaIni) {
        this.listaCotizaciones.filtrosBusqueda.fechaIni;
        this.listaCotizaciones.filtrosBusqueda.fechaFin;
      }

      let url =
        process.env.MIX_APP_URL +
        "/exportar/usuarios" +
        Helper.getFilterURL(this.listaCotizaciones.filtrosBusqueda);
      window.open(url);
    },
  },
};
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