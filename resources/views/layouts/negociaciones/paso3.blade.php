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
            

            <!-- Botones -->
            <div class="col-sm-12">   
            	<br>                          
		        <div class="col-sm-6"></div>                                
                <div class="col-sm-6">
                    <!-- btn Save -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-2">
                            <button  ng-click="siguiente='grabar.2'" type="submit" class="btn btn-success btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-floppy-save"></i>
                            </button>
                        </div>                                  
                    <!-- end btn save -->
                    <!-- btn cancelar -->
                        <div class="col-sm-2">
                            <button class="btn btn-danger btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        </div>                                      
                    <!-- end btn cancelar -->
                    <!-- btn adelante -->
                        <div class="col-sm-2">
                            <button ng-click="siguiente='adelante.2'"  type="submit" class="btn btn-primary btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>                                      
                    <!-- end btn adelante -->
                </div>
		    </div>
		    <!-- End Botones -->                   

        </div>


        
          
    </div>
</md-content>