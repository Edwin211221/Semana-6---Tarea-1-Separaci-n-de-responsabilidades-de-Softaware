const rutaOrdenTrabajo = "../../controllers/orden_trabajo.controller.php?op=";
const rutaVehiculos    = "../../controllers/vehiculos.controllers.php?op=";
const rutaUsuarios     = "../../controllers/usuario.controllers.php?op=";
const rutaClientes     = "../../controllers/clientes.controllers.php?op=";
const rutaTipoServicio = "../../controllers/tipo_servicio.controllers.php?op=";

let listaTiposServicio = [];
let listaUsuarios      = [];
let listaVehiculos     = [];
let listaClientes      = [];

/* =========================
   INIT
   ========================= */
function init() {
  $("#form_orden_trabajo").on("submit", GuardarEditarOrden);
  $("#btnAgregarItem").on("click", () => AgregarItemFila());
}

$(document).ready(async function () {
  await CargarCombosBase(); 
  CargaLista();
  AgregarItemFila();    
  init();
});

/* =========================
   LISTAR ORDENES
   ========================= */
function CargaLista() {
  $.get(rutaOrdenTrabajo + "todos", function (data) {
    if (!data) return;
    data = JSON.parse(data);

    let html = "";
    data.forEach((ot, i) => {
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${ot.fecha ?? ""}</td>
          <td>${ot.vehiculo ?? ""}</td>
          <td>${ot.usuario ?? ""}</td>
          <td>${ot.cantidad_items ?? 0}</td>
          <td>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                    data-bs-target="#ModalOrdenTrabajo"
                    onclick="editarOrden(${ot.idServicio})">
              Editar
            </button>
            <button class="btn btn-danger btn-sm" onclick="eliminarOrden(${ot.idServicio})">
              Eliminar
            </button>
          </td>
        </tr>
      `;
    });

    $("#ListaOrdenesTrabajo").html(html);
  });
}

/* =========================
   CARGAR COMBOS BASE
   ========================= */
async function CargarCombosBase() {
  await Promise.all([
    CargarUsuarios(),
    CargarVehiculos(),
    CargarClientes(),
    CargarTiposServicio()
  ]);
}

/* ---------- USUARIOS DEL SISTEMA (REGISTRA) ---------- */
function CargarUsuarios() {
  return $.get(rutaUsuarios + "todos", function (data) {
    data = JSON.parse(data || "[]");
    listaUsuarios = data;

    let html = `<option value="">Seleccione un usuario</option>`;
    listaUsuarios.forEach(u => {
      html += `<option value="${u.id}">${u.nombre_usuario}</option>`;
    });

    $("#id_usuario_servicio").html(html);
  });
}

/* ---------- VEHÍCULOS ---------- */
function CargarVehiculos() {
  $.ajax({
    url: rutaVehiculos + "todos",
    type: "GET",
    dataType: "json",
    success: function (data) {
      if (!data) data = [];
      listaVehiculos = data;

      let html = `<option value="">Seleccione un vehículo</option>`;
      $.each(listaVehiculos, (i, v) => {
        const cliente = ((v.nombres || "") + " " + (v.apellidos || "")).trim();
        const label = `${v.marca} ${v.modelo} (${v.anio})${cliente ? " - " + cliente : ""}`;
        html += `<option value="${v.id}">${label}</option>`;
      });

      $("#id_vehiculo").html(html);
    },
    error: function (xhr) {
      console.error("Error cargando vehículos:", xhr.responseText);
    }
  });
}


/* ---------- CLIENTES (PARA ÍTEMS) ---------- */
function CargarClientes() {
  return $.get(rutaClientes + "todos", function (data) {
    data = JSON.parse(data || "[]");
    listaClientes = data;
  });
}

/* ---------- TIPO SERVICIO (tiposervicio) ---------- */
function CargarTiposServicio() {
  return $.get(rutaTipoServicio + "todos", function (data) {
    data = JSON.parse(data || "[]");
    listaTiposServicio = data;
  });
}

/* =========================
   AGREGAR FILA DE ÍTEM
   ========================= */
function AgregarItemFila(item = null) {

  let opcionesTipo = `<option value="">Seleccione tipo de servicio</option>`;
  listaTiposServicio.forEach(t => {
    const sel = item && item.TipoServicio_Id == t.id ? "selected" : "";
    opcionesTipo += `<option value="${t.id}" ${sel}>${t.detalle}</option>`;
  });

  let opcionesClientes = `<option value="">Seleccione cliente</option>`;
  listaClientes.forEach(c => {
    const label = `${c.nombres} ${c.apellidos}`;
    const sel = item && item.Cliente_Id == c.id ? "selected" : "";
    opcionesClientes += `<option value="${c.id}" ${sel}>${label}</option>`;
  });

  const descripcion = item ? item.Descripcion : "";
  const fecha = item ? item.fecha : ($("#fecha_servicio").val() || "");

  const fila = `
    <tr>
      <td><input type="text" class="form-control descripcion-item" value="${descripcion}" placeholder="Descripción"></td>
      <td><select class="form-control tipo-servicio-item">${opcionesTipo}</select></td>
      <td><select class="form-control usuario-item">${opcionesClientes}</select></td>
      <td><input type="date" class="form-control fecha-item" value="${fecha}"></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarFilaItem(this)">X</button></td>
    </tr>
  `;

  $("#tbodyItemsOrden").append(fila);
}

function EliminarFilaItem(btn) {
  $(btn).closest("tr").remove();
}

/* =========================
   GUARDAR / ACTUALIZAR
   ========================= */
function GuardarEditarOrden(e) {
  e.preventDefault();

  const Form = new FormData($("#form_orden_trabajo")[0]);
  const idServicio = $("#idServicio").val() || 0;
  const accion = idServicio > 0 ? "actualizar" : "insertar";

  const items = [];
  $("#tbodyItemsOrden tr").each(function () {
    const descripcion = $(this).find(".descripcion-item").val();
    const tipo        = $(this).find(".tipo-servicio-item").val();
    const cliente     = $(this).find(".usuario-item").val();
    const fecha       = $(this).find(".fecha-item").val();

    if (descripcion && tipo && cliente) {
      items.push({
        descripcion: descripcion,
        tipo_servicio_id: tipo,
        usuario_id: cliente,
        fecha: fecha
      });
    }
  });

  if (items.length === 0) {
    alert("Debe ingresar al menos un ítem.");
    return;
  }

  Form.append("items", JSON.stringify(items));

  $.ajax({
  url: rutaOrdenTrabajo + accion,
  type: "POST",
  data: Form,
  contentType: false,
  processData: false,
  dataType: "json",
  success: (r) => {
    if (r && r.ok) {
      alert(r.mensaje || "Orden guardada con éxito");
      CargaLista();
      LimpiarFormularioOrden();
    } else {
      alert((r && r.mensaje) ? r.mensaje : "Error en el guardado");
    }
  },
  error: (xhr) => {
    console.error("RESPUESTA DEL SERVIDOR:", xhr.responseText);
    alert("Error del servidor:\n" + xhr.responseText);
  }
});
}

/* =========================
   EDITAR ORDEN
   ========================= */
function editarOrden(idServicio) {
  $.post(rutaOrdenTrabajo + "unoServicio", { idServicio }, function (resp) {
    const data = JSON.parse(resp);
    const srv = data.servicio;
    const items = data.items;

    $("#idServicio").val(srv.id);
    $("#id_vehiculo").val(srv.id_vehiculo);
    $("#id_usuario_servicio").val(srv.id_usuario);
    $("#fecha_servicio").val(srv.fecha_servicio);

    $("#tbodyItemsOrden").empty();
    items.forEach(it => AgregarItemFila(it));

    $("#ModalOrdenTrabajo").modal("show");
  });
}

/* =========================
   ELIMINAR ORDEN
   ========================= */
function eliminarOrden(idServicio) {
  if (!confirm("¿Desea eliminar esta orden?")) return;

  $.post(rutaOrdenTrabajo + "eliminar", { idServicio }, function (resp) {
    const r = JSON.parse(resp);
    alert(r.mensaje);
    if (r.ok) CargaLista();
  });
}

/* =========================
   LIMPIAR
   ========================= */
function LimpiarFormularioOrden() {
  $("#idServicio").val("");
  $("#id_vehiculo").val("");
  $("#id_usuario_servicio").val("");
  $("#fecha_servicio").val("");

  $("#tbodyItemsOrden").empty();
  AgregarItemFila();

  $("#ModalOrdenTrabajo").modal("hide");
}