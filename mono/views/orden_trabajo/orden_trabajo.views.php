<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">RegAsis /</span> Orden de Trabajo
</h4>

<!-- Listado de Órdenes de Trabajo -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Órdenes de Trabajo</h5>
        <button type="button" class="btn btn-outline-secondary"  
            data-bs-toggle="modal" data-bs-target="#ModalOrdenTrabajo">
            Nueva Orden de Trabajo
        </button>
    </div>

    <div class="card-body">
        <!-- Filtro por fecha (opcional para listar por fecha) -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filtro_fecha" class="form-label">Filtrar por fecha</label>
                <input type="date" id="filtro_fecha" class="form-control">
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="tablaOrdenesTrabajo">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Vehículo</th>
                        <th>Usuario</th>
                        <th>Cant. Ítems</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="ListaOrdenesTrabajo">
                    <!-- Se llena por JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Orden de Trabajo -->
<div class="modal fade" tabindex="-1" id="ModalOrdenTrabajo">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nueva Orden de Trabajo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_orden_trabajo" method="post">
                <input type="hidden" name="idServicio" id="idServicio">
                <input type="hidden" name="idOrdenTrabajo" id="idOrdenTrabajo">

                <div class="modal-body">
                    <!-- Datos del Servicio -->
                    <div class="card mb-3">
                        <div class="card-header">
                            Datos del Servicio
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="id_vehiculo" class="form-label">Vehículo</label>
                                    <select name="id_vehiculo" id="id_vehiculo" class="form-control" required>
                                        <option value="">Seleccione un vehículo</option>
                                        <option value="1">Mazda</option>
                                        <option value="2">Ford</option>

                                        
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_usuario_servicio" class="form-label">Usuario (quien registra)</label>
                                    <select name="id_usuario" id="id_usuario_servicio" class="form-control" required>
                                        <option value="">Seleccione un usuario</option>
                                        <!-- Se llena por JS -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_servicio" class="form-label">Fecha del Servicio</label>
                                    <input type="date" name="fecha_servicio" id="fecha_servicio" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ítems de la Orden de Trabajo -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Ítems de la Orden de Trabajo</span>
                            <button type="button" class="btn btn-sm btn-primary" id="btnAgregarItem">
                                Agregar Ítem
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" id="tablaItemsOrden">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItemsOrden">
                                        <!-- Filas dinámicas de ítems (JS) -->
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                Puede agregar varios ítems para la misma orden de trabajo. Cada ítem corresponde a un registro en la tabla <strong>Orden_Trabajo</strong>.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Orden de Trabajo</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>

<!-- Archivo JS para manejar Servicios + Órdenes de Trabajo -->
<script src="./orden_trabajo.js"></script>
