import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AddSupplierComponent } from './add-supplier/add-supplier.component';
import { EditSupplierComponent } from './edit-supplier/edit-supplier.component';
import { ViewSupplierComponent } from './view-supplier/view-supplier.component';

const routes: Routes = [
  { path: '', redirectTo: 'Dashboard', pathMatch: 'full' },
  { path: 'Dashboard', component: DashboardComponent },
  { path: 'view/supplier:supplierId', component: ViewSupplierComponent },
  { path: 'supplier/add', component: AddSupplierComponent },
  { path: 'supplier/edit:supplierId', component: EditSupplierComponent }
];

