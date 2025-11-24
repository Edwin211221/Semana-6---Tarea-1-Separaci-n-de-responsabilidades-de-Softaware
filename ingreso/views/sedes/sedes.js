function init() {
  $("#form_sedes").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/sucursal.controllers.php?op=";
$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (sedes) => {
    sedes = JSON.parse(sedes);
    console.log(sedes);
    $.each(sedes, (index, sede) => {
      html += `<tr>
                  <td>${index + 1}</td>
                  <td>${sede.Nombre}</td>
                  <td>${sede.Direccion}</td>
                  <td>${sede.Telefono}</td>
                  <td>${sede.Correo}</td>
      <td>
      <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalSedes" onclick='uno(${
        sede.SucursalId
      })'>Editar</button>
      <button class='btn btn-warning' onclick='eliminar(${
        sede.SucursalId
      })'>Eliminar</button>
                  `;
    });
    $("#ListaSedes").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var formData = new FormData($("#form_sedes")[0]);
  var accion = "";
  var SucursalId = document.getElementById("SucursalId").value;

  if (parseInt(SucursalId) > 0) {
    accion = ruta + "actualizar";
    formData.append("SucursalId", SucursalId);
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
        alert("Error al guardar");
      }
    },
  });
};

var uno = async (SucursalId) => {
  $.post(ruta + "uno", { SucursalId: SucursalId }, (sedes) => {
    sedes = JSON.parse(sedes);

    document.getElementById("SucursalId").value = sedes.SucursalId;
    document.getElementById("Nombre").value = sedes.Nombre;
    document.getElementById("Direccion").value = sedes.Direccion;
    document.getElementById("Telefono").value = sedes.Telefono;
    document.getElementById("Correo").value = sedes.Correo;
    document.getElementById("Parroquia").value = sedes.Parroquia;
    document.getElementById("Canton").value = sedes.Canton;
    document.getElementById("Provincia").value = sedes.Provincia;
  });
};

var eliminar = (SucursalId) => {
  Swal.fire({
    title: "Cargos",
    text: "Esta seguro que desea eliminar el registro",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(ruta + "eliminar", { SucursalId: SucursalId }, (empleado) => {
        console.log(empleado);
        empleado = JSON.parse(empleado);
        if (empleado == "ok") {
          Swal.fire({
            title: "Sedes",
            text: "Se eliminó con éxito",
            icon: "success",
          });
          CargaLista();
          LimpiarCajas();
        } else {
          Swal.fire({
            title: "Sedes",
            text:
              "La sede posee registros asignados, no se puede eliminar al empleado" +
              empleado,
            icon: "error",
          });
        }
      });
    }
  });
};

var LimpiarCajas = () => {
  document.getElementById("SucursalId").value = "";
  document.getElementById("Nombre").value = "";
  document.getElementById("Direccion").value = "";
  document.getElementById("Telefono").value = "";
  document.getElementById("Correo").value = "";
  document.getElementById("Parroquia").value = "";
  document.getElementById("Canton").value = "";
  document.getElementById("Provincia").value = "";

  $("#ModalSedes").modal("hide");
};
init();
