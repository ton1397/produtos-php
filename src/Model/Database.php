<?php

    require_once __DIR__ .'/../../config/Config.php';

    class Database{

        private function conectar(){

            $basedados = new PDO('mysql:host='.DB_HOST.':'.DB_PORT.';'.'dbname='.DB_DATABASE.';charset='.CHARSET.'',DB_USER,DB_PASS);
            return $basedados;

        }

        //Función para ejecutar procedimiento almacenado general
        public function ExecuteQuery($query, $params = null){
           
            try{
                $conn = $this->conectar();
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare($query);
                
				if($params){
					$stmt->execute($params);
				}else{
					$stmt->execute();
				}

                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                //limpiamos
                $conn=null;
                $stmt=null;

                return $response;

            }catch(PDOException $exception) {
				throw $exception;
            }
        }

        //Función para ejecutar procedimiento sin parámetros
        public function EjecutarSPSinParams($consulta){
           
            try{
                $conexion = $this->conectar();
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute();

                $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $sentencia->closeCursor();

                //limpiamos
                $conexion=null;
                $sentencia=null;

                return $respuesta;

            }catch(PDOException $exception) {
                return $exception;
            }
        }

    }