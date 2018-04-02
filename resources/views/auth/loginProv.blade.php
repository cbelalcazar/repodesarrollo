<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link type="image/x-icon" href="favicon.ico" rel="icon"/>

	<title>Aplicativos Belleza Express S.A.</title>

	<!-- Styles -->
	<!--******************** CSS BOOTSTRAP 3.3.7 *********************-->
	<link href="{{url('/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
	<link href="{{url('/css/loginProv.css')}}" type="text/css" rel="stylesheet"/>
</head>
<body>
	<div id="page">
		<div class="col-md-12">  
			<img src="{{url('/images/bannerBesa.jpg')}}" alt="" class="img-fluid"><br><br>
		</div>
		<div class="col-md-12"> 
			<div class="page-inner">
				<nav class="gtco-nav" role="navigation">
					<div class="gtco-container">      
						<div class="row">
							<div class="col-xs-6 text-right menu-1">
								<ul>
									<li><a href="features.html">Ingreso</a></li>
									<li><a href="tour.html">Sobre</a></li>
									<li><a href="pricing.html">Contactenos</a></li>
									<li class="btn-cta"><a href="#"><span>Instructivo Certificados</span></a></li>
								</ul>
							</div>
						</div>

					</div>
				</nav>

				<header id="gtco-header" class="gtco-cover" role="banner" style="background-image: url({{url('/images/img_6.jpg')}})">
					<div class="overlay"></div>
					<div class="gtco-container">
						<div class="row">
							<div class="col-md-12 col-md-offset-0 text-left">


								<div class="row row-mt-15em">
									<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
										<span class="intro-text-small">Ingrese la siguiente información para acceder a los aplicativos</span>
										<h1>Bienvenido a <br> Belleza Express</h1> 
									</div>
									<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
										<div class="form-wrap">
											<div class="tab">
												<ul class="tab-menu">
													<li class="active gtco-first"><a href="#" data-tab="signup">Ingreso</a></li>
													<li class="gtco-second"><a href="#" data-tab="login">Registro</a></li>
												</ul>
												<div class="tab-content">
													<div class="tab-content-inner active" data-content="signup">
														{!! Form::open(['url' => 'login', 'method' => 'post', 'role' => 'form']) !!}
														 	@if ($errors->has('login'))
											                  <div class="form-group has-error">
											                    <span class="help-block">
											                      <strong>{{ $errors->first('login') }}</strong>
											                    </span>
											                  </div>
											                @endif
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">NIT Empresa <span style="color:red">*</span></label>
																	{{ Form::text('nit', old('nit'), ['class' => 'form-control', 'required' => '', 'autofocus' => '']) }}
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="cedula">Cedula <span style="color:red">*</span></label>
																	{{ Form::text('cedula', old('cedula'), ['class' => 'form-control', 'required' => '', 'autofocus' => '']) }}
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="password">Contraseña <span style="color:red">*</span></label>
																	{{ Form::password('password', ['class' => 'form-control', 'required' => '']) }}
																</div>
															</div>

															<div class="row form-group">
																<div class="col-md-12">
																	<input type="submit" class="btn btn-primary" value="Continuar">
																	<input type="submit" class="btn btn-succsess" value="Cancelar">
																</div>
															</div>
														{!! Form::close() !!}
													</div>

													<div class="tab-content-inner" data-content="login">
														<form action="#">
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">NIT:</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Nombre Compañía:</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<h4><strong>Contacto</strong></h4>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Numero de Identificacion:</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Nombre y Apellido:</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Cargo:</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Correo Electronico</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>
															<div class="row form-group">
																<div class="col-md-12">
																	<label for="username">Numero de Telefono</label>
																	<input type="text" class="form-control" id="username">
																</div>
															</div>

														
															<div class="row form-group">
																<div class="col-md-12">
																	<input type="submit" class="btn btn-primary" value="Continuar">
																	<input type="submit" class="btn btn-succsess" value="Cancelar">
																</div>
															</div>
														</form> 
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>   
							</div>
						</div>
					</div>
				</header>

				<div class="gtco-section border-bottom">
					<div class="gtco-container">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6">
								<a href="images/arruru.png" class="fh5co-project-item image-popup">
									<figure>
										<div class="overlay"><i class="ti-plus"></i></div>
										<img src="images/arruru.png" alt="Image" class="img-responsive" style="width:100% !important" >
									</figure>
									<div class="fh5co-text">
										<h2>ARRURRÚ</h2>
										<p>Arrurú sabe de bebés. Línea completa y confiable de productos que cuidad y protegen a tu bebé naturalmente <br><br></p>
									</div>
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6">
								<a href="images/aromasense.jpg" class="fh5co-project-item image-popup">
									<figure>
										<div class="overlay"><i class="ti-plus"></i></div>
										<img src="images/aromasense.jpg" alt="Image" class="img-responsive" style="width:100% !important" >
									</figure>
									<div class="fh5co-text">
										<h2>Aromasense</h2>
										<p>Completa línea de productos de baño y cuerpo, con deliciosas fragancias que brindan bienestar y dejan tu piel perfumada y humectada</p>
									</div>
								</a>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-6">
								<a href="images/barbie.jpg" class="fh5co-project-item image-popup">
									<figure>
										<div class="overlay"><i class="ti-plus"></i></div>
										<img src="images/barbie.jpg" alt="Image" class="img-responsive" style="width:100% !important" >
									</figure>
									<div class="fh5co-text">
										<h2>Barbie</h2>
										<p>Con todo el estilo Barbie, elaborados con suaves y delicados componentes que te cuidan, y te ayudan a lucir expectacular. <br><br></p>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>


				<footer id="gtco-footer" role="contentinfo">
					<div class="gtco-container">
						<div class="row row-p b-md">

							<div class="col-md-6">
								<div class="gtco-widget">
									<h3>Quíenes Somos</span></h3>
									<p>Belleza Express S.A. fue creada en 1990 y hoy es conocida como una de las más grandes y prestigiosas compañías dentro de la Categoría de productos de Salud y Belleza. <br><br>Comercializa sus productos a través de todos los canales de distribución como: Hipermercados, supermercados, droguerías, farmacias, proveedores de productos para la salud, distribuidores y vendedores.
									</p>
								</div>
							</div>

							<div class="col-md-6">
								<div class="gtco-widget">
									<h3>Contactenos</h3>
									<ul class="gtco-quick-contact">
										<li><a href="#"><i class="icon-phone"></i>Línea Gratuita 01 8000 94 4444</a></li>
										<li><a href="#"><i class="icon-mail2"></i> Calle 36 no. 134 - 201 Km. 6 vía Jamundí, Cali - Colombia.</a></li>
									</ul>
								</div>
							</div>

						</div>

						<div class="row copyright">
							<div class="col-md-12">
								<p class="pull-left">
									<small class="block">&copy; 2018 Belleza Express S.A.</small> 
								</p>
								<p class="pull-right">
									<ul class="gtco-social-icons pull-right">
										<li><a href="#"><i class="icon-twitter"></i></a></li>
										<li><a href="#"><i class="icon-facebook"></i></a></li>
										<li><a href="#"><i class="icon-linkedin"></i></a></li>
										<li><a href="#"><i class="icon-dribbble"></i></a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>

</div>
<script src="{{url('/lib/jquery.min.js')}}" type="text/javascript" language="javascript"></script> <script src="{{url('/lib/jquery.waypoints.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/main.js')}}" type="text/javascript" language="javascript"></script>


</body>
</html>
