function init() {
  $("#form_vehiculos").on("submit", function (e) {
    GuardarEditar(e);
  });
}

const rutaVeh = "../../controllers/vehiculos.controllers.php?op=";
const rutaCli = "../../controllers/clientes.controllers.php?op=";

$(document).ready(() => {
  CargaLista();
  cargarClientes();
});

var CargaLista = () => {
  $.get(rutaVeh + "todos", (data) => {
    let lista = (typeof data === "string") ? JSON.parse(data) : data;

    let html = "";
    $.each(lista, (i, v) => {
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${v.cliente ?? "-"}</td>
          <td>${v.marca}</td>
          <td>${v.modelo}</td>
          <td>${v.anio}</td>
          <td>${(v.tipo_motor || "").replace("_", " ")}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="uno(${v.id})">Editar</button>
            <button class="btn btn-danger btn-sm" onclick="eliminar(${v.id})">Eliminar</button>
          </td>
        </tr>
      `;
    });

    $("#ListaVehiculos").html(html);
  });
};

// llena select de clientes
var cargarClientes = () => {
  $.get(rutaCli + "todos", (data) => {
    let lista = (typeof data === "string") ? JSON.parse(data) : data;

    let html = `<option value="">Seleccione un cliente</option>`;
    $.each(lista, (i, c) => {
      html += `<option value="${c.id}">${c.nombres} ${c.apellidos}</option>`;
    });

    $("#id_cliente").html(html);
  });
};

var nuevo = () => {
  $("#idVehiculo").val("");
  $("#form_vehiculos")[0].reset();
  $("#tituloModal").html("Nuevo Vehículo");
  $("#ModalVehiculos").modal("show");
};

var uno = (id) => {
  $.post(rutaVeh + "uno", { idVehiculo: id }, (data) => {
    let v = (typeof data === "string") ? JSON.parse(data) : data;

    $("#idVehiculo").val(v.id);
    $("#id_cliente").val(v.id_cliente);
    $("#marca").val(v.marca);
    $("#modelo").val(v.modelo);
    $("#anio").val(v.anio);
    $("#tipo_motor").val(v.tipo_motor);

    $("#tituloModal").html("Editar Vehículo");
    $("#ModalVehiculos").modal("show");
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();

  let datos = new FormData($("#form_vehiculos")[0]);
  let id = $("#idVehiculo").val();
  let accion = (id > 0) ? "actualizar" : "insertar";

  $.ajax({
    url: rutaVeh + accion,
    type: "post",
    data: datos,
    processData: false,
    contentType: false,
    success: (resp) => {
      let r = (typeof resp === "string") ? JSON.parse(resp) : resp;

      if (r.status === "ok") {
        alert("Guardado con éxito");
        $("#ModalVehiculos").modal("hide");
        $("#form_vehiculos")[0].reset();
        $("#idVehiculo").val("");
        CargaLista();
      } else {
        alert("Error al guardar");
        console.log(resp);
      }
    },
    error: (e) => {
      console.error(e);
      alert("Error de conexión");
    }
  });
};

var eliminar = (id) => {
  if (!confirm("¿Eliminar vehículo?")) return;

  $.post(rutaVeh + "eliminar", { idVehiculo: id }, (resp) => {
    let r = (typeof resp === "string") ? JSON.parse(resp) : resp;

    if (r.status === "ok") {
      alert("Vehículo eliminado");
      CargaLista();
    } else {
      alert("Error al eliminar");
    }
  });
};

init();