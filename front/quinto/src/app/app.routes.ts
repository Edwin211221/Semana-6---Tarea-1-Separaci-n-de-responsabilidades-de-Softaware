import { Routes } from '@angular/router';
import { Empleado } from './empleado/empleado';

export const routes: Routes = [
    {
        path: 'empleados',
        component: Empleado,
        pathMatch: 'full'

    }
];
