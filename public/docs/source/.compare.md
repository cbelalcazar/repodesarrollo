---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#TOrigenMercanciaController

Controlador creado para el crud de origen de la mercancia

Creado por Carlos Belalcazar

Analista desarrollador de software Belleza Express

22/02/2017
<!-- START_83552744cc49d5220336b3cca4e1be2f -->
## index
Funcion que consulta todos los origenes de la mercancia y los retorna a la vista resource/views/importacionesv2/index.blade.php

1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
2 -  Asigno variable $datos con la consulta de todos los registros de la tabla t_origen mercancia <br>
3 -  Asigno la variable $titulosTabla con un array donde cada posicion hace referencia a un titulo de columna de la tabla a mostrar, siempre al final le pongo las acciones editar y eliminar los demas campos son los mismos del array $campos <br>
4 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en la tabla lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array <br>
5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>

Return: retornar una vista con una lista de todas los origenes de la mercancia

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET importacionesv2/OrigenMercancia`

`HEAD importacionesv2/OrigenMercancia`


<!-- END_83552744cc49d5220336b3cca4e1be2f -->
<!-- START_0ea1d90bec19a26e51f856d4569b519e -->
## create
Funcion que muestra el formulario de creacion resource/views/importacionesv2/create.blade.php

1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
2 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
3 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
4 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador

Return: Debe retornar una vista con un formulario de creacion con los campos para la orden de importacion

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/OrigenMercancia/create`

`HEAD importacionesv2/OrigenMercancia/create`


<!-- END_0ea1d90bec19a26e51f856d4569b519e -->
<!-- START_8379980f1eb2c91d902513f8dbe8f599 -->
## store
Funcion que se encarga de guardar la informacion del formulario de creacion y redireccionar al index

1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
2 -  Valida que no exista ningun registro con el mismo ormer nombre en la tabla t_origen_mercancia, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
3 -  Crea un registro en la tabla t_origen_mercancia <br>
4 -  Borra la variable de cache <br>
5 -  Redirecciona a la pagina de consulta y muestra un mensaje de exito <br>

Return: Debe retornar un mensaje de exito en caso de que se cree correctamente o un mensaje e error si encuentra un registro con el mismo ormer_nombre

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/OrigenMercancia`


<!-- END_8379980f1eb2c91d902513f8dbe8f599 -->
<!-- START_d6f79c487473898c4722417cbaa3e43f -->
## show

Funcion resource no usada

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/OrigenMercancia/{OrigenMercancium}`

`HEAD importacionesv2/OrigenMercancia/{OrigenMercancium}`


<!-- END_d6f79c487473898c4722417cbaa3e43f -->
<!-- START_c78d7bf890003c8fda8a46b2f4ee1f7b -->
## create
Funcion que muestra el formulario de editar resource/views/importacionesv2/edit.blade.php

1 -  Asigno la variable id con el parametro id del origen de la mercancia que deseo editar <br>
2 -  Consulto el objeto que deseo editar <br>
3 -  Creo un array donde cada posicion hace referencia a un campo de la tabla t_origen_mercancia, el cual quiero mostrar en el formulario de creacion. <br>
4 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
6 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador <br>
7 -  Asigno el string que hace referencia al name de la ruta update <br>

Return: Debe retornar una vista con un formulario para editar un registro de origen mercancia

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/OrigenMercancia/{OrigenMercancium}/edit`

`HEAD importacionesv2/OrigenMercancia/{OrigenMercancium}/edit`


<!-- END_c78d7bf890003c8fda8a46b2f4ee1f7b -->
<!-- START_6e06f0542652fa1fa732c99a32b43c6d -->
## update
Funcion que edita el registro en la tabla origen mercancia

1 -  Asigna a la variable $url la url de consulta <br>
2 -  Obtengo el objeto de origen mercancia que deseo editar <br>
3 -  Consulto en la tabla t_origen_mercancia si existe algun registro con el mismo ormer nombre, en caso de encontrar alguno redirecciona a la funcion edit y retorna el error <br>
4 -  Edita el registro de la tabla <br>
5 -  Borra la cache del string origenmercancia <br>
6 -  Redirecciona a vista de consulta <br>

Return: debe retornar exito en caso de haber hecho update sobre el registro, o error en caso de que el origen de la mercancia tenga el mismo ormer_nombre que otro

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/OrigenMercancia/{OrigenMercancium}`

`PATCH importacionesv2/OrigenMercancia/{OrigenMercancium}`


<!-- END_6e06f0542652fa1fa732c99a32b43c6d -->
<!-- START_a548dd8577a451356ded1ac0eba7545a -->
## destroy

Hace un softdelete sobre el objeto de origen mercancia cuyo id coincida con el enviado a traves del parametro de la funcion

1 -  Asigna el objeto de origen mercancia cuyo $id coincida con el enviado a traves del parametro de la funcion a la variable $ObjectDestroy  <br>
2 -  Borra el objeto $ObjectDestroy <br>
3 -  Asigna la url completa a la variable $url <br>
4 -  Borra la cache del string origenmercancia <br>
5 -  Redirecciona a la url <br>

Return: Retorna mensaje de exito una ves elimina el origen de la mercancia

> Example request:

```bash
curl "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/OrigenMercancia/{OrigenMercancium}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/OrigenMercancia/{OrigenMercancium}`


<!-- END_a548dd8577a451356ded1ac0eba7545a -->
#TProductoController

Controlador creado para el crud de producto

Creado por Carlos Belalcazar

Analista desarrollador de software Belleza Express

22/02/2017
<!-- START_5d99b0381d8d39f65998e5194e79516c -->
## index
Funcion que consulta todos los origenes de la mercancia y los retorna a la vista resource/views/importacionesv2/index.blade.php

1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
2 -  Asigno variable $datos con la consulta de todos los registros de la tabla t_producto <br>
3 -  Asigno la variable $titulosTabla con un array donde cada posicion hace referencia a un titulo de columna de la tabla a mostrar, siempre al final le pongo las acciones editar y eliminar los demas campos son los mismos del array $campos <br>
4 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en la tabla lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array <br>
5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>

Return: retornar una vista con una lista de todas los productos

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Producto`

`HEAD importacionesv2/Producto`


<!-- END_5d99b0381d8d39f65998e5194e79516c -->
<!-- START_d58fa3f3e3427d665a194f1fcae334cf -->
## create
Funcion que muestra el formulario de creacion resource/views/importacionesv2/create.blade.php

1 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
2 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
3 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
4 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador

Return: Debe retornar una vista con un formulario de creacion con los campos para productos

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Producto/create`

`HEAD importacionesv2/Producto/create`


<!-- END_d58fa3f3e3427d665a194f1fcae334cf -->
<!-- START_c589d6718b8b3eafc226b672d04c988e -->
## store
Funcion que se encarga de guardar la informacion del formulario de creacion y redireccionar al index

1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
2 -  Valida que no exista ningun registro con el mismo prod_referencia en la tabla t_producto, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
3 -  Crea un registro en la tabla t_producto <br>
4 -  Redirecciona a la pagina de consulta y muestra un mensaje de exito <br>

Return: Debe retornar un mensaje de exito en caso de que se cree correctamente o un mensaje e error si encuentra un registro con el mismo prod_referencia

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Producto`


<!-- END_c589d6718b8b3eafc226b672d04c988e -->
<!-- START_be05302ee46907bdd8d05914383ee7b1 -->
## show

Funcion resource no usada

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto/{Producto}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto/{Producto}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Producto/{Producto}`

`HEAD importacionesv2/Producto/{Producto}`


<!-- END_be05302ee46907bdd8d05914383ee7b1 -->
<!-- START_7f937ee7b1b9c66e60141fd6e74fbf7a -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto/{Producto}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto/{Producto}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Producto/{Producto}/edit`

`HEAD importacionesv2/Producto/{Producto}/edit`


<!-- END_7f937ee7b1b9c66e60141fd6e74fbf7a -->
<!-- START_811a3aff5b97883a2f618adaf520e316 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto/{Producto}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto/{Producto}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Producto/{Producto}`

`PATCH importacionesv2/Producto/{Producto}`


<!-- END_811a3aff5b97883a2f618adaf520e316 -->
<!-- START_7d498611ed1d0336ad1420ceea148845 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Producto/{Producto}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Producto/{Producto}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Producto/{Producto}`


<!-- END_7d498611ed1d0336ad1420ceea148845 -->
<!-- START_cf9be30afad9148fc417bd9c86bb072d -->
## Productoajax
Funcion que muestra el formulario de creacion cargado a traves de ajax en un modal de la vista de create importacion

1 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
2 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
3 -  Asigno a la variable $route la ruta de la funcion que recibe la peticion ajax de creacion <br>
4 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
5 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador

Return: Debe retornar una vista con un formulario de creacion con los campos para productos en resource/views/importacioensv2/ImportacionTemplate/createajax

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoAjax" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoAjax",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ProductoAjax`

`HEAD importacionesv2/ProductoAjax`


<!-- END_cf9be30afad9148fc417bd9c86bb072d -->
<!-- START_42e252e6dd5b33cb779f9d2ec386eb6d -->
## storeAjax
Funcion que se encarga de guardar la informacion del formulario de creacion por una peticion ajax y redireccionar al index

1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
2 -  Valida que no exista ningun registro con el mismo prod_referencia en la tabla t_producto, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
3 -  Verifica el request con respecto a las reglas de validacion, en caso de encontrar algun error lo retorna
4 -  Crea el objeto producto con la informacion

Return: retorna un array() con la info del producto y success1

> Example request:

```bash
curl "http://localhost/importacionesv2/StoreAjaxProducto" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/StoreAjaxProducto",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/StoreAjaxProducto`


<!-- END_42e252e6dd5b33cb779f9d2ec386eb6d -->
#general
<!-- START_ceb36ae56f80374a589930ba70d382c2 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/PuertoEmbarque`

`HEAD importacionesv2/PuertoEmbarque`


<!-- END_ceb36ae56f80374a589930ba70d382c2 -->
<!-- START_b1e40a0c28c0ee0b829214fd9d5d5c33 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/PuertoEmbarque/create`

`HEAD importacionesv2/PuertoEmbarque/create`


<!-- END_b1e40a0c28c0ee0b829214fd9d5d5c33 -->
<!-- START_21309476dbb6a6550964e1b39ef658e1 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/PuertoEmbarque`


<!-- END_21309476dbb6a6550964e1b39ef658e1 -->
<!-- START_17fbe009ec1bdc770f451f777c6556fc -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/PuertoEmbarque/{PuertoEmbarque}`

`HEAD importacionesv2/PuertoEmbarque/{PuertoEmbarque}`


<!-- END_17fbe009ec1bdc770f451f777c6556fc -->
<!-- START_dca740c741d0a49068c1c83daeff09a2 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/PuertoEmbarque/{PuertoEmbarque}/edit`

`HEAD importacionesv2/PuertoEmbarque/{PuertoEmbarque}/edit`


<!-- END_dca740c741d0a49068c1c83daeff09a2 -->
<!-- START_d630e24bb8b5e3a4fd8c8e575240fe51 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/PuertoEmbarque/{PuertoEmbarque}`

`PATCH importacionesv2/PuertoEmbarque/{PuertoEmbarque}`


<!-- END_d630e24bb8b5e3a4fd8c8e575240fe51 -->
<!-- START_0dc0f52e6529034335ffbe19a3b262da -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PuertoEmbarque/{PuertoEmbarque}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/PuertoEmbarque/{PuertoEmbarque}`


<!-- END_0dc0f52e6529034335ffbe19a3b262da -->
<!-- START_a4b3b393adbfb73c7fd7753b2eac32d9 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoImportacion`

`HEAD importacionesv2/TipoImportacion`


<!-- END_a4b3b393adbfb73c7fd7753b2eac32d9 -->
<!-- START_08c9d056ff9cd3b15e8f1df3a8473703 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoImportacion/create`

`HEAD importacionesv2/TipoImportacion/create`


<!-- END_08c9d056ff9cd3b15e8f1df3a8473703 -->
<!-- START_2df9530097b2fe5ff3bffbc2a1a47a9d -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/TipoImportacion`


<!-- END_2df9530097b2fe5ff3bffbc2a1a47a9d -->
<!-- START_f60491b0af385592615a7c1fbc874b4b -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoImportacion/{TipoImportacion}`

`HEAD importacionesv2/TipoImportacion/{TipoImportacion}`


<!-- END_f60491b0af385592615a7c1fbc874b4b -->
<!-- START_eacb1f77555f73866da30d2e6775ca86 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoImportacion/{TipoImportacion}/edit`

`HEAD importacionesv2/TipoImportacion/{TipoImportacion}/edit`


<!-- END_eacb1f77555f73866da30d2e6775ca86 -->
<!-- START_e463ea999d0aa092111be729d68d926c -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/TipoImportacion/{TipoImportacion}`

`PATCH importacionesv2/TipoImportacion/{TipoImportacion}`


<!-- END_e463ea999d0aa092111be729d68d926c -->
<!-- START_3e6609b0d63b3a6438f8a7fb54039f05 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoImportacion/{TipoImportacion}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/TipoImportacion/{TipoImportacion}`


<!-- END_3e6609b0d63b3a6438f8a7fb54039f05 -->
<!-- START_b6a987ef5cf2679fce59b277e48587e5 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoLevante`

`HEAD importacionesv2/TipoLevante`


<!-- END_b6a987ef5cf2679fce59b277e48587e5 -->
<!-- START_e06e5d0e0f785956fd9b5d27023bd62f -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoLevante/create`

`HEAD importacionesv2/TipoLevante/create`


<!-- END_e06e5d0e0f785956fd9b5d27023bd62f -->
<!-- START_16448db28ac465adcc94cd18eafc0643 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/TipoLevante`


<!-- END_16448db28ac465adcc94cd18eafc0643 -->
<!-- START_14af31d468f7301be6df837feccc0b57 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante/{TipoLevante}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante/{TipoLevante}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoLevante/{TipoLevante}`

`HEAD importacionesv2/TipoLevante/{TipoLevante}`


<!-- END_14af31d468f7301be6df837feccc0b57 -->
<!-- START_dd681450152a857e7a5af87d79e81e02 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante/{TipoLevante}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante/{TipoLevante}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoLevante/{TipoLevante}/edit`

`HEAD importacionesv2/TipoLevante/{TipoLevante}/edit`


<!-- END_dd681450152a857e7a5af87d79e81e02 -->
<!-- START_8a195a0f4d0d6a8e352e2069d5597f5f -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante/{TipoLevante}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante/{TipoLevante}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/TipoLevante/{TipoLevante}`

`PATCH importacionesv2/TipoLevante/{TipoLevante}`


<!-- END_8a195a0f4d0d6a8e352e2069d5597f5f -->
<!-- START_6a21c62a0f8883fa2a5790770e17a452 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoLevante/{TipoLevante}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoLevante/{TipoLevante}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/TipoLevante/{TipoLevante}`


<!-- END_6a21c62a0f8883fa2a5790770e17a452 -->
<!-- START_9e459e0e63b0734dcf30b4a675283ba8 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Metrica`

`HEAD importacionesv2/Metrica`


<!-- END_9e459e0e63b0734dcf30b4a675283ba8 -->
<!-- START_703fc8d86ee6bf967eedd150eda6530b -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Metrica/create`

`HEAD importacionesv2/Metrica/create`


<!-- END_703fc8d86ee6bf967eedd150eda6530b -->
<!-- START_057d43770fa85435f0ee6d73d232c2de -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Metrica`


<!-- END_057d43770fa85435f0ee6d73d232c2de -->
<!-- START_93e9f1291f42570d8a08640693fcef1d -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica/{Metrica}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica/{Metrica}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Metrica/{Metrica}`

`HEAD importacionesv2/Metrica/{Metrica}`


<!-- END_93e9f1291f42570d8a08640693fcef1d -->
<!-- START_80c06411ee13462f144c40b8390898bf -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica/{Metrica}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica/{Metrica}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Metrica/{Metrica}/edit`

`HEAD importacionesv2/Metrica/{Metrica}/edit`


<!-- END_80c06411ee13462f144c40b8390898bf -->
<!-- START_752064fc7bd6e6f572c9d798eda60128 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica/{Metrica}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica/{Metrica}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Metrica/{Metrica}`

`PATCH importacionesv2/Metrica/{Metrica}`


<!-- END_752064fc7bd6e6f572c9d798eda60128 -->
<!-- START_3c68260bbc7c5d1e3a7a512c69e039c6 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Metrica/{Metrica}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Metrica/{Metrica}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Metrica/{Metrica}`


<!-- END_3c68260bbc7c5d1e3a7a512c69e039c6 -->
<!-- START_29eb53f92d9ade6396d34f094a55fcf1 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/CausalesDemora`

`HEAD importacionesv2/CausalesDemora`


<!-- END_29eb53f92d9ade6396d34f094a55fcf1 -->
<!-- START_94045c7dde6699e98635ea6e7ee212c7 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/CausalesDemora/create`

`HEAD importacionesv2/CausalesDemora/create`


<!-- END_94045c7dde6699e98635ea6e7ee212c7 -->
<!-- START_25fef4f7bdd1d35fb9ec0dfc249f5471 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/CausalesDemora`


<!-- END_25fef4f7bdd1d35fb9ec0dfc249f5471 -->
<!-- START_4fc7f2dd971986b5dcbbd4fa03c56278 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/CausalesDemora/{CausalesDemora}`

`HEAD importacionesv2/CausalesDemora/{CausalesDemora}`


<!-- END_4fc7f2dd971986b5dcbbd4fa03c56278 -->
<!-- START_2c24586f1cbc3974fea5664bc0738675 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/CausalesDemora/{CausalesDemora}/edit`

`HEAD importacionesv2/CausalesDemora/{CausalesDemora}/edit`


<!-- END_2c24586f1cbc3974fea5664bc0738675 -->
<!-- START_8cde5c64e4d1367540353bb20c9a0d36 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/CausalesDemora/{CausalesDemora}`

`PATCH importacionesv2/CausalesDemora/{CausalesDemora}`


<!-- END_8cde5c64e4d1367540353bb20c9a0d36 -->
<!-- START_46b60dbd4c01f26621cd86793dae5be4 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CausalesDemora/{CausalesDemora}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/CausalesDemora/{CausalesDemora}`


<!-- END_46b60dbd4c01f26621cd86793dae5be4 -->
<!-- START_333a3a7e8784ff3ec44cc5a8b6cb7886 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Inconterm`

`HEAD importacionesv2/Inconterm`


<!-- END_333a3a7e8784ff3ec44cc5a8b6cb7886 -->
<!-- START_31576f9412f4b68ce0986420cd30c4a1 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Inconterm/create`

`HEAD importacionesv2/Inconterm/create`


<!-- END_31576f9412f4b68ce0986420cd30c4a1 -->
<!-- START_cdb9fb62d7d39ac933d00494cdea983e -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Inconterm`


<!-- END_cdb9fb62d7d39ac933d00494cdea983e -->
<!-- START_03c4c86e24d689dae69431057f6bd973 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm/{Inconterm}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm/{Inconterm}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Inconterm/{Inconterm}`

`HEAD importacionesv2/Inconterm/{Inconterm}`


<!-- END_03c4c86e24d689dae69431057f6bd973 -->
<!-- START_2cbafac0b8766023ce439ec4fb4308e4 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm/{Inconterm}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm/{Inconterm}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Inconterm/{Inconterm}/edit`

`HEAD importacionesv2/Inconterm/{Inconterm}/edit`


<!-- END_2cbafac0b8766023ce439ec4fb4308e4 -->
<!-- START_3934cdbbd3ba062b216540a311ffe445 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm/{Inconterm}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm/{Inconterm}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Inconterm/{Inconterm}`

`PATCH importacionesv2/Inconterm/{Inconterm}`


<!-- END_3934cdbbd3ba062b216540a311ffe445 -->
<!-- START_8044cf5abfa276f57934174f7e9fcb18 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Inconterm/{Inconterm}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Inconterm/{Inconterm}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Inconterm/{Inconterm}`


<!-- END_8044cf5abfa276f57934174f7e9fcb18 -->
<!-- START_21331c3ce6d5676767c4429506e63970 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoCarga`

`HEAD importacionesv2/TipoCarga`


<!-- END_21331c3ce6d5676767c4429506e63970 -->
<!-- START_2ea44c920d0d282134df0ddeb57e9af2 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoCarga/create`

`HEAD importacionesv2/TipoCarga/create`


<!-- END_2ea44c920d0d282134df0ddeb57e9af2 -->
<!-- START_95a239e28048e8a4ac93eb8cd63f885b -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/TipoCarga`


<!-- END_95a239e28048e8a4ac93eb8cd63f885b -->
<!-- START_79252694ccebf66530b74c0ea8beff76 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga/{TipoCarga}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga/{TipoCarga}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoCarga/{TipoCarga}`

`HEAD importacionesv2/TipoCarga/{TipoCarga}`


<!-- END_79252694ccebf66530b74c0ea8beff76 -->
<!-- START_ca8b2f545be46605a2ba2c61a4e4abad -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga/{TipoCarga}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga/{TipoCarga}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoCarga/{TipoCarga}/edit`

`HEAD importacionesv2/TipoCarga/{TipoCarga}/edit`


<!-- END_ca8b2f545be46605a2ba2c61a4e4abad -->
<!-- START_316c29006bfdc88e6822ae857d2956ea -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga/{TipoCarga}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga/{TipoCarga}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/TipoCarga/{TipoCarga}`

`PATCH importacionesv2/TipoCarga/{TipoCarga}`


<!-- END_316c29006bfdc88e6822ae857d2956ea -->
<!-- START_e59b1707340777cd02dfad76d96403a1 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoCarga/{TipoCarga}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoCarga/{TipoCarga}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/TipoCarga/{TipoCarga}`


<!-- END_e59b1707340777cd02dfad76d96403a1 -->
<!-- START_5271a0f9546c1850317bc66001280b01 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoContenedor`

`HEAD importacionesv2/TipoContenedor`


<!-- END_5271a0f9546c1850317bc66001280b01 -->
<!-- START_7a7e7c740d371fb664b3d44b4991aa9b -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoContenedor/create`

`HEAD importacionesv2/TipoContenedor/create`


<!-- END_7a7e7c740d371fb664b3d44b4991aa9b -->
<!-- START_e9646bcdb176626d539420a9d8352834 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/TipoContenedor`


<!-- END_e9646bcdb176626d539420a9d8352834 -->
<!-- START_cc8fc2f57fa9bd17635536d65a892304 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoContenedor/{TipoContenedor}`

`HEAD importacionesv2/TipoContenedor/{TipoContenedor}`


<!-- END_cc8fc2f57fa9bd17635536d65a892304 -->
<!-- START_0354570a16191674998822e72c4db735 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TipoContenedor/{TipoContenedor}/edit`

`HEAD importacionesv2/TipoContenedor/{TipoContenedor}/edit`


<!-- END_0354570a16191674998822e72c4db735 -->
<!-- START_877397a58330ba846136a725f778ecce -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/TipoContenedor/{TipoContenedor}`

`PATCH importacionesv2/TipoContenedor/{TipoContenedor}`


<!-- END_877397a58330ba846136a725f778ecce -->
<!-- START_c122c0c27e8717575d5efbc3203989f4 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TipoContenedor/{TipoContenedor}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/TipoContenedor/{TipoContenedor}`


<!-- END_c122c0c27e8717575d5efbc3203989f4 -->
<!-- START_6a391876348c8699a318174acc9561cb -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TiemposTransito`

`HEAD importacionesv2/TiemposTransito`


<!-- END_6a391876348c8699a318174acc9561cb -->
<!-- START_652aad42ac61ae152eef5d719dfd9c5e -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TiemposTransito/create`

`HEAD importacionesv2/TiemposTransito/create`


<!-- END_652aad42ac61ae152eef5d719dfd9c5e -->
<!-- START_9799f254c7cfdd73567d21610d929834 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/TiemposTransito`


<!-- END_9799f254c7cfdd73567d21610d929834 -->
<!-- START_d62d4bfc1a1a8eb91c997738c79eed47 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TiemposTransito/{TiemposTransito}`

`HEAD importacionesv2/TiemposTransito/{TiemposTransito}`


<!-- END_d62d4bfc1a1a8eb91c997738c79eed47 -->
<!-- START_8aa795698a2676825f416ce7bcec7657 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/TiemposTransito/{TiemposTransito}/edit`

`HEAD importacionesv2/TiemposTransito/{TiemposTransito}/edit`


<!-- END_8aa795698a2676825f416ce7bcec7657 -->
<!-- START_002366a14a51f1d417f0e329bbba2982 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/TiemposTransito/{TiemposTransito}`

`PATCH importacionesv2/TiemposTransito/{TiemposTransito}`


<!-- END_002366a14a51f1d417f0e329bbba2982 -->
<!-- START_c3eef8b2dc417a10c0398e8ea89cd6bc -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/TiemposTransito/{TiemposTransito}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/TiemposTransito/{TiemposTransito}`


<!-- END_c3eef8b2dc417a10c0398e8ea89cd6bc -->
<!-- START_6a60736729bf9b2cabfba98ae234e354 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ProductoImportacion`

`HEAD importacionesv2/ProductoImportacion`


<!-- END_6a60736729bf9b2cabfba98ae234e354 -->
<!-- START_f52e2e248d0c2fb7900ccb4bdea2a20d -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ProductoImportacion/create`

`HEAD importacionesv2/ProductoImportacion/create`


<!-- END_f52e2e248d0c2fb7900ccb4bdea2a20d -->
<!-- START_50d3ae634748df0488bcdc9000443368 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/ProductoImportacion`


<!-- END_50d3ae634748df0488bcdc9000443368 -->
<!-- START_2d956d496a022a5cd62da23bac46c93a -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ProductoImportacion/{ProductoImportacion}`

`HEAD importacionesv2/ProductoImportacion/{ProductoImportacion}`


<!-- END_2d956d496a022a5cd62da23bac46c93a -->
<!-- START_29a61f3e20c56acfec40a007f8f8683f -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ProductoImportacion/{ProductoImportacion}/edit`

`HEAD importacionesv2/ProductoImportacion/{ProductoImportacion}/edit`


<!-- END_29a61f3e20c56acfec40a007f8f8683f -->
<!-- START_29a245ce1455ef8bdbffca68ccf4abfb -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/ProductoImportacion/{ProductoImportacion}`

`PATCH importacionesv2/ProductoImportacion/{ProductoImportacion}`


<!-- END_29a245ce1455ef8bdbffca68ccf4abfb -->
<!-- START_dc5d08fb35d71107bff80b0b1ade6e54 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ProductoImportacion/{ProductoImportacion}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/ProductoImportacion/{ProductoImportacion}`


<!-- END_dc5d08fb35d71107bff80b0b1ade6e54 -->
<!-- START_feba782d6dce36862797eeecb53774bc -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Importacion`

`HEAD importacionesv2/Importacion`


<!-- END_feba782d6dce36862797eeecb53774bc -->
<!-- START_7a0a27707dc713ef4f53cff512d58694 -->
## Muestra el formulario para la creadcion de un nuevo proceso de importacion

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Importacion/create`

`HEAD importacionesv2/Importacion/create`


<!-- END_7a0a27707dc713ef4f53cff512d58694 -->
<!-- START_b0993100215e31f1457e1cc6e588b061 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Importacion`


<!-- END_b0993100215e31f1457e1cc6e588b061 -->
<!-- START_6a9eaf583edac03fa6487c5f324a12d6 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion/{Importacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion/{Importacion}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Importacion/{Importacion}`

`HEAD importacionesv2/Importacion/{Importacion}`


<!-- END_6a9eaf583edac03fa6487c5f324a12d6 -->
<!-- START_d7f8487c50bd9ee61c96a90f4556be96 -->
## Muestra el formulario para editar un proceso de importacion en especifico

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion/{Importacion}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion/{Importacion}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Importacion/{Importacion}/edit`

`HEAD importacionesv2/Importacion/{Importacion}/edit`


<!-- END_d7f8487c50bd9ee61c96a90f4556be96 -->
<!-- START_58ad7b634b5cf326af0d39275ffa1146 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion/{Importacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion/{Importacion}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Importacion/{Importacion}`

`PATCH importacionesv2/Importacion/{Importacion}`


<!-- END_58ad7b634b5cf326af0d39275ffa1146 -->
<!-- START_584d4d9ee97a54c8c714cc167bd2926a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Importacion/{Importacion}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Importacion/{Importacion}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Importacion/{Importacion}`


<!-- END_584d4d9ee97a54c8c714cc167bd2926a -->
<!-- START_041f1b0206e92e320cc5cfc02741add3 -->
## importacionesv2/search

> Example request:

```bash
curl "http://localhost/importacionesv2/search" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/search",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/search`

`HEAD importacionesv2/search`


<!-- END_041f1b0206e92e320cc5cfc02741add3 -->
<!-- START_8db90bbbfccd7ebdf0ca8813a2c9d264 -->
## importacionesv2/cerrarOrden

> Example request:

```bash
curl "http://localhost/importacionesv2/cerrarOrden" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/cerrarOrden",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/cerrarOrden`


<!-- END_8db90bbbfccd7ebdf0ca8813a2c9d264 -->
<!-- START_37fe2d218623875302d702426ada1606 -->
## importacionesv2/searchProducto

> Example request:

```bash
curl "http://localhost/importacionesv2/searchProducto" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/searchProducto",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/searchProducto`

`HEAD importacionesv2/searchProducto`


<!-- END_37fe2d218623875302d702426ada1606 -->
<!-- START_149702176e7d960ff5cfd7f47eaff43e -->
## importacionesv2/Puertoajax

> Example request:

```bash
curl "http://localhost/importacionesv2/Puertoajax" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Puertoajax",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Puertoajax`

`HEAD importacionesv2/Puertoajax`


<!-- END_149702176e7d960ff5cfd7f47eaff43e -->
<!-- START_48435a10ae8a1d6e8a70f7d75e0f4e4b -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/StoreAjaxPuerto" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/StoreAjaxPuerto",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/StoreAjaxPuerto`


<!-- END_48435a10ae8a1d6e8a70f7d75e0f4e4b -->
<!-- START_ede2365260ae2d5f2df6537d376029be -->
## importacionesv2/Incontermajax

> Example request:

```bash
curl "http://localhost/importacionesv2/Incontermajax" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Incontermajax",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Incontermajax`

`HEAD importacionesv2/Incontermajax`


<!-- END_ede2365260ae2d5f2df6537d376029be -->
<!-- START_5a60529a7dc8dd457a9a52fb1f4db49d -->
## importacionesv2/StoreAjaxInconterm

> Example request:

```bash
curl "http://localhost/importacionesv2/StoreAjaxInconterm" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/StoreAjaxInconterm",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/StoreAjaxInconterm`


<!-- END_5a60529a7dc8dd457a9a52fb1f4db49d -->
<!-- START_afc14907478eea373e4f192712f43683 -->
## Funcion creada para generar la vista de consultas con filtros para las ordenes de importacion

> Example request:

```bash
curl "http://localhost/importacionesv2/ConsultaFiltros" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ConsultaFiltros",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ConsultaFiltros`

`HEAD importacionesv2/ConsultaFiltros`


<!-- END_afc14907478eea373e4f192712f43683 -->
<!-- START_6ef00b6c5789cbf62faf87fc92b774ef -->
## Funcion creada para el borrado de productos por ajax en el formulario importacion

> Example request:

```bash
curl "http://localhost/importacionesv2/BorrarProductoImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/BorrarProductoImportacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/BorrarProductoImportacion`

`HEAD importacionesv2/BorrarProductoImportacion`


<!-- END_6ef00b6c5789cbf62faf87fc92b774ef -->
<!-- START_52b2e6ca8f58c150d7b270451434b419 -->
## Funcion creada para el borrado de la proforma asociada a la importacion por ajax

> Example request:

```bash
curl "http://localhost/importacionesv2/BorrarProformaImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/BorrarProformaImportacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/BorrarProformaImportacion`

`HEAD importacionesv2/BorrarProformaImportacion`


<!-- END_52b2e6ca8f58c150d7b270451434b419 -->
<!-- START_ea584b21249ec2ece806d77d35201ee9 -->
## importacionesv2/AlertasImportacion

> Example request:

```bash
curl "http://localhost/importacionesv2/AlertasImportacion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/AlertasImportacion",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/AlertasImportacion`

`HEAD importacionesv2/AlertasImportacion`


<!-- END_ea584b21249ec2ece806d77d35201ee9 -->
<!-- START_14131c19baef1c9a218042cae1e76bfb -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Embarque`

`HEAD importacionesv2/Embarque`


<!-- END_14131c19baef1c9a218042cae1e76bfb -->
<!-- START_3283a64a8ceeed622428d098d5fdc1f4 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Embarque/create`

`HEAD importacionesv2/Embarque/create`


<!-- END_3283a64a8ceeed622428d098d5fdc1f4 -->
<!-- START_01efb4a1b5872b9bfd0fa53d26c7d60c -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Embarque`


<!-- END_01efb4a1b5872b9bfd0fa53d26c7d60c -->
<!-- START_1dfc0dcfacf45b509f07a134ef1f00cd -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque/{Embarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque/{Embarque}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Embarque/{Embarque}`

`HEAD importacionesv2/Embarque/{Embarque}`


<!-- END_1dfc0dcfacf45b509f07a134ef1f00cd -->
<!-- START_5190236c186eacd22453ff9c20299d0b -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque/{Embarque}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque/{Embarque}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Embarque/{Embarque}/edit`

`HEAD importacionesv2/Embarque/{Embarque}/edit`


<!-- END_5190236c186eacd22453ff9c20299d0b -->
<!-- START_249226c98a8987cdfa1ad7160e1ed0b0 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque/{Embarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque/{Embarque}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Embarque/{Embarque}`

`PATCH importacionesv2/Embarque/{Embarque}`


<!-- END_249226c98a8987cdfa1ad7160e1ed0b0 -->
<!-- START_d6c0a258fd034fe47918861adedb5b4a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Embarque/{Embarque}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Embarque/{Embarque}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Embarque/{Embarque}`


<!-- END_d6c0a258fd034fe47918861adedb5b4a -->
<!-- START_d4922deed3aac53059dfda0882158942 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/CreateEmbarque1/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/CreateEmbarque1/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/CreateEmbarque1/{id}`

`HEAD importacionesv2/CreateEmbarque1/{id}`


<!-- END_d4922deed3aac53059dfda0882158942 -->
<!-- START_bca548474dd6822c1bb40b708fa34c0c -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Pagos`

`HEAD importacionesv2/Pagos`


<!-- END_bca548474dd6822c1bb40b708fa34c0c -->
<!-- START_6b781e07415d8f2f4db387d28be530f7 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Pagos/create`

`HEAD importacionesv2/Pagos/create`


<!-- END_6b781e07415d8f2f4db387d28be530f7 -->
<!-- START_a91fe6bae624b3550f95442c1dc27c02 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/Pagos`


<!-- END_a91fe6bae624b3550f95442c1dc27c02 -->
<!-- START_c88b1a1fd6966d005c2e398db1d5ea4c -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos/{Pago}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos/{Pago}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Pagos/{Pago}`

`HEAD importacionesv2/Pagos/{Pago}`


<!-- END_c88b1a1fd6966d005c2e398db1d5ea4c -->
<!-- START_92a73aa374c66511fe265af5a6f25e38 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos/{Pago}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos/{Pago}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/Pagos/{Pago}/edit`

`HEAD importacionesv2/Pagos/{Pago}/edit`


<!-- END_92a73aa374c66511fe265af5a6f25e38 -->
<!-- START_30b19f91a477466e304de9d066705264 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos/{Pago}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos/{Pago}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/Pagos/{Pago}`

`PATCH importacionesv2/Pagos/{Pago}`


<!-- END_30b19f91a477466e304de9d066705264 -->
<!-- START_92240bdc47741289ef55f846b9f40174 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/Pagos/{Pago}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/Pagos/{Pago}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/Pagos/{Pago}`


<!-- END_92240bdc47741289ef55f846b9f40174 -->
<!-- START_ee7db095c69513443e57951338bf0d20 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/PagosCreate/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/PagosCreate/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/PagosCreate/{id}`

`HEAD importacionesv2/PagosCreate/{id}`


<!-- END_ee7db095c69513443e57951338bf0d20 -->
<!-- START_3d34dcbad44eb3bc6a733d84a5458f9c -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/NacionalizacionCosteo`

`HEAD importacionesv2/NacionalizacionCosteo`


<!-- END_3d34dcbad44eb3bc6a733d84a5458f9c -->
<!-- START_3a3af7518435748601ce120ff8aabc0f -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/NacionalizacionCosteo/create`

`HEAD importacionesv2/NacionalizacionCosteo/create`


<!-- END_3a3af7518435748601ce120ff8aabc0f -->
<!-- START_a5e04544a01759ea8230e5ff722a23ea -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/NacionalizacionCosteo`


<!-- END_a5e04544a01759ea8230e5ff722a23ea -->
<!-- START_cc1ec9eba23373df073a1e4dcc7989fa -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}`

`HEAD importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}`


<!-- END_cc1ec9eba23373df073a1e4dcc7989fa -->
<!-- START_de0daa13a8f7ad8dd6573f93067379d7 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}/edit`

`HEAD importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}/edit`


<!-- END_de0daa13a8f7ad8dd6573f93067379d7 -->
<!-- START_b48ed7da314a31ef5d054a0495d68e65 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}`

`PATCH importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}`


<!-- END_b48ed7da314a31ef5d054a0495d68e65 -->
<!-- START_6760c0021576249cb9a33812268906ce -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE importacionesv2/NacionalizacionCosteo/{NacionalizacionCosteo}`


<!-- END_6760c0021576249cb9a33812268906ce -->
<!-- START_56b05d4e914f2a661f38d115023fc228 -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/NCCreate/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/NCCreate/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/NCCreate/{id}`

`HEAD importacionesv2/NCCreate/{id}`


<!-- END_56b05d4e914f2a661f38d115023fc228 -->
<!-- START_2dba6f0ad9f6c3181bbd3055aafc52f4 -->
## importacionesv2/ExcelOrdenesGeneral

> Example request:

```bash
curl "http://localhost/importacionesv2/ExcelOrdenesGeneral" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ExcelOrdenesGeneral",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST importacionesv2/ExcelOrdenesGeneral`


<!-- END_2dba6f0ad9f6c3181bbd3055aafc52f4 -->
<!-- START_1f64d87842e94ed2d0245b283a9f976c -->
## Show the form for creating a new resource.

> Example request:

```bash
curl "http://localhost/importacionesv2/ConsultaImportacionesExportar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/importacionesv2/ConsultaImportacionesExportar",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET importacionesv2/ConsultaImportacionesExportar`

`HEAD importacionesv2/ConsultaImportacionesExportar`


<!-- END_1f64d87842e94ed2d0245b283a9f976c -->
