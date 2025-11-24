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
    console.log(ListUsuarios);
    $.each(ListUsuarios, (index, usuario) => {
      html += `<tr>
            <td>${index + 1}</td>
            <td>${usuario.nombre_usuario}</td>
            <td>${usuario.nombre}</td>
<td>
<button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalUsuarios" onclick='uno(${
        usuario.id
      })'>Editar</button>
<button class='btn btn-danger' onclick='eliminar(${
        usuario.id
      })'>Eliminar</button>
      <button class='btn btn-warning' onclick='eliminarsuave(${
        usuario.id
      })'>Eliminar Suave</button>
           </td>
           </tr> `;
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
    DatosFormularioUsuario.append("id", SucursalId);
  } else {
    accion = ruta + "insertar";
  }

  for (var pair of DatosFormularioUsuario.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
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
  console.log(idUsuarios);
  await roles();
  $.post(ruta + "uno", { idUsuarios: idUsuarios }, (usuarios) => {
    usuarios = JSON.parse(usuarios);
    console.log(usuarios);
    document.getElementById("idUsuarios").value = usuarios.id;
    document.getElementById("NombreUsuario").value = usuarios.nombre_usuario;
    document.getElementById("contrasenia").value = usuarios.contrasenia;
    document.getElementById("id_rol").value = usuarios.id_rol;
  
  });
};


var roles = () => {

  return new Promise((resolve, reject) => {
    var html = `<option value="0">Seleccione una opción</option>`;
    $.post(
      "../../controllers/roles.controllers.php?op=todos",
      async (ListaRoles) => {
        ListaRoles = JSON.parse(ListaRoles);
        $.each(ListaRoles, (index, rol) => {
          html += `<option value="${rol.id}">${rol.nombre}</option>`;
        });
        await $("#id_rol").html(html);
        resolve();
      }
    ).fail((error) => {
      reject(error);
    });
  });
};

var eliminar = (idUsuarios) => {
  $.post(ruta + "eliminar", { idUsuarios: idUsuarios }, (respuesta) => {
    respuesta = JSON.parse(respuesta);
    if (respuesta == "ok") {
      alert("Se eliminó con éxito");
      CargaLista();
    } else {
      alert("Error al eliminar");
    }
  });
};
var eliminarsuave = (idUsuarios) => {
  $.post(ruta + "eliminarsuave", { idUsuarios: idUsuarios }, (respuesta) => {
    respuesta = JSON.parse(respuesta);
    if (respuesta == "ok") {
      alert("Se eliminó con éxito");
      CargaLista();
    } else {
      alert("Error al eliminar");
    }
  });
};
var LimpiarCajas = () => {
  document.getElementById("idUsuarios").value = "";
  document.getElementById("NombreUsuario").value = "";
  document.getElementById("contrasenia").value = "";
  $("#ModalUsuarios").modal("hide");
};



init();














