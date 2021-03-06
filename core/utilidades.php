<?php
/**
 * Vamos a crear una Clase con utilidades para poder reutilizar en todos los proyectos,
 * esta clase contendr� funciones estaticas y publicas para poder usarlas en cualquier momento
 * */


class Utilidades{
	
	/**
	 * Comprueba que exista en session un perfil de usuario
	 * si no existe, es que no esta logeado y le rediriguimos a login
	 */
	public static function checkSession(){		
	
		//Si no existe session la crea
		if(!isset($_SESSION)){
			session_start();		
		}
		
		//preguntar si existe el perfil del usuario en session
		if ( !$_SESSION["perfil"] ){
			header( 'Location: '.WEBROOT_HTML.'login.php?msg=Permiso denegado');
			exit;
		}	
	}
	
	/**
	 * pinta un html para un elemento Select- options
	 * @param string $name Nombre para el etributo 'name' del select
	 * @param array $arrayValoresNombres array con los valores y nombres para los OPTIONS; 'key' valores y 'value' los nombres
	 *        <br>ejemplo:   array( "0"=>"adminstrador", "1"=>"usuario")<br>
	 *         
	 * @param string $selected valor para selecionar el option 'selected'	  
	 * 
	 */
	public static function pintarSelectOptions( $name, $arrayValoresNombres , $selected ){
		
		$html = '<select name="'.$name.'">';
		
		foreach ( $arrayValoresNombres as $key => $value ) {
			
			if ( $key == $selected ) 
			{ 			
				$html .='<option selected value="'.$key.'">'; //seleccionado
			}
			else
			{
				$html .='<option value="'.$key.'">';
			}
				
			$html .= $value;
			$html .='</option>';
		}
		$html .='</select>';
		echo $html;
			
	}
	
	
	public static function uploadFoto(){
		

		$path = "";
		
		//comprobamos si ha ocurrido un error.
		if ($_FILES["foto"]["error"] > 0){
			echo "ha ocurrido un error";
		} else {
			//ahora vamos a verificar si el tipo de archivo es un tipo de foto permitido.
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			//Tamano del archivo no exceda los 10 MB
			$limite_kb = 10 * 1024 * 1024;
			$id = $_POST['id'];
		
			if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_kb){
				//esta es la ruta donde copiaremos la foto
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				$ruta = UPLOAD_DIRECTORIO . $_FILES['foto']['name'];
				var_dump($ruta);
				//comprovamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta)){
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);

					if ($resultado){
						echo "el archivo ha sido movido exitosamente";
					
						$path = PUBLIC_IMG.$_FILES['foto']['name'];;												
		
						echo "inserccion con exito de la foto";
		
					} else {
						echo "ocurrio un error al mover el archivo.";
					}
				} else {
					echo $_FILES['foto']['name'] . ", este archivo existe";
				}
			} else {
				echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
		}
		
		
		return $path;
		
		
	}
	
	
	
}