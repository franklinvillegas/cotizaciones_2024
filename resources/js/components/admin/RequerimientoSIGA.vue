<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <h4 class="text-color-2 mb-3">Requerimientos SIGA</h4>
      </div>
      <br />
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
                @click.prevent="importar(props.row, props.index)"
                data-toggle="tooltip"
                title="Agregar"
              >
                Importar
              </button>
            </span>
          </template>
        </vue-good-table>
      </div>
      <!-- Modal Importar -->
      <template id="importar">
        <div
          class="modal fade"
          id="modal-importar"
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
                    v-text="modalImportar.titulo"
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
                  <form class="form" data-vv-scope="form_registro">
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
                    <div class="row">
                      <div class="form-group col-2">
                        <p class="m-0">
                          <strong>Nro. Cons: </strong>
                          <label v-text="modalImportar.data.consolidado"></label>
                        </p>
                      </div>
                      <div class="form-group col-4">
                        <p class="m-0"><strong>Fecha: {{ modalImportar.data.fecha_pedido }}</strong></p>
                      </div>
                      <div class="form-group col-6">
                        <p class="m-0">
                          <strong>Documento CMN: {{ modalImportar.data.nro_cmn }}</strong>
                        </p>
                      </div>
                      <div class="form-group col-12">
                        <p class="m-0">
                          <strong>CONCEPTO: </strong>{{ modalImportar.data.descripcion }}
                        </p>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <vue-good-table
                        :columns="listarPedidosDetalle.columns"
                        :rows="listarPedidosDetalle.data"
                        :line-numbers="true"
                        :sort-options="{
                          enabled: false,
                        }"
                      >
                      <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'especificaciones'">
                            <input type="text" class="form-control" v-model="props.row.especificaciones">
                        </span>
                    </template>
                      </vue-good-table>
                    </div>
                    <br />
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="guardar">
                  Guardar
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
    name: "RequerimientoSIGA",
    components: {},
    data() {
      return {
        listarPedidos: {
          data: [],
          columns: [
            { label: "Pedido", field: "nro_cmn" },
            { label: "Descripcion", field: "descripcion" },
            { label: "Tipo", field: "tipo" },
            { label: "Estado", field: "estadoDesc" },
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
            { label: "Item", field: "descripcion" },
            { label: "Especificaciones Técnicas", field: "especificaciones" },
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
        modalImportar: {
          tipo: "",
          titulo: "",
          data: "",
          detalles: {
            id: "",
            nro_cmn: "",
            descripcion: "",
            tipo: "",
            options: "",
          },
        },
      };
    },
    created() {
      this.listarPedido();
    },
    methods: {
      listarPedido() {
        axios
          .get(
            "api/requerimientoSiga/listar" +
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
      listarPedidoCurso(id_grado) {
        axios
          .get("api/grado_curso/listar/" + id_grado)
          .then((response) => {
            let data = response.data;
            console.log("sadasd", data);
            this.listarPedidoCursos.data = data;
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
      importar(row, index) {
        $("#modal-importar").modal("show");
        this.limpiarFormulario();
        axios
        .get("api/requerimientoSiga/listarDetalle/" + row.ano_eje + "/" + row.nro_cmn)
        .then((response) => {
          this.listarPedidosDetalle.data = response.data;
          console.log('detalle',this.listarPedidosDetalle)
          this.modalImportar = {
            titulo: "Importar requerimiento",
            tipo: "ver",
            data: row,
            detalle: response.data,
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
              .post("api/pedidoSiga/crear", this.modalImportar)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-importar").modal("hide");
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
      activar(row, index) {
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
  