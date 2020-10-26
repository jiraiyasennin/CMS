<?php

/**
 * Clase que escanea el directorio "classes" y 
 * carga todos los archivos al iniciar al programa
 */
$loadClasses = scandir(__DIR__);

foreach ($loadClasses as $class) {

    if (!is_dir($class)) {
        require_once $class;
    }
}
?>