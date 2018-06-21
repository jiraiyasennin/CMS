<?php

/**
 * Clase que escanea el directorio "classes" y 
 * carga todos los archivos
 */
$classes = scandir("classes");
foreach ($classes as $class) {
    if (!is_dir($class)) {
        require_once $class;
    }
}
?>