const ruta = "../../controllers/accesos.controllers.php?op=";
function init() {
  $("#frm_Observaciones").on("submit", (e) => {
    guardarObservaciones(e);
  });
}
$(document).ready(async function () {
  await cargarTablaAccesos();
  sucursales();
});

var fechas = () => {
  cargarTablaAccesos();
};
function cargarTablaAccesos() {
  var html = "";
  var fechainicio = document.getElementById("fechainicio").value;
  var fechafin = document.getElementById("fechafin").value;
  var formData = new FormData();
  formData.append("fechainicio", fechainicio);
  formData.append("fechafin", fechafin);
  formData.append("SucursalId", document.getElementById("SucursalId").value);

  $.ajax({
    url: "../../controllers/accesos.controllers.php?op=todos",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
  })
    .done(function (data) {
      console.log(data);

      if (data && data.length > 0) {
        $("#cuerpoTabla").empty();
        data = JSON.parse(data);
        var fechaActual = new Date();
        if (fechainicio !== "") {
          var year = fechainicio.split("-")[0];
          var month = fechainicio.split("-")[1];
        } else {
          var year = fechaActual.getFullYear();
          var month = fechaActual.getMonth() + 1;
        }

        var listaDiasMes = generarListaDiasMes(year, month);
        var empleadosUnicos = [...new Set(data.map((item) => item.empleados))];
        empleadosUnicos.forEach(function (empleado) {
          var sucursalEmpleado = obtenerSucursalEmpleado(data, empleado);

          listaDiasMes.forEach(function (fecha) {
            var empleadoId = obtenerEmpleadoIdPorNombreYsucursal(
              data,
              empleado,
              sucursalEmpleado
            );

            var resultado = obtenerResultadoPorFechaYEmpleado(
              data,
              fecha,
              empleado
            );

            if (resultado) {
              empId = resultado.EmpleadoId;
              var fila =
                `<tr>` +
                `<td>${resultado.sucursal}</td>` +
                `<td><a href="${resultado.imagen}" target="_blank">${resultado.empleados}</a></td>` +
                `<td>${resultado.fecha}</td>` +
                `<td>${resultado.nombreDiaSemana}</td>` +
                `<td>${resultado.horasFormateadas}:${resultado.minutosFormateados}</td>` +
                `<td>${resultado.acceso}</td>` +
                `<td>${resultado.observacion || ""}</td>` +
                `<td>${resultado.archivo || ""}</td>` +
                `<td style="display: none">${resultado.EmpleadoId}</td>` +
                `<td><button data-bs-toggle="modal" data-bs-target="#ModalObservaciones"  class='btn btn-primary' onclick="observaciones(${resultado.EmpleadoId},'${resultado.fecha}')">
                Agregar <br/> Observaciones </button>
               </td>` +
                `</tr>`;
              $("#cuerpoTabla").append(fila);
            } else {
              var nombreDiaSemanaVacio = obtenerNombreDiaSemana(
                new Date(fecha).getDay()
              );
              var filaVacia =
                `<tr>` +
                `<td>${sucursalEmpleado}</td>` +
                `<td>${empleado}</td>` +
                `<td>${fecha}</td>` +
                `<td>${nombreDiaSemanaVacio}</td>` +
                `<td></td>` +
                `<td></td>` +
                `<td></td>` +
                `<td></td>` +
                `<td style="display: none">${empleadoId}</td>` +
                `<td>
                <button data-bs-toggle="modal" data-bs-target="#ModalObservaciones" class='btn btn-primary' onclick="observaciones(${empleadoId},'${fecha}')">
                Agregar <br/> Observaciones </button>
               </td>` +
                `</tr>`;
              $("#cuerpoTabla").append(filaVacia);
            }
          });
        });
      } else {
        Swal.fire(
          "Consultorios Jurídicos UNIANDES",
          "No se encontraron registos",
          "danger"
        );
      }
    })
    .fail(function () {
      Swal.fire(
        "Consultorios Jurídicos UNIANDES",
        "Error al conectarse con la base de datos",
        "danger"
      );
    });
}

function cargarFaltasEmpleados() {
  var formData = new FormData();
  formData.append("fechainicio", document.getElementById("fechainicio").value);
  formData.append("fechafin", document.getElementById("fechafin").value);
  formData.append("SucursalId", document.getElementById("SucursalId").value);

  $.ajax({
    url: "../../controllers/faltas.controllers.php?op=todos",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
  })
    .done(function (dataFaltas) {
      console.log(dataFaltas);

      if (dataFaltas == "null") {
        Swal.fire(
          "Consultorios Jurídicos UNIANDES",
          "No se encontraron registos",
          "error"
        );
        return;
      }
      if (dataFaltas && dataFaltas.length > 0) {
        dataFaltas = JSON.parse(dataFaltas);
        $("#cuerpoTabla tr").each(function () {
          var fechaTabla = $(this).find("td:eq(3)").text().trim();
          var idEmpleado = $(this).find("td:eq(8)").text().trim();
          var acceso = $(this).find("td:eq(4)").text().trim();
          if (acceso === "") {
            var falta = dataFaltas.find(function (item) {
              if (item.Fecha === fechaTabla && item.EmpleadoId === idEmpleado) {
                return item;
              }
            });
            if (falta) {
              $(this)
                .find("td:eq(6)")
                .text(
                  falta.Observacion ? falta.Observacion : "No existe resgistos"
                );
              $(this)
                .find("td:eq(7)")
                .html(() => {
                  if (falta.archivo === "" || falta.archivo === undefined)
                    return "No existe resgistos";
                  else
                    return `<a href="${falta.archivo}" target="_blank">Archivo Adjunto</a>`;
                });
            } else {
              $(this).find("td:eq(6)").text("");
              $(this).find("td:eq(7)").text("");
              $(this).find("td:eq(8)").text("");
            }
          }
        });
      } else {
        Swal.fire(
          "Consultorios Jurídicos UNIANDES",
          "No se encontraron faltas de empleados",
          "error"
        );
      }
    })
    .fail(function () {
      Swal.fire(
        "Consultorios Jurídicos UNIANDES",
        "Error al conectarse con la base de datos",
        "error"
      );
    });
}

// Función para generar la lista de todos los días del mes
function generarListaDiasMes(year, month) {
  var diasMes = new Date(year, month, 0).getDate();
  var listaDias = [];
  for (var i = 1; i <= diasMes; i++) {
    var fecha =
      year +
      "-" +
      month.toString().padStart(2, "0") +
      "-" +
      i.toString().padStart(2, "0");
    listaDias.push(fecha);
  }
  return listaDias;
}

function obtenerResultadoPorFechaYEmpleado(data, fecha, empleado) {
  var fechaObjeto = new Date(fecha);
  var resultado = data.find(function (resultado) {
    var fechaResultado = new Date(resultado.fecha);
    return (
      fechaResultado.getFullYear() === fechaObjeto.getFullYear() &&
      fechaResultado.getMonth() === fechaObjeto.getMonth() &&
      fechaResultado.getDate() === fechaObjeto.getDate() &&
      resultado.empleados === empleado
    );
  });
  if (resultado) {
    var nombreDiaSemana = obtenerNombreDiaSemana(fechaObjeto.getDay());
    resultado.nombreDiaSemana = nombreDiaSemana;
    var [horas, minutos] = resultado.tiempo.split(":").map(Number);
    resultado.horasFormateadas = horas.toString().padStart(2, "0");
    resultado.minutosFormateados = minutos.toString().padStart(2, "0");
    var fechaFormateada = new Date(resultado.fecha).toLocaleDateString();
    resultado.fecha = fechaFormateada;
  }

  return resultado;
}

function obtenerNombreDiaSemana(numeroDia) {
  var diasSemana = [
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado",
  ];
  return diasSemana[numeroDia];
}
function obtenerEmpleadoIdPorNombreYsucursal(data, empleado, sucursal) {
  var empleadoInfo = data.find(function (item) {
    return item.empleados === empleado && item.sucursal === sucursal;
  });

  if (empleadoInfo) {
    return empleadoInfo.EmpleadoId;
  } else {
    return null;
  }
}
function obtenerSucursalEmpleado(data, empleado) {
  var empleadoInfo = data.find((item) => item.empleados === empleado);
  if (empleadoInfo) {
    return empleadoInfo.sucursal;
  } else {
    return "Sucursal no disponible";
  }
}

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

$("#exportar").on("click", function () {
  downloadExcelTable("reportes", "");
});

function downloadExcelTable(tableID, filename = "") {
  const linkToDownloadFile = document.createElement("a");
  const fileType = "application/vnd.ms-excel";
  const selectedTable = document.getElementById(tableID);

  // Clonar la tabla para manipularla sin afectar la original
  const clonedTable = selectedTable.cloneNode(true);

  // Eliminar las columnas 9 y 10 de la tabla clonada
  const rows = clonedTable.getElementsByTagName("tr");
  for (let i = 0; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName("td");
    if (cells.length > 9) {
      rows[i].removeChild(cells[9]); // Eliminar la columna 10 (índice 9)
    }
    if (cells.length > 8) {
      rows[i].removeChild(cells[8]); // Eliminar la columna 9 (índice 8)
    }
  }

  // Obtener el HTML de la tabla clonada
  const selectedTableHTML = clonedTable.outerHTML.replace(/ /g, "%20");

  // Generar el nombre de archivo
  var today = new Date();
  var formattedDate =
    today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
  var fileNameWithoutSpaces = "RegAsis_" + formattedDate + ".xls";
  filename = fileNameWithoutSpaces;

  document.body.appendChild(linkToDownloadFile);

  if (navigator.msSaveOrOpenBlob) {
    const myBlob = new Blob(["\ufeff", selectedTableHTML], {
      type: fileType,
    });
    navigator.msSaveOrOpenBlob(myBlob, filename);
  } else {
    linkToDownloadFile.href = "data:" + fileType + ", " + selectedTableHTML;
    linkToDownloadFile.download = filename;
    linkToDownloadFile.click();
  }
}

var observaciones = (empleadoId, Fecha) => {
  document.getElementById("EmpleadoId").value = empleadoId;
  document.getElementById("Fecha").value = Fecha;
  var formData = new FormData();
  formData.append("EmpleadoId", empleadoId);
  formData.append("Fecha", Fecha);

  $.ajax({
    url: "../../controllers/faltas.controllers.php?op=observaciones",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
  }).done((res) => {
    res = JSON.parse(res);
    if (res) {
      document.getElementById("Observacion").value = res.Observacion;
      $("#archivos_adjuntos").html(
        res.archivo === ""
          ? ""
          : `<hr><p>Se registra un documento cargado <a class='form-control' href='${res.archivo}' target='_blank'>Visualizar Archivo Adjunto</a></p>`
      );
      document.getElementById("FaltaId").value = res.FaltaId;
    }
  });
};

var guardarObservaciones = (e) => {
  e.preventDefault();
  var formData = new FormData($("#frm_Observaciones")[0]);
  var accion = "";
  $.ajax({
    url: "../../controllers/faltas.controllers.php?op=observaciones",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
  }).done((res) => {
    res = JSON.parse(res);
    if (
      res === null ||
      parseInt(res.FaltaId) === 0 ||
      res.FaltaId === undefined
    ) {
      accion = "../../controllers/faltas.controllers.php?op=insertar";
    } else {
      accion = "../../controllers/faltas.controllers.php?op=actualizar";
    }
    $.ajax({
      url: accion,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
    }).done((res) => {
      res = JSON.parse(res);
      if (res === "ok") {
        Swal.fire(
          "Consultorios Jurídicos UNIANDES",
          "Observación guardada",
          "success"
        );
        $("#frm_Observaciones")[0].reset();
        $("#archivos_adjuntos").html("");
        $("#ModalObservaciones").modal("hide");
        cargarTablaAccesos();
      } else {
        Swal.fire(
          "Consultorios Jurídicos UNIANDES",
          "Error al guardar la observación. Intente nuevamente",
          "error"
        );
        $("#frm_Observaciones")[0].reset();
        $("#archivos_adjuntos").html("");
        $("#ModalObservaciones").modal("hide");
      }
    });
  });
};

init();
