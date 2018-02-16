<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario Paso 2 -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A. -->
<!-- ******************************************************************** -->

<md-content class="md-padding">
    <div class="container-fluid">
        <div class="col-sm-12">
            <!-- Informacion de la solicitud -->        
                @include('layouts.negociaciones.encabezadoNegociacion')
            <!-- end Informacion de la solicitud -->

            <!-- Periodo de facturacion -->
            <div>
                <!-- Titulo -->
                    <div class="col-sm-12">
                        <h5>
                            <strong>Periodo de Comparación: </strong>
                            <font color="red">*</font>
                        </h5>
                    </div>
                <!-- End titulo -->
                <!-- Periodo de facturación Desde -->
                    <div class="form-group col-sm-3">
                        <label>Inicio: </label>
                        <md-datepicker required ng-model="objObjetivos.soo_pecomini" md-placeholder="Enter date" ng-change="diffmesesComparacion()"></md-datepicker>                                           
                    </div>
                <!-- end Periodo de facturación Desde -->
                <!-- Periodo de facturación Hasta -->
                    <div class="form-group col-sm-3">
                        <label>Fin: </label>
                        <md-datepicker required ng-model="objObjetivos.soo_pecomfin" md-placeholder="Enter date"  ng-change="diffmesesComparacion()"></md-datepicker>                  
                    </div>
                <!-- end Periodo de facturación Hasta -->

                <!-- Periodo de facturación meses -->
                    <div class="form-group  col-sm-6">
                        <label class="control-label col-sm-2">Meses: </label>
                        <div class="col-sm-8"> 
                            <input required type="text" disabled readonly class="form-control input-sm" ng-model="objObjetivos.soo_mese">       
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary" type="button" ng-click="calcularObjetivos()">Calcular</button>
                        </div>
                    </div>
                <!-- end Periodo de facturación meses -->
            </div>
        <!-- End Periodo de facturacion -->

        <div class="col-sm-12">
            <div class="panel panel-danger">
                    <div class="panel-heading">
                        Datos de Evaluación
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Costo de la Negociación</label>
                                <input type="text" class="form-control" disabled  format="currency" ng-model="objObjetivos.soo_costonego">
                            </div>
                             <div class="form-group">
                                <label>Venta Promedio Mes Lineas Periodo Comparación</label>
                                <input type="text"  class="form-control" disabled format="currency" ng-model="objObjetivos.soo_venpromeslin">
                            </div>
                            <div class="form-group">
                                <label>Venta Estimada Lineas</label>
                                <input type="text"  class="form-control" format="currency" ng-model="objObjetivos.soo_venestlin">
                            </div>
                             <div class="form-group">
                                <label>Venta Marginal Lineas</label>
                                <input type="text"  class="form-control" disabled format="currency" ng-model="objObjetivos.soo_ventmargilin">
                            </div>
                        </div>
                        <div class="col-sm-6">
                             <div class="form-group">
                                <label>% de Inversion Sobre la Venta Estimada Lineas</label>
                                <input type="text" class="form-control" disabled ng-model="objObjetivos.soo_pinventaestiline">
                            </div>
                             <div class="form-group">
                                <label>Venta Promedio Mes Lineas a Activar (ultimos 6 meses)</label>
                                <input type="text"  class="form-control" disabled format="currency" ng-model="objObjetivos.soo_venprolin6m">
                            </div>
                            <div class="form-group">
                                <label>% Crecimiento Estimado Lineas</label>
                                <input type="text"  class="form-control" disabled ng-model="objObjetivos.soo_pcrelin">
                            </div>
                             <div class="form-group">
                                <label>% de Inversión sobre la Venta Marginal Lineas</label>
                                <input type="text"  class="form-control" disabled ng-model="objObjetivos.soo_pvenmarlin">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Datos Valores Adicionales
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Linea</td>
                                    <td>Valor Venta</td>
                                    <td>% Part.</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(key, value) in arrayLineas">
                                    <td>@{{value.lin_txt_descrip}}</td>
                                    <td>
                                        <input type="text" class="form-control" disabled="" format="currency" ng-model="value.scl_valorventa">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" disabled="" ng-model="value.scl_pvalorventa">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Datos Informativos total cliente
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Datos Informativos Total Cliente Venta Promedio Mes Total Cliente Periodo Comparación</label>
                                <input type="text" class="form-control" disabled  format="currency" ng-model="objObjetivos.soo_ventapromtotal" format="currency">
                            </div>
                             <div class="form-group">
                                <label><strong>Venta estimada del total cliente *</strong></label>
                                <input type="text"  class="form-control" required format="currency" ng-change="calcularCrecimientoEstimadoCliente()" ng-model="objObjetivos.soo_ventaestitotal">
                            </div>
                            <div class="form-group">
                                <label>Venta Marginal Cliente</label>
                                <input type="text"  class="form-control"  format="currency" disabled ng-model="objObjetivos.soo_ventamargi">
                            </div>
                        </div>
                        <div class="col-sm-6">
                             <div class="form-group">
                                <label> Venta Promedio Mes Total Cliente (ultimos 6 meses)</label>
                                <input type="text" class="form-control"  format="currency" disabled ng-model="objObjetivos.soo_ventapromseisme">
                            </div>
                             <div class="form-group">
                                <label>% Crecimiento Estimado cliente</label>
                                <input type="text"  class="form-control" disabled ng-model="objObjetivos.soo_pcreciestima">
                            </div>
                            <div class="form-group">
                                <label>% de Inversión sobre la Venta Estimada Total Cliente</label>
                                <input type="text"  class="form-control" disabled ng-model="objObjetivos.soo_pinverestima">
                            </div>
                             <div class="form-group">
                                <label>% de Inversión sobre la Venta Marginal Lineas</label>
                                <input type="text"  class="form-control" disabled ng-model="objObjetivos.soo_pinvermargi">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Datos Informativos lineas no incluidas
                    </div>
                    <div class="panel-body">
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label>Datos Informativos Líneas No Incluidas Venta 1 Mes Antes periodo Comparación</label>
                                <input type="text" class="form-control" format="currency" disabled ng-model="objObjetivos.soo_vemesantes">
                            </div>
                        </div>
                        <div class="col-sm-3">
                             <div class="form-group">
                                <label>Venta Promedio Mes Periodo Comparación</label>
                                <input type="text" class="form-control"  format="currency" disabled ng-model="objObjetivos.soo_veprome">
                            </div>
                        </div>
                        <div class="col-sm-3">
                             <div class="form-group">
                                <label>Venta 1 Mes Despues periodo Comparación</label>
                                <input type="text" class="form-control"  format="currency" disabled ng-model="objObjetivos.soo_vemesdespues">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control"  ng-model="objObjetivos.soo_observacion" rows="3"></textarea>
                    </div>
                </div>
        </div>
        
            

            <!-- Botones -->
            <div class="col-sm-12">   
            	<br>                          
		        <div class="col-sm-6"></div>                                
                <div class="col-sm-6">
                    <!-- btn Save -->
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <button  ng-click="siguiente='grabar.3'" type="submit" class="btn btn-success btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-floppy-save"></i>
                            </button>
                        </div>                                  
                    <!-- end btn save -->
                    <!-- btn Aprobacion -->
                        <div class="col-sm-6">
                            <button  ng-click="siguiente='elaboracion'" type="submit" class="btn btn-primary btn-lg  btn-circle pull-right">
                                <i class="glyphicon glyphicon-saved"></i>Enviar a Aprobar
                            </button>
                        </div>                                  
                    <!-- end btn save -->
                </div>
		    </div>
		    <!-- End Botones -->                   

        </div>


        
          
    </div>
</md-content>