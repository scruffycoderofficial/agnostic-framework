import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { WebApiService } from './web-api.service';

var apiUrl = "http://app.coolstuff.localhost";

var httpLinks = {
  suppliers: apiUrl + "/api/v1/suppliers",
  delete_supplier: apiUrl + "/api/employee/deleteEmployeeById",
  supplier_detail: apiUrl + "/api/employee/getEmployeeDetailById",
  create_supplier: apiUrl + "/api/employee/saveEmployee"
}

@Injectable({
  providedIn: 'root'
})

export class HttpProviderService {

  constructor(private webApiService: WebApiService) { }

  public getAllEmployee(): Observable<any> {
    return this.webApiService.get(httpLinks.suppliers);
  }

  public deleteEmployeeById(model: any): Observable<any> {
    return this.webApiService.post(httpLinks.delete_supplier + '?supplierId=' + model, "");
  }

  public getEmployeeDetailById(model: any): Observable<any> {
    return this.webApiService.get(httpLinks.supplier_detail + '?supplierId=' + model);
  }

  public saveEmployee(model: any): Observable<any> {
    return this.webApiService.post(httpLinks.create_supplier, model);
  }
}
