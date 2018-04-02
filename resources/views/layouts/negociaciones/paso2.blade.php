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
            <!-- Valor Negociacion cliente -->
            <div class="form-group col-sm-6">
                <label>Valor Negociación Cliente:</label>
                <input format="currency" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_valornego">
            </div>
            <!-- end valor negociacion cliente -->

            <!-- Gran total con adicionales -->
            <div class="form-group col-sm-6" ng-if="false">
                <label>GRAN TOTAL con Adicionales:</label>
                <input  format="currency" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_granvalor">
            </div>
            <!-- end gran total con adicionales -->

            <!-- Titulos -->
            <div class="col-sm-12">    
                <div class="alert alert-danger">
                    Impuestos Calculados (Informativo)
                </div> 
            </div>
            <!-- End titulos -->
            
            <div class="col-sm-6">
                <!-- Iva -->
                <div class="form-group col-sm-12">
                    <label>Iva:</label>
                    <input format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_iva">
                </div>
                <!-- end Iva -->

                <!-- Subtotal Cliente -->
                <div class="form-group col-sm-12">
                    <label>Subtotal Cliente:</label>
                    <input  format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_subtotalcliente">
                </div>
                <!-- end Subtotal cliente -->

                 <!-- Retencion en la fuente -->
                <div class="form-group col-sm-12">
                    <label>Retención en la Fuente:</label>
                    <input format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_retefte">
                </div>
                <!-- end retencion en la fuente -->

                <!-- ReteICA -->
                <div class="form-group col-sm-12">
                    <label>ReteICA:</label>
                    <input format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_reteica">
                </div>
                <!-- end ReteICA -->

                <!-- ReteIVA -->
                <div class="form-group col-sm-12">
                    <label>ReteIVA:</label>
                    <input format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_reteiva">
                </div>
                <!-- end ReteIVA -->

                <!-- Total Cliente Despues de Impuestos -->
                <div class="form-group col-sm-12">
                    <label>Total Cliente Despues de Impuestos:</label>
                    <input format="currency" style="text-align: right;" type="text" readonly class="form-control input-sm" ng-model="objCostos.soc_total">
                </div>
                <!-- end Total Cliente Despues de Impuestos -->
            </div>           
            <div class="col-sm-12">                
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

                <!-- clase negociacion -->
                <div class="form-group col-sm-6" ng-if="objCostos.soc_formapago.id == 3">
                    <label>Tipo de Bono: 
                        <font color="red">*</font>
                    </label>
                    <select ng-model="objCostos.soc_denominacionbono" required class="form-control input-sm" ng-options="opt.tib_descripcion for opt in tipoBono track by opt.tib_id">
                            <option value="">Seleccione..</option>
                    </select>                       
                </div>
                <!-- end clase negociacion -->  
            </div> 

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
                                    <th>Categoria</th>
                                    <th>Linea</th>
                                    <th>% part</th>
                                    <th>Costo en Nego</th>
                                    <th>Acción</th>
                                </tr>                                           
                            </thead>
                            <tbody>
                                <tr ng-if="arrayLineas.length == 0">
                                    <td colspan="6" style="text-align: center">Favor agregar al menos una linea...</td>
                                </tr>
                                <tr ng-repeat="(key, value) in arrayLineas">
                                    <td>@{{value.categorias.cat_txt_descrip}}</td>
                                    <td>@{{value.lin_txt_descrip}}</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" ng-model="value.porcentParti">
                                        </div>                                                      
                                    </td>
                                    <td>@{{value.CostoNegoLinea = calculaCostoNegoLinea(value) | currency : "$" : 2}}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-circle" ng-click="removeLinea(value)"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot ng-if="arrayLineas.length > 0">
                                <tr>
                                    <td colspan="2">Faltan &nbsp; @{{100 - sumPorcentPart()}}</td>
                                    <td>@{{sumPorcentPart()}}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
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
                        <div class="col-sm-8"></div>
                        <div class="col-sm-2">
                            <button  ng-click="siguiente='grabar.2'" type="submit" class="btn btn-success btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-floppy-save"></i>
                                <md-tooltip md-direction="left">GUARDAR</md-tooltip>
                            </button>
                        </div>                                  
                    <!-- end btn save -->
                    <!-- btn adelante -->
                        <div class="col-sm-2">
                            <button ng-click="siguiente='adelante.2'"  type="submit" class="btn btn-primary btn-circle btn-lg  pull-right">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                                <md-tooltip md-direction="left">GUARDAR Y CONTINUAR A LA PESTAÑA INFORMACIÓN DE OBJETIVOS</md-tooltip>
                            </button>
                        </div>                                      
                    <!-- end btn adelante -->
                </div>
		    </div>
		    <!-- End Botones -->                   

        </div>


        
          
    </div>
</md-content>