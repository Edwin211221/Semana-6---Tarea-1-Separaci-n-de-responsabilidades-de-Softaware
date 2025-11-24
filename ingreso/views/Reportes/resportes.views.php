<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<!-- Basic Bootstrap Table -->
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Reportes</h4>

<div class="card">


    <h5 class="card-header">Reportes</h5>
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                    <p class="mb-4">
                        <label for="inicio">Consultorio</label>
                        <select name="SucursalId" id="SucursalId" class="form-control"></select>
                    </p>
                    <p class="mb-4">
                        <label for="inicio">Fecha Inicial</label>
                        <input type="date" name="fechainicio" id="fechainicio" class="form-control">
                    </p>
                    <p class="mb-4">
                        <label for="inicio">Fecha Final</label>
                        <input type="date" name="fechafin" id="fechafin" class="form-control">
                    </p>

                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="fechas()">Buscar</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="exportar">Exportar Excel</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="cargarFaltasEmpleados()">Justificaciones</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table id="reportes" class="table">
            <thead>
                <tr>
                    <th>Sucursal</th>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Día</th>
                    <th>Tiempo</th>
                    <th>Acceso</th>

                    <th>Observación</th>
                    <th>Archivo</th>
                    <th style="display: none">EmpleadoId</th>
                    <th>Acciones</th>
                </tr>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="cuerpoTabla">

            </tbody>
        </table>
    </div>
</div>


<!-- Modal Usuarios-->

<div class="modal" tabindex="-1" id="ModalObservaciones">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="frm_Observaciones" method="post">
                <input type="hidden" name="EmpleadoId" id="EmpleadoId">
                <input type="hidden" name="Fecha" id="Fecha">
                <input type="hidden" name="FaltaId" id="FaltaId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nombres">Obsrvaciones</label>
                        <textarea type="text" name="Observacion" id="Observacion" class="form-control" placeholder="Ingrese las observaciones" require></textarea>
                    </div>
                    <div class="form-group" id="archivos_adjuntos">

                    </div>
                    <div class="form-group">
                        <label for="Nombres">Archivo</label>
                        <input type="file" name="archivo" id="archivo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<br>

<?php require_once('../html/scripts2.php') ?>

<script src="./reports.js"></script>

</script>