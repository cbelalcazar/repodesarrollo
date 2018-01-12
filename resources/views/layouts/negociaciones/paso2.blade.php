<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario Paso 2 -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A. -->
<!-- ******************************************************************** -->

<md-content class="md-padding">
    <div class="container-fluid">
        <div class="col-sm-12">
            <!-- Informacion de la solicitud -->
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="info">
                            <td>
                                <label>Negociacion No:</label>
                            </td>
                            <td>@{{objeto.sol_id}}</td>
                            <td>
                                <label>Cliente: </label>
                            </td>
                            <td>@{{objeto.sol_cli_id.razonSocialTercero_cli}}</td>
                            <td>
                                <label>Negociación Para: </label>
                            </td>
                            <td>@{{objeto.sol_tipocliente.npar_descripcion}}</td>
                        </tr>
                        <tr class="info">
                            <td>
                                <label>Periodo de Facturacion: </label>
                            </td>
                            <td>@{{objeto.sol_peri_facturaini | date : 'dd-MM-yyyy'}} a @{{objeto.sol_peri_facturafin | date : 'dd-MM-yyyy'}}  (@{{objeto.sol_mesesfactu}} Meses)</td>
                            <td>
                                <label>Periodo de Ejecución:  </label>
                            </td>
                            <td>@{{objeto.sol_peri_ejeini | date : 'dd-MM-yyyy'}} a @{{objeto.sol_peri_ejefin | date : 'dd-MM-yyyy'}} (@{{objeto.sol_meseseje}} Meses)</td>
                            <td>
                                <label>Periodo de Comparación: </label>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>            
            <!-- end Informacion de la solicitud -->
            <!-- Valor Negociacion cliente -->
            <div class="form-group col-sm-6">
                <label>Valor Negociación Cliente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_valornego" ng-value="arrayTipoNegociacion | map : 'stn_costo' | sum">
            </div>
            <!-- end valor negociacion cliente -->

            <!-- Gran total con adicionales -->
            <div class="form-group col-sm-6">
                <label>GRAN TOTAL con Adicionales:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_granvalor" ng-value="arrayTipoNegociacion | map : 'stn_costo' | sum">
            </div>
            <!-- end gran total con adicionales -->

            <!-- Titulos -->
            <div class="col-sm-12">    
                <div class="alert alert-danger">
                    Impuestos Calculados (Informativo)
                </div> 
            </div>
            <!-- End titulos -->

            <!-- Iva -->
            <div class="form-group col-sm-6">
                <label>Iva:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_iva" ng-value="calcularIva()">
            </div>
            <!-- end Iva -->

            <!-- Subtotal Cliente -->
            <div class="form-group col-sm-6">
                <label>Subtotal Cliente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_subtotalcliente" ng-value="calcularSubtotalCliente()">
            </div>
            <!-- end Subtotal cliente -->

             <!-- Retencion en la fuente -->
            <div class="form-group col-sm-6">
                <label>Retención en la Fuente:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_retefte" ng-value="calcularRetefuente()">
            </div>
            <!-- end retencion en la fuente -->

            <!-- ReteICA -->
            <div class="form-group col-sm-6">
                <label>ReteICA:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_reteica" ng-value="calcularReteIca()">
            </div>
            <!-- end ReteICA -->

            <!-- ReteIVA -->
            <div class="form-group col-sm-6">
                <label>ReteIVA:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_reteiva" ng-value="calcularReteIva()">
            </div>
            <!-- end ReteIVA -->

            <!-- Total Cliente Despues de Impuestos -->
            <div class="form-group col-sm-6">
                <label>Total Cliente Despues de Impuestos:</label>
                <input type="text" disabled readonly class="form-control input-sm" ng-model="objCostos.soc_total" ng-value="calcularSubtotalCliente() - calcularRetefuente() - calcularReteIca() - calcularReteIva()">
            </div>
            <!-- end Total Cliente Despues de Impuestos -->

                <!-- clase negociacion -->
            <div class="form-group col-sm-6">
                <label>Forma de Pago: 
                    <font color="red">*</font>
                </label>
                <select ng-model="objCostos.soc_formapago" required class="form-control input-sm" ng-options="opt.fpag_descripcion for opt in formaPago track by opt.id">
                        <option value="">Seleccione..</option>
                </select>                       
            </div>
            <!-- end clase negociacion -->  


            <!-- Lineas de negociaciones  -->
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Lineas de negociaciones
                    </div>
                    <div class="panel-body">
                        <!-- multiselect -->
                            <div class="col-sm-10">
                                <label>Seleccionar lineas:</label>
                                <multiselect ng-model="objeto.lineas" options="lineas" id-prop="lin_id" display-prop="lin_txt_descrip" show-select-all="true" show-unselect-all="true" show-search="true" placeholder="Seleccionar una sucursal..." labels="labelsLineas"></multiselect>
                            </div>
                            <div class="col-sm-2">
                                <label>&nbsp;</label><br>
                                <button class="btn btn-primary" type="button" ng-click="agregarLineas()"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                        <!-- end multiselect -->
                
                        <!-- tabla -->
                        <br><hr><br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sucursal</th>
                                    <th>% participacion</th>
                                    <th>Acción</th>
                                </tr>                                           
                            </thead>
                            <tbody>
                                <tr ng-if="arraySucursales.length == 0">
                                    <td colspan="3" style="text-align: center">Favor agregar al menos una sucursal..</td>
                                </tr>
                                <tr ng-repeat="(key, value) in arraySucursales">
                                    <td>@{{value.descripcionConId}}</td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button ng-click="agregarFaltante(value)" class="btn btn-success" type="button">
                                                    <i class="glyphicon glyphicon-refresh"></i>
                                                    <md-tooltip md-direction="left">Sumar Faltante</md-tooltip>
                                                </button>
                                            </span>
                                            <input type="number" min="0" string-to-number class="form-control" ng-model="value.porcentParti">
                                        </div>                                                      
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-circle" ng-click="removeSucursal(value)"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
            </div>
            <!-- End Sucursales -->


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