function init() {
  $("#form_clientes").on("submit", function (e) {
    GuardarEditar(e);
  });
}

const ruta = "../../controllers/clientes.controllers.php?op=";

$(document).ready(function () {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", function (lista) {
    lista = JSON.parse(lista);

    $.each(lista, function (i, c) {
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${c.nombres}</td>
          <td>${c.apellidos}</td>
          <td>${c.telefono ? c.telefono : '-'}</td>
          <td>${c.correo_electronico ? c.correo_electronico : '-'}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="uno(${c.id})">
              Editar
            </button>
            <button class="btn btn-danger btn-sm" onclick="eliminar(${c.id})">
              Eliminar
            </button>
          </td>
        </tr>`;
    });

    $("#ListaClientes").html(html);
  });
};

var nuevo = () => {
  $("#idCliente").val("");
  $("#form_clientes")[0].reset();
  $("#tituloModal").html("Nuevo Cliente");
  $("#ModalClientes").modal("show");
};

var uno = (id) => {
  $("#tituloModal").html("Editar Cliente");
  $.post(ruta + "uno", { idCliente: id }, function (data) {
    let c = JSON.parse(data);

    $("#idCliente").val(c.id);
    $("#nombres").val(c.nombres);
    $("#apellidos").val(c.apellidos);
    $("#telefono").val(c.telefono);
    $("#correo_electronico").val(c.correo_electronico);

    $("#ModalClientes").modal("show");
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();

  let datos = new FormData($("#form_clientes")[0]);
  let id = $("#idCliente").val();
  let accion = id > 0 ? "actualizar" : "insertar";

  $.ajax({
    url: ruta + accion,
    type: "post",
    data: datos,
    processData: false,
    contentType: false,
    cache: false,
    success: function (resp) {
      let r = JSON.parse(resp);

      if (r === "ok") {
        alert("Guardado con éxito");
        $("#ModalClientes").modal("hide");
        CargaLista();
        LimpiarCajas();
      } else {
        alert("Error al guardar: " + r);
      }
    },
    error: function (e) {
      console.error("Error AJAX", e);
      alert("Error de conexión con el servidor");
    },
  });
};

var eliminar = (id) => {
  if (!confirm("¿Eliminar cliente?")) return;

  $.post(ruta + "eliminar", { idCliente: id }, function (resp) {
    let r = JSON.parse(resp);
    if (r === "ok") {
      alert("Cliente eliminado");
      CargaLista();
    } else {
      alert("Error al eliminar: " + r);
    }
  });
};

var LimpiarCajas = () => {
  $("#idCliente").val("");
  $("#form_clientes")[0].reset();
};

init();