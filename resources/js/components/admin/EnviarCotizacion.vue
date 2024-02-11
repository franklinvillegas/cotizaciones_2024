<template>
  <div class="p-3 pt-5">
    <div class="col-md-12" style="margin-left: -15px">
      <button
        class="btn btn-outline-secondary float-right"
        type="button"
        @click="nuevo"
      >
        Nuevo
      </button>
      <h4 class="text-color-2 mb-3">Enviar para cotizaciones</h4>
    </div>
    <br />
    <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarPedidos.filtrosBusqueda.tipo" @change="listarPedido" >
                        <option value="">-- Todos -- </option>
                        <option value="1">Inicio</option>
                        <option value="2">Pregunta</option>
                        <option value="3">Publicación</option>
                    </select>
                </div>
            </div>
        </div>
        <hr> -->

    <!-- <hr>
        <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
            <i class="fas fa-download"></i>
            Exportar
        </button>
        <br> -->
    <div class="table-responsive">
      <vue-good-table
        :columns="listarPedidos.columns"
        :rows="listarPedidos.data"
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
          <span v-if="props.column.field == 'options'">
            <button
              class="btn btn-outline-success btn-sm btn-icon"
              @click.prevent="impresion(props.row, props.index)"
              data-toggle="tooltip"
              title="Agregar"
            >
              Impresión
            </button>
            <button
              class="btn btn-outline-danger btn-sm btn-icon"
              @click.prevent="publicacion(props.row, props.index)"
              data-toggle="tooltip"
              title="Agregar"
            >
              Publicación
            </button>
          </span>
        </template>
      </vue-good-table>
    </div>
    <!-- Modal Impresion -->
    <template id="impresion">
      <div
        class="modal fade"
        id="modal-impresion"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div id="modal-imprimir">
              <div class="modal-header">
                <h5
                  align="center"
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modalImpresion.titulo"
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
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Señores: </strong>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>RUC: </strong>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Dirección: </strong>
                      </p>
                    </div>
                    <div class="form-group col-3">
                      <p class="m-0">
                        <strong>Telefono: </strong>
                      </p>
                    </div>
                    <div class="form-group col-9">
                      <p class="m-0">
                        <strong>Fax: </strong>
                      </p>
                    </div>
                    <div class="form-group col-2">
                      <p class="m-0">
                        <strong>Nro. Cons: </strong>
                        <label v-text="modalImpresion.detalles.id"></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalImpresion.detalles.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento Pedido: </strong>
                        <label v-text="modalImpresion.detalles.nro_cmn"></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalImpresion.detalles.descripcion"
                        ></label>
                      </p>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <vue-good-table
                      :columns="listarPedidosDetalle.columns"
                      :rows="listarPedidosDetalle.data"
                      styleClass="vgt-table bordered"
                      :sort-options="{
                        enabled: false,
                      }"
                    >
                    </vue-good-table>
                  </div>
                  <br />
                  <div class="row">
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>Total: </strong>
                      </p>
                      <hr />
                      <p>
                        Las cotizaciones deben estar dirigidas a la GERENCIA SUB
                        REGIONAL CHANKA en la siguiente dirección: Jr Tupac
                        Amaru 374 Teléfono: (083) 421745
                      </p>
                      <p>Condiciones de compra</p>
                      <p class="mb-0">- Forma de Pago:</p>
                      <p class="mb-0">- Garantía:</p>
                      <p class="mb-0">- I.G.V.:</p>
                      <p class="mb-0">- Plazo de entrega:</p>
                      <p class="mb-0">- Tipo de Moneda:</p>
                      <p class="mb-0">- Validéz de cotización:</p>
                      <p class="mb-0">
                        - Remitir junto con su cotización la Declaración Jurada
                        y Pacto de Integridad, debidamente firmadas y selladas.
                        -Indicar su razón social, domicilio fiscal y número de
                        RUC
                      </p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="imprimir">
                Imprimir
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
    <!-- Modal Publicacion -->
    <template id="publicacion">
      <div
        class="modal fade"
        id="modal-publicacion"
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
                  v-text="modalImpresion.titulo"
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
                        <label v-text="modalImpresion.detalles.id"></label>
                      </p>
                    </div>
                    <div class="form-group col-4">
                      <p class="m-0">
                        <strong>Fecha: </strong>
                        <label
                          v-text="modalImpresion.detalles.fecha_pedido"
                        ></label>
                      </p>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Documento Pedido: </strong>
                        <label v-text="modalImpresion.detalles.nro_cmn"></label>
                      </p>
                    </div>
                    <div class="form-group col-12">
                      <p class="m-0">
                        <strong>CONCEPTO: </strong>
                        <label
                          v-text="modalImpresion.detalles.descripcion"
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
                          name="numCotizacion"
                          v-model="modalPublicacion.detalles.numCotizacion"
                          v-validate="'required'"
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
                          name="fechaPublicacion"
                          v-model="modalPublicacion.detalles.fechaPublicacion"
                          v-validate="'required'"
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
                          v-model="modalPublicacion.detalles.fechaFizalizacion"
                          name="fechaFizalizacion"
                          v-validate="'required'"
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
                          v-model="modalPublicacion.detalles.descripcion"
                          name="descripcion"
                          v-validate="'required'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Adjuntar documento: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="documento"
                          v-validate="'required'"
                        />
                      </div>
                      <div class="form-group col-12">
                        <label class="m-0 form-group col-3">
                          <strong>Adjuntar EE.TT.: </strong>
                        </label>
                        <input
                          type="file"
                          class="form-group col-3"
                          data-vv-as="00000"
                          placeholder="00000"
                          name="eett"
                          v-validate="'required'"
                        />
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="publicar">
                Publicar
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
  </div>
</template>

<script>
import Helper from "../../services/Helper";

export default {
  name: "Ayudas",
  components: {},
  data() {
    return {
      listarPedidos: {
        data: [],
        columns: [
          { label: "ID", field: "id" },
          { label: "Pedido", field: "nro_cmn" },
          { label: "Descripcion", field: "descripcion" },
          { label: "Tipo", field: "tipo" },
          { label: "Tipo", field: "tipo" },
          { label: "Accion", field: "options" },
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
      listarPedidosDetalle: {
        data: [],
        columns: [
          { label: "Cantidad Requerida", field: "cantidad" },
          { label: "Unidad de Medida", field: "unidad_medida" },
          { label: "Descripcion", field: "descripcion" },
          { label: "Precio Unitario", field: "precio_unitario" },
          { label: "Precio Total", field: "precio_total´ñ" },
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
      listarPedidoCursos: {
        data: [],
        columns: [
          { label: "Curso", field: "curso.nombre" },
          { label: "Opciones", field: "options" },
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
      listarNiveles: [],
      listarCursos: [],
      deshabilitado: false,
      modal: {
        tipo: "",
        titulo: "Solicitud de Cotización",
        nivelID: null,
        grado: {
          grado: "",
          id_nivel: "",
        },
      },
      modalImpresion: {
        tipo: "",
        titulo: "",
        nivelID: null,
        detalles: {
          id: "",
          nro_cmn: "",
          fecha_pedido: "",
          descripcion: "",
          tipo: "",
          options: "",
          tabla: [],
        },
      },
      modalPublicacion: {
        tipo: "",
        titulo: "",
        nivelID: null,
        detalles: {
          id: "",
          nro_cmn: "",
          fecha_pedido : "",
          descripcion: "",
          tipo: "",
          options: "",
          numCotizacion:"",
          fechaPublicacion : "",
          fechaFinalizacion : "",
          descripcion1 : "",
          tabla: [],
        },
      },
    };
  },
  created() {
    this.listarPedido();
    this.listarNivel();
  },
  methods: {
    listarPedido() {
      axios
        .get(
          "api/pedidoSiga/listar" +
            Helper.getFilterURL(this.listarPedidos.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarPedidos.data = data;
          console.log(this.listarPedidos);
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    listarNivel() {
      axios
        .get(
          "api/nivel/listar" +
            Helper.getFilterURL(this.listarPedidos.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarNiveles = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    listarCurso() {
      axios
        .get(
          "api/curso/listar" +
            Helper.getFilterURL(this.listarPedidos.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarCursos = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    listarCursoPrimaria() {
      axios
        .get(
          "api/curso/listar_primaria" +
            Helper.getFilterURL(this.listarPedidos.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarCursos = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    listarCursoSecundaria() {
      axios
        .get(
          "api/curso/listar_secundaria" +
            Helper.getFilterURL(this.listarPedidos.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarCursos = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    limpiarFormulario() {
      this.modal = {
        titulo: "",
        nivelID: null,
        grado: {
          grado: "",
        },
        deshabilitado: false,
      };
      this.$validator.reset();
    },
    nuevo() {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal.titulo = "Nuevo grado";
      this.modal.tipo = "nuevo";
    },
    ver(row, index) {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal = {
        titulo: "Ver grado",
        tipo: "ver",
        grado: {
          grado: row.grado,
          id_nivel: row.id_nivel,
        },
        deshabilitado: true,
      };
    },
    impresion(row, index) {
      $("#modal-impresion").modal("show");
      this.limpiarFormulario();
      axios
        .get("api/pedidoSiga/listarImprimir/" + row.id)
        .then((response) => {
          console.log(response.data);
          this.listarPedidosDetalle.data = response.data[0].detalle_pedido_siga;
          this.modalImpresion = {
            titulo: "Solicitud de Cotización",
            tipo: "ver",
            detalles: {
              id: response.data[0].id,
              nro_cmn: response.data[0].nro_cmn,
              fecha_pedido: response.data[0].fecha_pedido,
              descripcion: response.data[0].descripcion,
              tipo: response.data[0].tipo,
            },
            deshabilitado: true,
          };
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    publicacion(row, index) {
      $("#modal-publicacion").modal("show");
      this.limpiarFormulario();
      axios
        .get("api/pedidoSiga/listarImprimir/" + row.id)
        .then((response) => {
          console.log(response.data);
          this.listarPedidosDetalle.data = response.data[0].detalle_pedido_siga;
          this.modalPublicacion = {
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
            },
            deshabilitado: true,
          };
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },
    editar(row, index) {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal = {
        titulo: "Editar grado",
        tipo: "editar",
        nivelID: row.id,
        grado: {
          grado: row.grado,
          id_nivel: row.id_nivel,
        },
        deshabilitado: false,
      };
    },
    guardar() {
      this.$validator.validateAll("form_registro").then((result) => {
        if (result) {
          axios
            .post("api/grado/crear", this.modal.grado)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-grado").modal("hide");
              this.listarPedido();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    guardarAgregarCurso() {
      this.$validator
        .validateAll("form_registro_grado_curso")
        .then((result) => {
          if (result) {
            axios
              .post("api/grado_curso/crear", this.modalImpresion.grado)
              .then((response) => {
                this.$toastr.s(response.data.message);
                this.listarPedidoCurso(this.modalImpresion.grado.id_grado);
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
            .put("api/grado/modificar/" + this.modal.nivelID, this.modal.grado)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-grado").modal("hide");
              this.listarPedido();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    eliminar(row, index) {
      this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
        //
        axios
          .put("api/grado/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarPedido();
      });
    },
    eliminarGradoCurso(row, index) {
      this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
        //
        axios
          .put("api/grado_curso/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
            this.listarPedidoCurso(row.id_grado);
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarPedido();
      });
    },
    publicar(row, index) {
      axios
        .put("api/grado/activar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = true;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
    },
    listarContenidoPeligroso() {
      this.listarPedidos.filtrosBusqueda.contenidoPeligroso = true;
      this.listarPedido();
    },
    obtenerTipo(row) {
      if (row.tipo == 1) return "Inicio";
      else if (row.tipo == 2) return "Pregunta";
      else if (row.tipo == 1) return "Publicación";
    },
    imprimir() {
      let tagContainer = document.getElementById("modal-imprimir");
      let popUp = window.open(" ", "popUp");
      popUp.document.write(tagContainer.innerHTML);
      popUp.document.close();

      setTimeout(function () {
        popUp.print();
        popUp.close();
      }, 1000);
    },
    exportar() {
      let url =
        process.env.MIX_APP_URL +
        "/exportar/ocupaciones" +
        Helper.getFilterURL(this.listarPedidos.filtrosBusqueda);
      window.open(url);
    },
  },
};
</script>
<style >
</style>
