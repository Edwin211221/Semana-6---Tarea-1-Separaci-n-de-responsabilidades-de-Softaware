function init() {
  $("#form_tipo").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/tipo.controllers.php?op=";
$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (tipo) => {
    tipo = JSON.parse(tipo);
    $.each(tipo, (index, emp) => {
      html += `<tr>
                <td>${index + 1}</td>
                <td>${emp.Detalle}</td>     
    <td>
    <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalTipo" onclick='uno(${
      emp.IdTipoAcceso
    })'>Editar</button>
    <button class='btn btn-warning' onclick='eliminar(${
      emp.IdTipoAcceso
    })'>Eliminar</button>
                `;
    });
    $("#Listatipo").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var formData = new FormData($("#form_tipo")[0]);
  var accion = "";
  var IdTipoAcceso = document.getElementById("IdTipoAcceso").value;

  if (parseInt(IdTipoAcceso) > 0) {
    accion = ruta + "actualizar";
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
    success: (respuesta) => {
      console.log(respuesta);
      respuesta = JSON.parse(respuesta);
      if (respuesta == "ok") {
        alert("Se guardo con éxito");
        CargaLista();
        LimpiarCajas();
      } else {
        alert("no tu pendejada");
      }
    },
  });
};

var uno = async (IdTipoAcceso) => {
  $.post(ruta + "uno", { IdTipoAcceso: IdTipoAcceso }, (empleado) => {
    console.log(empleado);
    empleado = JSON.parse(empleado);
    document.getElementById("IdTipoAcceso").value = empleado.IdTipoAcceso;
    document.getElementById("Detalle").value = empleado.Detalle;
  });
};

var eliminar = (IdTipoAcceso) => {
  Swal.fire({
    title: "Tipos de Acceso",
    text: "Esta seguro que desea eliminar el registro",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(ruta + "eliminar", { IdTipoAcceso: IdTipoAcceso }, (empleado) => {
        console.log(empleado);
        empleado = JSON.parse(empleado);
        if (empleado == "ok") {
          Swal.fire({
            title: "Tipos de Acceso",
            text: "Se eliminó con éxito",
            icon: "success",
          });
          CargaLista();
          LimpiarCajas();
        } else {
          Swal.fire({
            title: "Tipos de Acceso",
            text: "El tipo de acceso posee registros asignados, no se puede eliminar al empleado",
            icon: "error",
          });
        }
      });
    }
  });
};

var LimpiarCajas = () => {
  document.getElementById("IdTipoAcceso").value = "";
  document.getElementById("Detalle").value = "";

  $("#ModalTipo").modal("hide");
};
init();
