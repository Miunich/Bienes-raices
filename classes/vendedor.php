<?php

namespace App;
// Incluye la configuración de la base de datos y la clase vendedor


// Crea una instancia de mysqli
$db = conectarDB();

// Verifica la conexión
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}
class vendedor{
    // Base de datos
    protected static $db;
    protected static $columnasDB = ['vendedor_id', 'nombre', 'apellido'];

    //Errores
    protected static $errores = [];

    public $vendedor_id;
    public $nombre;
    public $apellido;
    
    

    //Definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->vendedor_id = $args['vendedor_id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        
    }

    
    public function guardar(){

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        echo "Guardando en la base de datos";

        //Insertar en la base de datos
        $query = "INSERT INTO vendedores ( ";
        $query .= join(', ', array_keys($atributos));
        $query .=") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";


        $resultado = self::$db->query($query);

        return $resultado;

        // debuguear($resultado);
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
        return $sanitizado;
    }
    
    //Validacion
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if(!$this->nombre){
            self::$errores[] = "Debes añadir un Nombre";
        }
        if(!$this->apellido){
            self::$errores[] = "Debes añadir un Apellido";
        }
       
        return self::$errores;
    }

    // public function setImagen($imagen){
    //     if($imagen){
    //         $this->imagen = $imagen;
    //     }
    // }

    public static function all(){
        $query = "SELECT * FROM vendedores";
        
        $resultado = self::consultarSQL($query);

        return $resultado;
        
    }

    public static function consultarSQL($query){
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);

        }
    
        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;


    }

    protected static function crearObjeto($registro){                
        $objeto = new self;


        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar ($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}