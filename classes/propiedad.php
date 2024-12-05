<?php

namespace App;

class propiedad{
    // Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedor_id;

    //Definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }
    public function guardar(){

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        echo "Guardando en la base de datos";
        //Insertar en la base de datos
        $query = "INSERT INTO propiedades (titulo, precio,imagen, descripcion, habitaciones, wc,
         estacionamiento, creado, vendedor_id) VALUES ('$this->titulo', '$this->precio', 
         '$this->imagen','$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento',
         '$this->creado', '$this->vendedor_id')";

        $resultado = self::$db->query($query);

        debuguear($resultado);
    }
    //Identificar y unir los atributos de la base de datos
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
    }
    
}