<?php
namespace App\Core;

class Controller {

    // Charge une vue avec des données optionnelles (Avec Paramètres)
    protected function view($view, $data = []) {
        extract($data);
        require __DIR__ . '/../../views/' . $view . '.php';
    }
 
    // Charge et retourne une instance de modèle (Avec Paramètres)
    protected function model($model) {
        require_once __DIR__ . '/../../models/' . $model . '.php';
        $modelClass = "App\\Models\\".$model;
        return new $modelClass();
    }
}
