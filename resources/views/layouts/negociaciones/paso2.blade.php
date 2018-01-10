<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario Paso 2 -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A. -->
<!-- ******************************************************************** -->

<md-content class="md-padding">
    <div class="container-fluid">
        <div class="col-sm-12">
            <!-- Informacion de la solicitud -->
                <div class="col-sm-4 sm-4-without-padding">
                  <ul class="list-group">
                    <!-- Numero de la negociacion -->
                        <li class="list-group-item">
                          <label>Negociacion No: </label> 
                        </li>
                    <!-- End numero de la negociacion -->
                    <!-- Periodo de facturacion -->
                        <li class="list-group-item">
                          <label>Periodo de Facturacion: </label>
                        </li>
                    <!-- End periodo de facturacion -->
                  </ul>
                </div>
                <div class="col-sm-4 sm-4-without-padding">
                  <ul class="list-group">
                    <!-- Cliente -->
                        <li class="list-group-item">
                          <label>Cliente: </label>
                        </li>
                    <!-- End cliente -->
                    <!-- Periodo de ejecucion -->
                        <li class="list-group-item">
                          <label>Periodo de Ejecución: </label>
                        </li>           
                    <!-- End periodo de ejecucion -->
                  </ul>
                </div>
                <div class="col-sm-4 sm-4-without-padding">
                  <ul class="list-group">
                    <!-- Negociacion para -->
                        <li class="list-group-item">
                          <label>Negociación Para: </label>
                        </li>
                    <!-- End negociacion para -->
                    <!-- Periodo de comparacion -->
                        <li class="list-group-item">
                          <label>Periodo de Comparación: </label>
                        </li>           
                    <!-- End periodo de comparacion -->
                  </ul>
                </div>
            <!-- End informacion de la solicitud -->
            
            <div class="col-sm-12">
                <hr>
            </div>

            <!-- Valor Negociacion cliente -->
            <div class="form-group col-sm-6">
                <label>Valor Negociación Cliente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.valorNegociacionCliente">
            </div>
            <!-- end valor negociacion cliente -->

            <!-- Gran total con adicionales -->
            <div class="form-group col-sm-6">
                <label>GRAN TOTAL con Adicionales:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.granTotalConAdicionales">
            </div>
            <!-- end gran total con adicionales -->

            <!-- Titulos -->
            <div class="col-sm-12">                
                <hr>
                <label style="color:red">Impuestos Calculados (Informativo)</label>
                <hr>
            </div>
            <!-- End titulos -->

            <!-- Iva -->
            <div class="form-group col-sm-6">
                <label>Iva:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.iva">
            </div>
            <!-- end Iva -->

            <!-- Subtotal Cliente -->
            <div class="form-group col-sm-6">
                <label>Subtotal Cliente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.subtotalCliente">
            </div>
            <!-- end Subtotal cliente -->

             <!-- Retencion en la fuente -->
            <div class="form-group col-sm-6">
                <label>Retención en la Fuente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.retefuente">
            </div>
            <!-- end retencion en la fuente -->

            <!-- ReteICA -->
            <div class="form-group col-sm-6">
                <label>ReteICA:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.reteica">
            </div>
            <!-- end ReteICA -->

            <!-- ReteIVA -->
            <div class="form-group col-sm-6">
                <label>ReteIVA:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.reteiva">
            </div>
            <!-- end ReteIVA -->

            <!-- Total Cliente Despues de Impuestos -->
            <div class="form-group col-sm-6">
                <label>Total Cliente Despues de Impuestos:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.totCliDespImpu">
            </div>
            <!-- end Total Cliente Despues de Impuestos -->

                <!-- clase negociacion -->
            <div class="form-group col-sm-6">
                <label>Forma de pago: 
                    <font color="red">*</font>
                </label>
                <select ng-model="objeto.formaPago" required class="form-control input-sm" ng-options="opt.cneg_descripcion for opt in claseNegociacion track by opt.id">
                        <option value="">Seleccione..</option>
                </select>                       
            </div>
        <!-- end clase negociacion -->  

            <!-- Botones -->
            <div class="col-sm-12">   
            	<br>                          
		        <div class="col-sm-6"></div>                                
                <div class="col-sm-6">
                    <!-- btn Save -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success btn-circle btn-lg  pull-right">
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
                            <button class="btn btn-primary btn-circle btn-lg  pull-right">
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