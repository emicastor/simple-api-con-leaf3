<?php

app()->get("/", function () {
    response()->json(["message" => "Hola"]);
});

// Luego de ingresar a esa uri, me va a llevar al controlador llamado ContactosController y va a ejecutarse el método index. 
// Formato: controllerName@methodName.

// Me trae todos los registros.
app()->get("/contactos", 'ContactosController@index');

// Me trae un registro.
// El param se pasa entre {}.
app()->get('/contactos/{id}', 'ContactosController@consultar');

// Creo un registro nuevo.
app()->post("/contactos", 'ContactosController@agregar');

// Eliminar un registro.
app()->delete("/contactos/{id}", 'ContactosController@eliminar');

// Actualizar un registro.
app()->put("/contactos/{id}", 'ContactosController@actualizar');
