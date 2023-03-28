<?php

namespace App\Controllers;

use App\Models\Contacto;

// USAMOS EL ORM ELOQUENT PARA LAS CONSULTAS A LA BD.

class ContactosController extends Controller
{
    // Este método nos permite acceder a todos los registros de la tabla contactos y lo muestra en un formato JSON.
    public function index()
    {
        $datosContactos = Contacto::all();
        response()->json($datosContactos);
    }

    // Me trae un solo registro, el pasado por param.
    public function consultar($id)
    {
        $datoContacto = Contacto::find($id);
        response()->json($datoContacto);
    }

    // Método para crear un registro nuevo en la bd.
    public function agregar()
    {
        // Creamos un contacto para poder guardar la infomación que recibo del cliente en él.
        $contacto = new Contacto();
        // Hacemos una prueba. Estos son los datos que me va a enviar el cliente (por un form por ej) y los guardamos en el obj cliente creado anteriormente.
        $contacto->nombre = app()->request()->get('nombre');
        $contacto->primer_apellido = app()->request()->get('primer_apellido');
        $contacto->segundo_apellido = app()->request()->get('segundo_apellido');
        $contacto->correo = app()->request()->get('correo');
        // Luego lo guardo con el método save() de Eloquent.
        $contacto->save();
        // Mensaje de confirmación/error que envíamos al cliente para que sepa si se insertó el registro u ocurrió un error.
        response()->json(["message" => "Registro agregado correctamente."]);
    }

    public function eliminar($id)
    {
        // Busco el registro.
        $data = Contacto::find($id);
        // Si no existe...
        if (!$data) {
            // Envió mensaje
            response()->json(["message" => "El id $id no existe."]);
        }
        // Si existe...
        Contacto::destroy($id);
        response()->json(["message" => "Registro: $id borrado correctamente."]);
        // De esta manera validamos si existe el registro a borrar, y luego de ser borrado no se pueda volver a pedir la eliminación de un registro que ya no existe más.
    }

    public function actualizar($id)
    {
        // Información enviada por el cliente.
        $nombre = app()->request()->get('nombre');
        $primer_apellido = app()->request()->get('primer_apellido');
        $segundo_apellido = app()->request()->get('segundo_apellido');
        $correo = app()->request()->get('correo');
     
        /*
            findOrFail($id) toma una id y devuelve un solo modelo. Si no existe ningún modelo coincidente, arroja un error. El error que arrojan los métodos findOrFail es una excepción ModelNotFoundException. Si no detecta esta excepción usted mismo, Laravel responderá con un 404, que es lo que desea la mayor parte del tiempo.
        */
        $contacto = Contacto::findOrFail($id);
        
        // Si nombre no se actualizó, mantengo el valor que tiene $nombre, sino actualizo.
        $contacto->nombre = !(empty($nombre)) ? $nombre : $contacto->nombre;
        $contacto->primer_apellido = !(empty($primer_apellido)) ? $primer_apellido : $contacto->primer_apellido;
        $contacto->segundo_apellido = !(empty($segundo_apellido)) ? $segundo_apellido : $contacto->segundo_apellido;
        $contacto->correo = !(empty($correo)) ? $correo : $contacto->correo;
        
        $contacto->update();
   
        response()->json(["message" => "Registro '$id' actualizado correctamente."]);
    }
}
