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
                <td>
                    @{{objObjetivos.soo_pecomini | date : 'dd-MM-yyyy'}} a @{{objObjetivos.soo_pecomfin  | date : 'dd-MM-yyyy'}} (@{{objObjetivos.soo_mese}} Meses)
                </td>
            </tr>
        </tbody>
    </table>
</div>