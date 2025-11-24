function init() {
  $("#form_tipo_servicio").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/tipo_servicio.controllers.php?op=";

$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (Lista_Servicios) => {
    Lista_Servicios = JSON.parse(Lista_Servicios);
    
    $.each(Lista_Servicios, (index, servicio) => {
      html += `<tr>
            <td>${index + 1}</td>
            <td>${servicio.detalle}</td>
            <td>${servicio.valor}</td>
<td>
<button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ModalTipo_Servicio" onclick='uno(${
        servicio.id
      })'>Editar</button>
<button class='btn btn-danger' onclick='eliminar(${
        servicio.id
      })'>Eliminar</button>
      <button class='btn btn-warning' onclick='eliminarsuave(${
        servicio.id
      })'>Eliminar Suave</button>
           </td>
           </tr> `;
    });
    $("#ListaUsuarios").html(html);
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioServicio = new FormData($("#form_tipo_servicio")[0]);
  var accion = "";
  var id = document.getElementById("idTipoServicio").value;

  if (id > 0) {
    accion = ruta + "actualizar";
    DatosFormularioServicio.append("idTipoServicio", id);
  } else {
    accion = ruta + "insertar";
  }


  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioServicio,
    processData: false,
    contentType: false, 
    cache: false,
    success: (respuesta) => {
     
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

var uno = async (idTipoServicio) => {
  $.post(ruta + "uno", { id_tipo_servicio: idTipoServicio }, (tipo_servicio) => {
    tipo_servicio = JSON.parse(tipo_servicio);
    console.log(tipo_servicio);
    document.getElementById("idTipoServicio").value = tipo_servicio.id;
    document.getElementById("detalle").value = tipo_servicio.detalle;
    document.getElementById("valor").value = tipo_servicio.valor;
    if (tipo_servicio.estado == 1) {
      document.getElementById("estado").checked = true;
    } else {
      document.getElementById("estado").checked = false;
    }
    updateEstadoLabel();
  });
};



var eliminar = (idTipoServicio) => {
  $.post(ruta + "eliminar", { idTipoServicio: idTipoServicio }, (respuesta) => {
    respuesta = JSON.parse(respuesta);
    if (respuesta == "ok") {
      alert("Se eliminó con éxito");
      CargaLista();
    } else {
      alert("Error al eliminar");
    }
  });
};
var eliminarsuave = (idTipoServicio) => {
  $.post(ruta + "eliminarsuave", { idTipoServicio: idTipoServicio  }, (respuesta) => {
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
  document.getElementById("idTipoServicio").value = "";
  document.getElementById("Detalle").value = "";
  document.getElementById("Valor").value = "";
  $("#ModalTipo_Servicio").modal("hide");
};

var updateEstadoLabel = () => {
  const estadoCheckbox = document.getElementById("estado");
  const estadoLabel = document.getElementById("lblEstado");

  if (estadoCheckbox.checked) {
    estadoLabel.textContent = "Activo";
  } else {
    estadoLabel.textContent = "No Activo";
  }
}

init();