<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<!-- Basic Bootstrap Table -->
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Justificaciones / Faltas</h4>

<div class="card">

    <button type="button" class="btn btn-outline-secondary" onclick="sucursales();" data-bs-toggle="modal" data-bs-target="#ModalEmpleados">Nuevo Empleado</button>

    <h5 class="card-header">Justificaciones / Faltas</h5>
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">

                    <p class="mb-4">
                        <label for="inicio">Fecha Incial</label>
                        <input type="date" name="inicio" id="inicio" class="form-control">
                    </p>
                    <p class="mb-4">
                        <label for="inicio">Fecha Final</label>
                        <input type="date" name="fin" id="fin" class="form-control">
                    </p>
                    <p class="mb-4">
                        <label for="inicio">Consultorio</label>
                        <select name="SucursalId" id="SucursalId" class="form-control"></select>
                    </p>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="fechas()">Buscar</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportar()">Exportar Excel</button>
                </div>
            </div>

        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table id="reportes" class="table">
            <thead>
                <tr>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Tipo Acceso</th>
                    <th>Consultorio</th>
                    <th>Onservaciones</th>
                    <!-- Agrega más columnas según tu estructura de tabla -->
                </tr>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaUsuarios">

            </tbody>
        </table>
    </div>
</div>


<!-- Modal Usuarios-->

<div class="modal" tabindex="-1" id="ModalUsuarios">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_usuarios" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nombres">Obsrvaciones</label>
                        <textarea type="text" name="Nombres" id="Nombres" class="form-control" placeholder="Ingrese sus nombres" require></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Nombres">Archivo</label>
                        <input type="file" name="" id="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<br>

<table class="table table-bordered">
    <thead>
        <tr style="text-align: center;">
            <th colspan=9>
                REGISTRO DE ASISTENCIA - CONSULTORIO JURIDICO</th>
        </tr>
        <tr style="text-align: center;">
            <th colspan=9>&quot;UNIANDES&quot;</th>
        </tr>
        <tr>
            <th colspan=5>SEDE/EXTENSIÓN__________________</th>
            <th colspan=4>MES ______________ DE 2024</th>
        </tr>
        <tr>
            <th rowspan=2>N°</th>
            <th rowspan=2>APELLIDOS NOMBRES</th>
            <th rowspan=2>FECHA</th>
            <th>OFICINA</th>
            <th colspan=2 style="text-align: center;">ALMUERZO</th>
            <th>OFICINA</th>
            <th rowspan=3>OBSERVACIONES</th>
        </tr>
        <tr height=20>
            <th height=20 class=xl66 style='height:15.0pt;border-top:none;border-left:none'>ENTRADA</th>
            <th class=xl66 style='border-top:none;border-left:none'>SALIDA</th>
            <th class=xl66 style='border-top:none;border-left:none'>ENTRADA</th>
            <th class=xl66 style='border-top:none;border-left:none'>SALIDA</th>
        </tr>
    </thead>
    <tr height=40 style='mso-height-source:userset;height:30.0pt'>
        <th height=40 style='height:30.0pt'></th>
        <th colspan=3 class=xl69 width=287 style='width:215pt'>RESPONSABLE DEL REGISTRO</th>
        <th></th>
        <th colspan=3 class=xl70>COORDINADOR DE CONSULTORIO<span style='mso-spacerun:yes'> </span></th>
        <th></th>
    </tr>

</table>


<?php require_once('../html/scripts2.php') ?>

<script src="./reports.js"></script>

<!--

    <tr>
                    <th><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></th>
                    <th>Albert Cook</th>
                    <th>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </th>
                    <th><span class="badge bg-label-primary me-1">Active</span></th>
                    <th>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th><i class="fab fa-react fa-lg text-info me-3"></i> <strong>React Project</strong></th>
                    <th>Barry Hunter</th>
                    <th>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </th>
                    <th><span class="badge bg-label-success me-1">Completed</span></th>
                    <th>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>VueJs Project</strong></th>
                    <th>Trevor Baker</th>
                    <th>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </th>
                    <th><span class="badge bg-label-info me-1">Scheduled</span></th>
                    <th>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>
                        <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>Bootstrap Project</strong>
                    </th>
                    <th>Jerry Milton</th>
                    <th>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </th>
                    <th><span class="badge bg-label-warning me-1">Pending</span></th>
                    <th>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                            </div>
                        </div>
                    </th>
                </tr>

 -->