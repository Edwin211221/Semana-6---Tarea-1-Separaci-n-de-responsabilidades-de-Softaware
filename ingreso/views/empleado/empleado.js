function init() {
  $("#form_empleado").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/empleado.controllers.php?op=";
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
              <td>${emp.Nombres}</td>
              <td>${emp.Apellidos}</td>
              <td>${emp.Sucursal}</td>
              <td>${emp.Rol}</td>
              
  <td>
  <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalEmpleados" onclick='uno(${
    emp.EmpleadoId
  })'>Editar</button>
  <button class='btn btn-warning' onclick='eliminar(${
    emp.EmpleadoId
  })'>Eliminar</button>
              `;
    });
    $("#ListaUsuarios").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var formData = new FormData($("#form_empleado")[0]);
  var accion = "";
  var EmpleadoId = document.getElementById("EmpleadoId").value;

  if (parseInt(EmpleadoId) > 0) {
    accion = ruta + "actualizar";
    formData.append("EmpleadoId", EmpleadoId);
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

var uno = async (EmpleadoId) => {
  await sucursales();
  await roles();
  $.post(ruta + "uno", { EmpleadoId: EmpleadoId }, (empleado) => {
    console.log(empleado);
    empleado = JSON.parse(empleado);
    document.getElementById("EmpleadoId").value = empleado.EmpleadoId;
    document.getElementById("Cedula").value = empleado.Cedula;
    document.getElementById("Nombres").value = empleado.Nombres;
    document.getElementById("Apellidos").value = empleado.Apellidos;
    document.getElementById("Correo").value = empleado.Correo;
    document.getElementById("Direccion").value = empleado.Direccion;
    document.getElementById("Telefono").value = empleado.Telefono;
    document.getElementById("RolId").value = empleado.RolId;
    document.getElementById("SucursalId").value = empleado.SucursalId;
  });
};

var sucursales = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="0">Seleccione una opción</option>`;
    $.post(
      "../../controllers/sucursal.controllers.php?op=todos",
      async (ListaSucursales) => {
        ListaSucursales = JSON.parse(ListaSucursales);
        $.each(ListaSucursales, (index, sucursal) => {
          html += `<option value="${sucursal.SucursalId}">${sucursal.Nombre}</option>`;
        });
        await $("#SucursalId").html(html);
        resolve();
      }
    ).fail((error) => {
      reject(error);
    });
  });
};

var roles = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="0">Seleccione una opción</option>`;
    $.post(
      "../../controllers/rol.controllers.php?op=todos",
      async (ListaRoles) => {
        ListaRoles = JSON.parse(ListaRoles);
        $.each(ListaRoles, (index, rol) => {
          html += `<option value="${rol.idRoles}">${rol.Rol}</option>`;
        });
        await $("#RolId").html(html);
        resolve();
      }
    ).fail((error) => {
      reject(error);
    });
  });
};

var eliminar = (EmpleadoId) => {
  Swal.fire({
    title: "Empleados",
    text: "Esta seguro que desea eliminar el registro",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(ruta + "eliminar", { EmpleadoId: EmpleadoId }, (empleado) => {
        empleado = JSON.parse(empleado);
        if (empleado == "ok") {
          Swal.fire({
            title: "Empleados",
            text: "Se eliminó con éxito",
            icon: "success",
          });
          CargaLista();
          LimpiarCajas();
        } else {
          Swal.fire({
            title: "Empleados",
            text: "El empleado posee registros asignados, no se puede eliminar al empleado",
            icon: "error",
          });
        }
      });
    }
  });
};

var LimpiarCajas = () => {
  document.getElementById("EmpleadoId").value = "";
  document.getElementById("Cedula").value = "";
  document.getElementById("Nombres").value = "";
  document.getElementById("Apellidos").value = "";
  document.getElementById("Correo").value = "";
  document.getElementById("Direccion").value = "";
  document.getElementById("Telefono").value = "";

  $("#ModalEmpleados").modal("hide");
};
init();
