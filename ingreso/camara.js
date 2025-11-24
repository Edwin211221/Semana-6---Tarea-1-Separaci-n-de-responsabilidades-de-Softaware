$().ready(() => {
  accesos();
  document.getElementById("Cedula").focus();
});

var accesos = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="0">Seleccione una opción</option>`;
    $.post("controllers/tipo.controllers.php?op=todos", async (accesoss) => {
      accesoss = JSON.parse(accesoss);
      $.each(accesoss, (index, acc) => {
        html += `<option value="${acc.IdTipoAcceso}">${acc.Detalle}</option>`;
      });
      await $("#tipo").html(html);
      resolve();
    }).fail((error) => {
      reject(error);
    });
  });
};

document.addEventListener("DOMContentLoaded", function () {
  const video = document.getElementById("video");
  const captureButton = document.getElementById("captureButton");
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");
  const cedulaInput = document.getElementById("Cedula");
  const tipoSelect = document.getElementById("tipo");
  navigator.mediaDevices
    .getUserMedia({ video: true })
    .then(function (stream) {
      video.srcObject = stream;
    })
    .catch(function (error) {
      Swal.fir(
        "Consultorios Jurídicos <br/> UNIANDES",
        "Error al acceder a la cámara web: ",
        "danger"
      );
    });

  captureButton.addEventListener("click", function () {
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const imageData = canvas.toDataURL("image/png").split(",")[1];
    enviarImagenAlServidor(imageData);
  });

  function enviarImagenAlServidor(imageData) {
    var formulario = new FormData();
    formulario.append("Cedula", cedulaInput.value);
    formulario.append("tipo", tipoSelect.value);
    formulario.append("emplea", imageData);
    $.ajax({
      url: "controllers/empleado.controllers.php?op=unoCedula",
      type: "post",
      data: formulario,
      processData: false,
      contentType: false,
      cache: false,
    }).done(async (usuarioId) => {
      usuarioId = JSON.parse(usuarioId);
      formulario.append("usuariosId", usuarioId.EmpleadoId);
      $.ajax({
        url: "controllers/accesos.controllers.php?op=insertar",
        type: "post",
        data: formulario,
        processData: false,
        contentType: false,
        cache: false,
        success: (respuesta) => {
          respuesta = JSON.parse(respuesta);
          if (respuesta == "ok") {
            cedulaInput.value = "";
            Swal.fire(
              "Registro de Asistencia",
              "Se guardo con éxito",
              "success"
            );
          } else {
            Swal.fire(
              "Registro de Asistencia",
              "Hubo un error al guardar",
              "error"
            );
          }
        },
      });
    });
  }
  const loadingScreen = document.getElementById("loadingScreen");
  const loadingMessage = document.getElementById("loadingMessage");

  function mostrarCarga(mensaje) {
    loadingMessage.innerText = mensaje || "Cargando...";
    loadingScreen.style.display = "block";
  }

  function ocultarCarga() {
    loadingScreen.style.display = "none";
  }

  function ejecutarConsulta() {
    mostrarCarga("Verificando...");

    // Simula una operación asíncrona (reemplaza esto con tu consulta real)
    setTimeout(function () {
      $.post(
        "controllers/empleado.controllers.php?op=contarCedula",
        { Cedula: cedulaInput.value },
        (resultado) => {
          resultado = JSON.parse(resultado);

          if (parseInt(resultado.numero) > 0) {
            ocultarCarga();
          } else {
            Swal.fire(
              "Registro de Asistencia",
              "No se encontro el usuario",
              "error"
            );
            cedulaInput.value = "";
            ocultarCarga();
          }
        }
      );
    }, 2000); // Tiempo de espera de 2 segundos (reemplaza con tu lógica real)
  }

  // Asigna la función de ejecutarConsulta al evento onfocusout del input
  cedulaInput.addEventListener("focusout", ejecutarConsulta);
});
