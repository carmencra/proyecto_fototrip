<?php

namespace Controllers;
use Repositories\GastosRepository;
use Lib\Pages;

class GastosController{
    private Pages $pages;
    private GastosRepository $repository;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new GastosRepository($db);
    }

    // obtiene los gastos del viaje indicados
    public function obtener_gastos($id_viaje): object {
        $gastos= $this->repository->obtener_gastos($id_viaje);
        $objeto= $this->pasar_objeto($gastos);
        return $objeto;  
    }

    // convierte los datos pasados en un objeto Gastos
    public function pasar_objeto($array): object {
        return $this->repository->pasar_objeto($array);
    }

    // guarda los gastos recogidos del viaje indicado
    public function guardar($id_viaje, $gastos): bool {
        $gastos_completos= $this->agregar_vacios($gastos);
        
        $guardados= $this->repository->guardar($id_viaje, $gastos_completos);
        
        return $guardados;
    }

    // aparte de los gastos seleccionados, añadimos todos los demás
    public function agregar_vacios($gastos): array {
        $todos= [];
        // comprobamos si cada gasto está en el array, sino, lo añadimos con
        $todos= $this->comprueba($gastos, 'comida', $todos);
        $todos= $this->comprueba($gastos, 'alojamiento', $todos);
        $todos= $this->comprueba($gastos, 'vuelos', $todos);
        $todos= $this->comprueba($gastos, 'transportes', $todos);
        $todos= $this->comprueba($gastos, 'seguro', $todos);
        $todos= $this->comprueba($gastos, 'gastos', $todos);
    
        return $todos;
    }

    // comprueba todos los gastos y le asigna true si están marcados y false sino
    public function comprueba($gastos, $gasto, $todos): array {
        if (isset($gastos[$gasto])) {
            $todos[$gasto]= $gastos[$gasto];
        }
        else {
            $todos[$gasto]= FALSE;
        }
        return $todos;
    }

    // borra los gastos que pertenecen al viaje indicado
    public function borrar_por_viaje($id_viaje): bool {
        return $this->repository->borrar_por_viaje($id_viaje);
    }
    
}

?>