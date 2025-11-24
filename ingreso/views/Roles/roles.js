function init() {
  $("#form_roles").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/rol.controllers.php?op=";
$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (empleados) => {
    empleados = JSON.parse(empleados);
    $.each(empleados, (index, emp) => {
      html += `<tr>
                <td>${index + 1}</td>
                <td>${emp.Rol}</td>
    <td>
    <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalRoles" onclick='uno(${
      emp.idRoles
    })'>Editar</button>
    <button class='btn btn-warning' onclick='eliminar(${
      emp.idRoles
    })'>Eliminar</button>
                `;
    });
    $("#Roles").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var formData = new FormData($("#form_roles")[0]);
  var accion = "";
  var idRoles = document.getElementById("idRoles").value;

  if (parseInt(idRoles) > 0) {
    accion = ruta + "actualizar";
    formData.append("idRoles", idRoles);
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

var uno = async (idRoles) => {
  $.post(ruta + "uno", { idRoles: idRoles }, (empleado) => {
    empleado = JSON.parse(empleado);

    document.getElementById("idRoles").value = empleado.idRoles;
    document.getElementById("Rol").value = empleado.Rol;
  });
};

var eliminar = (idRoles) => {
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
      $.post(ruta + "eliminar", { idRoles: idRoles }, (empleado) => {
        console.log(empleado);
        empleado = JSON.parse(empleado);
        if (empleado == "ok") {
          Swal.fire({
            title: "Cargos",
            text: "Se eliminó con éxito",
            icon: "success",
          });
          CargaLista();
          LimpiarCajas();
        } else {
          Swal.fire({
            title: "Empleados",
            text:
              "El cargo posee registros asignados, no se puede eliminar al empleado" +
              empleado,
            icon: "error",
          });
        }
      });
    }
  });
};

var LimpiarCajas = () => {
  document.getElementById("idRoles").value = "";
  document.getElementById("Rol").value = "";

  $("#ModalRoles").modal("hide");
};
init();
