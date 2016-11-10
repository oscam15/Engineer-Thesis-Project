<?php namespace APP\Controllers;

require_once __DIR__."/../Config/Constantes.php";    //Inclusión de las constantes y funciones globales
require_once __DIR__."/../Autoload.php";        //Inclusión de archivo para Autoload de las clases

\APP\Autoload::run();                        //Arranca Autoload

use APP\Config\Sanitize;
use APP\Models\User;


if ($_SERVER["REQUEST_METHOD"] == "POST") {    //si se llama al index a través de un POST
    $userName = $password = "";
    $userName     = Sanitize::sanitizeInput($_POST["userName"]);    //Se limpia la entrada
    $password     = crypt(Sanitize::sanitizeInput($_POST["password"]),CRYPTKEY); //cr0k5jrG2AvAQ

		$user = new User();			//Creación de objeto User a través de los datos
		$user->set("userName", $userName);
		$user->set("password", $password);

		if($user->check()){					//Validación de usuario existente
											//Se inicia sesión con id del empleado
			session_start();						//Revisar si hay un sesión activa actualmente
			$_SESSION["idEmpleado"] = $user->get('idEmpleado');
			$_SESSION["timelast"] = time(); //Se asigna la hora de la última operación



            echo json_encode(['success' => true]);

		}else{
            echo json_encode(['success' => false, 'error' => 'Datos incorrectos.']);
		}

	} else {

    json_encode(['success' => false, 'error' => 'HTTP Request Method.']);

}

//TODO - cifrar la contraseña bien.
