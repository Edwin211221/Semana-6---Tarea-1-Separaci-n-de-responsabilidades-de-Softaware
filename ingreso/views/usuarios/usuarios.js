function init() {
  $("#form_usuarios").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/usuario.controllers.php?op=";
$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (ListUsuarios) => {
    ListUsuarios = JSON.parse(ListUsuarios);
    $.each(ListUsuarios, (index, usuario) => {
      html += `<tr>
            <td>${index + 1}</td>
            <td>${usuario.Nombres}</td>
            <td>${usuario.Apellidos}</td>
            <td>${usuario.Rol}</td>
<td>
<button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalUsuarios" onclick='uno(${
        usuario.idUsuarios
      })'>Editar</button>
<button class='btn btn-warning' click='eliminar(${
        usuario.idUsuarios
      })'>Editar</button>
           </td></tr> `;
    });
    $("#ListaUsuarios").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioUsuario = new FormData($("#form_usuarios")[0]);
  var accion = "";
  var SucursalId = document.getElementById("idUsuarios").value;

  if (SucursalId > 0) {
    accion = ruta + "actualizar";
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioUsuario,
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

var uno = async (idUsuarios) => {
  await sucursales();
  await roles();
  $.post(ruta + "uno", { idUsuarios: idUsuarios }, (usuarios) => {
    usuarios = JSON.parse(usuarios);
    console.log(usuarios);
    document.getElementById("idUsuarios").value = usuarios.idUsuarios;
    document.getElementById("Cedula").value = usuarios.Cedula;
    document.getElementById("Nombres").value = usuarios.Nombres;
    document.getElementById("Apellidos").value = usuarios.Apellidos;
    document.getElementById("Correo").value = usuarios.Correo;
    document.getElementById("contrasenia").value = usuarios.contrasenia;
    document.getElementById("RolId").value = usuarios.idRoles;
    document.getElementById("SucursalId").value = usuarios.SucursalId;
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

var eliminar = () => {};

var LimpiarCajas = () => {
  document.getElementById("idUsuarios").value = "";
  document.getElementById("Cedula").value = "";
  document.getElementById("Nombres").value = "";
  document.getElementById("Apellidos").value = "";
  document.getElementById("Correo").value = "";
  document.getElementById("contrasenia").value = "";
  $("#ModalUsuarios").modal("hide");
};
init();
