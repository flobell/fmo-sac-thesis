<?php

/*
 */

class Application_Model_Archivo {

	//obtiene los archivos de un pedido
	public static function getArchivos($numero){
		$tArchivoPedido = new Application_Model_DbTable_Sac_ArchivoPedido();
		$tZfArchivo = new Application_Model_DbTable_ZfArchivo();

      	$select = $tArchivoPedido->select()
      	->setIntegrityCheck(false)
	  	->from(
	        array('a' => $tArchivoPedido->info(Zend_Db_Table::NAME)),
	        array(
	        	'id'			=> 'a.id',
				'nro_pedido' 	=> 'a.nro_pedido',
				'nro_cedula' 	=> 'a.nro_cedula',
				'siglado' 		=> 'a.usuario',
				'nombre' 		=> 'a.nombre',
				'directorio' 	=> 'a.directorio',
				'descripcion'	=> 'a.descripcion',
				'tamano' 		=> 'a.tamano',
				'fecha' 		=> new Zend_Db_Expr("to_char(a.fch_carga, 'dd/mm/yyyy')"),
				'hora' 			=> new Zend_Db_Expr("to_char(a.fch_carga, 'HH:MI:SS AM')")
	        ),
		    $tArchivoPedido->info(Zend_Db_Table::SCHEMA)
	  	)
	  	->where("nro_pedido = '$numero'");

	    return $tArchivoPedido->getAdapter()->fetchAll($select); 

	    /*
		SELECT a.*
		FROM sch_sac.archivo_pedido a
		INNER JOIN sch_sac.zf_archivo b ON b.id = a.id_archivo
		WHERE a.nro_pedido = '123456789'
	    */
	}

	public static function insert($params){

		$tArchivoPedido = new Application_Model_DbTable_Sac_ArchivoPedido();

  		$insert = $tArchivoPedido->createRow();
  		$insert->nro_pedido = $params['nro_pedido'];
		$insert->nro_cedula	= $params['nro_cedula'];
		$insert->usuario	= $params['usuario'];
		$insert->nombre		= $params['nombre'];
		$insert->descripcion= $params['descripcion'];
		$insert->directorio	= $params['directorio'];
		$insert->tamano 	= $params['tamano'];
		$insert->mime 		= $params['mime']; 
		
  		return $insert->save();

  		/*
			INSERT INTO 
			sch_sac.comentario(nro_pedido,nro_cedula,usuario,nombre,descripcion,directorio,tamano)
			VALUES (?,?,?,?,?,?,?);*/
  		

	}

}