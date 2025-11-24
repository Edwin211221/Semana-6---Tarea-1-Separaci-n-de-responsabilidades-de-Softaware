<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php'); ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Vehículos</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Vehículos</h5>
        <button type="button" class="btn btn-primary" onclick="nuevo()">
            <i class="bx bx-plus"></i> Nuevo Vehículo
        </button>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Motor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="ListaVehiculos"></tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalVehiculos" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form_vehiculos" method="post">
                <input type="hidden" name="idVehiculo" id="idVehiculo">

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Cliente</label>
                        <select name="id_cliente" id="id_cliente" class="form-select" required></select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Año</label>
                            <input type="number" name="anio" id="anio" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tipo de Motor</label>
                            <select name="tipo_motor" id="tipo_motor" class="form-select">
                                <option value="dos_tiempos">Dos Tiempos</option>
                                <option value="cuatro_tiempos">Cuatro Tiempos</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php'); ?>
<script src="./vehiculos.js"></script>