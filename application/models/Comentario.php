<?php

/*
 */

class Application_Model_Comentario {

	//obtiene los archivos de un pedido
	public static function getComentarios($numero){
		$tComentario = new Application_Model_DbTable_Sac_Comentario();

      	$select = $tComentario->select()
      	->setIntegrityCheck(false)
	  	->from(
    		array('a' => $tComentario->info(Zend_Db_Table::NAME)),
    		array(
    			'id' => 'a.id',
    			'fecha' => new Zend_Db_Expr("to_char(a.fch_com, 'dd/mm/yyyy')"),
    			'hora' => new Zend_Db_Expr("to_char(a.fch_com, 'HH:MI:SS AM')"),
    			'usuario' => 'a.siglado',
    			'cedula' => 'a.nro_cedula',
    			'comentario' => 'a.comentario',
    		),
	    	$tComentario->info(Zend_Db_Table::SCHEMA)
	  	)
	  	->where("nro_pedido = '$numero'");

	    return $tComentario->getAdapter()->fetchAll($select); 
		/*
	    SELECT 
	    to_char(a.fch_com, 'dd/mm/yyyy HH:MI:SS AM'), 
	    b.siglado, 
	    comentario
		FROM sch_sac.comentario a INNER JOIN sch_sac.zf_seguridad_usuario b ON b.id = a.nro_cedula
		WHERE nro_pedido = '4500040118';*/

	}

	/* envia un comentario para un pedido de compras
     *
     * @param $numero es el numero de documento de compras
     *
     * @param $comentario es el comentario escrito
     */
	public static function enviarComentario($cedula, $siglado, $numero, $comentario){
		$tComentario = new Application_Model_DbTable_Sac_Comentario();

  		$insert = $tComentario->createRow();
  		$insert->nro_cedula = $cedula;
  		$insert->siglado = $siglado;
  		$insert->nro_pedido = $numero;
  		$insert->comentario = $comentario;

  		return $insert->save();

  		/*
			INSERT INTO 
			sch_sac.comentario(nro_cedula, siglado, nro_pedido, comentario)
			VALUES ('24848217', '4500040118', 'asd');
  		*/
	}


  /* elimina un comentario
     *
     * @param $id es el numero identificador del comentario.
     */
    public static function eliminarComentario($id){
      $tComentario = Application_Model_DbTable_Sac_Comentario::findOneByColumn('id', $id);
      $tComentario->delete();
      return 1;

      /*
      DELETE FROM sch_sac.comentario(id)
      WHERE id = ''
      */
    }
}