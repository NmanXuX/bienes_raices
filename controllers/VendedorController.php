<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {
        $vendedor = new Vendedor;

        // Arreglos con mensajes de errores
        $errores = Vendedor::getErrores();

        // Ejecutar el condigo despues de que el usuario envia el formulario
        if($_SERVER["REQUEST_METHOD"] === 'POST') {
    
            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
    
            // Validar que no haya campos vacios
            $errores = $vendedor->validar();

            // No hay errores
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        $id = validarORedireccionar('/admin');
        // Obtener el arreglo del vendedor
        $vendedor = Vendedor::find($id);

        // Arreglos con mensajes de errores
        $errores = Vendedor::getErrores();

        // Ejecutar el condigo despues de que el usuario envia el formulario
        if($_SERVER["REQUEST_METHOD"] === 'POST') {
        
            // Asignar lo valores
            $args = $_POST['vendedor'];

            // Sincronizar el objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);

            // Validacion
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if($id) {
        
                $tipo = $_POST['tipo'];
        
                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}