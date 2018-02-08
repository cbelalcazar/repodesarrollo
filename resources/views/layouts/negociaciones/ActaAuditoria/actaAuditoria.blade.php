<!-- Html que genera el acta de aprobacion de auditoria -->
<html>
	<head>
		<style>
			*{
				font: 10px verdana, arial, helvetica, sans-serif;
			}
			.titulo_c{
				font-weight:bold;
				text-align:center;
			}
			.titulo_l{
				font-weight:bold;
				text-align:left;
			}
			#tabla_1{
				width:100%;
				border-collapse: collapse;
			}
			#tabla_1 td{
				border:solid black 1px;
			}
			#tabla_2{
				border:solid black 1px;
				width:100%;
				border-collapse: collapse;
			}
			.br_l{
				border-left:solid black 1px;
			}
			.br_r{
				border-right:solid black 1px;
			}
			.br_b{
				border-bottom:solid black 1px;
			}
			.br_t{
				border-top:solid black 1px;
			}
			.br_a{
				border:solid black 1px;
			}
			#tabla_fecha{
				border-collapse: collapse;
				width:100%;
				text-align:center;
			}
			#tabla_fecha td{
				border:solid black 1px;
			}
		</style>
	</head>
	<body>
		<table id="tabla_1">
			<tr>
				<td width="34%" rowspan="4">
					<img src="{{url('images/logo1.jpg')}}" width="200"/>
				</td>
				<td width="33%" rowspan="2" class="titulo_c">TESORERIA</td>
				<td width="33%" class="titulo_l">Código: TES-FOR-019</td>
			</tr>
			<tr>
				<td class="titulo_l">Edición: 01</td>
			</tr>
			<tr>
				<td rowspan="2" class="titulo_c">ACTA DE ENTREGA DE BONOS</td>
				<td class="titulo_l">Fecha de Emisión:  13-Nov-12</td>
			</tr>
			<tr>
				<td class="titulo_l">Página:  1 de 1</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table id="tabla_2">
			<tr id="cls">
				<td width="2%">&nbsp;</td>
				<td width="13.97%">&nbsp;</td>
				<td width="11.98%">&nbsp;</td>
				<td width="12.76%">&nbsp;</td>
				<td width="8.33%">&nbsp;</td>
				<td width="4.69%">&nbsp;</td>
				<td width="5.72%">&nbsp;</td>
				<td width="10.03%">&nbsp;</td>
				<td width="10.03%">&nbsp;</td>
				<td width="18.49%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" rowspan="3"> 
					<table id="tabla_fecha">
						<tr>
							<td colspan="3" class="titulo_c">FECHA DE ELABORACI&Oacute;N</td>
						</tr>
						<tr>
							<td width="33.3%" class="titulo_c">DD</td>
							<td width="33.3%" class="titulo_c">MM</td>
							<td width="33.3%" class="titulo_c">AA</td>
						</tr>
						<tr>
							<td>{{$fechaDia}}</td>
							<td>{{$fechaMes}}</td>
							<td>{{$fechaAno}}</td>
						</tr>
					</table>
				</td>
				<td colspan="3">&nbsp;</td>
				<td class="titulo_l">Ciudad: </td>
				<td colspan="2" class="br_b">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="7">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="7">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Yo,</td>
				<td colspan="6" class="br_a">&nbsp;</td>
				<td class="titulo_l">con CC No.</td>
				<td class="br_a">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Dirección</td>
				<td colspan="8" class="br_a">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Ciudad / Población</td>
				<td colspan="3" class="br_a">&nbsp;</td>
				<td class="titulo_l" colspan="3">Departamento</td>
				<td colspan="2" class="br_a">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Teléfono Fijo</td>
				<td colspan="3" class="br_a">&nbsp;</td>
				<td class="titulo_l" colspan="3">Teléfono Celular</td>
				<td colspan="2" class="br_a">&nbsp;</td>
				<td>&nbsp;</td></tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="10">Certifico que recibí de  la  Compañía  Belleza Express S.A:</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Bonos</td>
				<td class="br_a titulo_c">X</td>
				<td class="titulo_c">Valor</td>
				<td class="br_a titulo_l">&nbsp;</td>
				<td colspan="5">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Por concepto de:</td>
				<td class="br_a" colspan="8">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Período de pago:</td>
				<td class="br_a" colspan="8">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">Punto de venta:</td>
				<td class="br_a" colspan="8">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="10" class="titulo_l">RECIBI</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">FIRMA</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">NOMBRE</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">CARGO</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="10" class="titulo_l">FUNCIONARIO DE BELLEZA EXPRESS S.A.</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">FIRMA</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">NOMBRE</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="titulo_l">CARGO</td>
				<td colspan="3" class="br_b">&nbsp;</td>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>