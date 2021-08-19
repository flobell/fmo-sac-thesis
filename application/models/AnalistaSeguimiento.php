<?php

/*
 */

class Application_Model_AnalistaSeguimiento {


	/*Obtiene las asignaciones de un analista dado su numero de ficha*/
	public static function getAsignaciones($cedula){
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();
		$tUsuario = new Application_Model_DbTable_ZfUsuario();

      	$select = $tAnalistaSeguimiento->select()
      	->setIntegrityCheck(false)
	  	->from(
	        array('a' => $tAnalistaSeguimiento->info(Zend_Db_Table::NAME)),
	        array(
	        	'nro_pedido'	=> 'a.nro_pedido',
	        	'asignado_a' 	=> 'a.asignado_a',
                'asignado_por' 	=> 'b.siglado',
                'fch_asignacion'=> new Zend_Db_Expr("to_char(a.fch_asignacion, 'dd/mm/yyyy')"),
	        ),
		    $tAnalistaSeguimiento->info(Zend_Db_Table::SCHEMA)
	  	)
      	->joinInner(
          	array('b' => $tUsuario->info(Zend_Db_Table::NAME)),
      		"b.id = a.asignado_por",
            null,
            $tUsuario->info(Zend_Db_Table::SCHEMA)
      	)
	  	->where("asignado_a = '$cedula'");

	    return $tAnalistaSeguimiento->getAdapter()->fetchAll($select); 

	}


	/*Obtiene las asignaciones de un analista dado su numero de ficha*/
	public static function getAsignacionesArray($cedula){
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();

      	$select = $tAnalistaSeguimiento->select()
      	->setIntegrityCheck(false)
	  	->from(
	        array('a' => $tAnalistaSeguimiento->info(Zend_Db_Table::NAME)),
	        array(
	        	'nro_pedido'	=> 'a.nro_pedido'
	        ),
		    $tAnalistaSeguimiento->info(Zend_Db_Table::SCHEMA)
	  	)
	  	->where("asignado_a = '$cedula'");

	    $resultado = $tAnalistaSeguimiento->getAdapter()->fetchAll($select); 


	    $array = array(null);
	    foreach ($resultado as $arr) {
	        $nro_pedido   = $arr->nro_pedido;
	        array_push($array, $nro_pedido);
		}
		//Zend_Debug::dd($array);
		return array_values($array);
	}


	/*Obtiene los pedidos nacionales de acuerdo a un arreglo*/
	public static function getAsignacionesNacionales($array){
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();

	    $tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    	$tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();
    	$tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();
   
	    $select = $tPedido->select()
		->distinct()
		->setIntegrityCheck(false)
		->from(
		  array('a' => $tPedido->info(Zend_Db_Table::NAME)),
		  array(
		    'numero_documento' => 'a.nro_pedido', 
		    'fecha_documento' => new Zend_Db_Expr("to_char(a.fecha_doc_compras, 'DD/MM/YYYY')"),
		    'texto_breve' => 'a.texto_breve',
		    'renglones' => 'c.renglones',
		    'moneda' => 'a.moneda',
		    'monto' => 'a.precio_neto', 
		    'proveedor' => 'a.nro_cta_desc_proved',
		    'estado' => new Zend_Db_Expr("CASE WHEN a.ind_lib_doc_comp = '1' THEN 'LIBERADO' ELSE 'BLOQUEADO' END")
		  ),
		  $tPedido->info(Zend_Db_Table::SCHEMA)
		)
		->joinInner(
		  array('b' => $tSolped->info(Zend_Db_Table::NAME)),
		  "b.numero_solped = a.numero_solped",
		  null,
		  $tSolped->info(Zend_Db_Table::SCHEMA)
		)
		->joinInner(
		  array(
		    'c' => new Zend_Db_Expr(
		      '(SELECT nro_pedido, count(*) AS renglones FROM '.$tDetalle->info(Zend_Db_Table::SCHEMA).'.'.$tDetalle->info(Zend_Db_Table::NAME).' GROUP BY 1)'
		    )
		  ),
		  "c.nro_pedido = a.nro_pedido",
		  null,
		  null
		)
		->where("b.departamento = 'NACIONAL'")
		->where("a.nro_pedido IN (?)", $array);
	              
	    return $tPedido->getAdapter()->fetchAll($select);

	}


	/*Obtiene los pedidos nacionales de acuerdo a un arreglo*/
	public static function getAsignacionesInternacionales($array){
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();

	    $tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    	$tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();
    	$tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();
   
	    $select = $tPedido->select()
		->distinct()
		->setIntegrityCheck(false)
		->from(
		  array('a' => $tPedido->info(Zend_Db_Table::NAME)),
		  array(
		    'numero_documento' => 'a.nro_pedido', 
		    'fecha_documento' => new Zend_Db_Expr("to_char(a.fecha_doc_compras, 'DD/MM/YYYY')"),
		    'texto_breve' => 'a.texto_breve',
		    'renglones' => 'c.renglones',
		    'moneda' => 'a.moneda',
		    'monto' => 'a.precio_neto', 
		    'proveedor' => 'a.nro_cta_desc_proved',
		    'estado' => new Zend_Db_Expr("CASE WHEN a.ind_lib_doc_comp = '1' THEN 'LIBERADO' ELSE 'BLOQUEADO' END")
		  ),
		  $tPedido->info(Zend_Db_Table::SCHEMA)
		)
		->joinInner(
		  array('b' => $tSolped->info(Zend_Db_Table::NAME)),
		  "b.numero_solped = a.numero_solped",
		  null,
		  $tSolped->info(Zend_Db_Table::SCHEMA)
		)
		->joinInner(
		  array(
		    'c' => new Zend_Db_Expr(
		      '(SELECT nro_pedido, count(*) AS renglones FROM '.$tDetalle->info(Zend_Db_Table::SCHEMA).'.'.$tDetalle->info(Zend_Db_Table::NAME).' GROUP BY 1)'
		    )
		  ),
		  "c.nro_pedido = a.nro_pedido",
		  null,
		  null
		)
		->where("b.departamento = 'INTERNACIONAL'")
		->where("a.nro_pedido IN (?)", $array);
	              
	    return $tPedido->getAdapter()->fetchAll($select);

	}

	public static function asignarPedido($nro_pedido, $asignado_a, $asignado_por){
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();

		$insert = $tAnalistaSeguimiento->createRow();

		$insert->nro_pedido 	= $nro_pedido;
		$insert->asignado_a		= $asignado_a;
		$insert->asignado_por	= $asignado_por;

  		return $insert->save();
	}

	//verifica si la cedula ingresada es de un analista
	public static function verificarAnalista($cedula){
		$tGrupoUsuario = new Application_Model_DbTable_ZfGrupoUsuario();

		$select = $tGrupoUsuario->select()
		->setIntegrityCheck(false)
		->from(
          	array('a' => $tGrupoUsuario->info(Zend_Db_Table::NAME)),
          	array(
                'cedula' => 'a.id_usuario', 
                'nivel' => 'a.id_grupo'
          	),
     	 	$tGrupoUsuario->info(Zend_Db_Table::SCHEMA)
      	)
      	->where("id_usuario = '$cedula'")
      	->where("id_grupo = '4'");

      	return $tGrupoUsuario->getAdapter()->fetchRow($select);

	/*
  	SELECT id_usuario, id_grupo, fecha_hora
	FROM sch_sac.zf_seguridad_grupo_usuario
	WHERE id_usuario = '5531298' AND id_grupo = '4';*/

	}

	public static function getAnalistas(){
		$tGrupoUsuario = new Application_Model_DbTable_ZfGrupoUsuario();
		$tDatosBasicos = new Fmo_DbTable_Rpsdatos_DatoBasico();
		$tAnalistaSeguimiento = new Application_Model_DbTable_Sac_AnalistaSeguimiento();

		$select = $tGrupoUsuario->select()
		->setIntegrityCheck(false)
		->from(
          	array('a' => $tGrupoUsuario->info(Zend_Db_Table::NAME)),
          	array(
                    'cedula' 		=> 'b.datb_cedula',
                    'ficha' 		=> 'b.datb_nrotrab',
                    'nombre' 		=> 'b.datb_nombre',
                    'apellido' 		=> 'b.datb_apellid',
                    'asignaciones' 	=> 'c.asignaciones'
          	),
     	 	$tGrupoUsuario->info(Zend_Db_Table::SCHEMA)
      	)
      	->joinLeft(
          	array('b' => $tDatosBasicos->info(Zend_Db_Table::NAME)),
      		"b.datb_cedula = a.id_usuario",
            null,
            $tDatosBasicos->info(Zend_Db_Table::SCHEMA)
      	)
      	->joinLeft(
			array(
			'c' => new Zend_Db_Expr(
			  '(SELECT asignado_a, count(*) AS asignaciones FROM '.$tAnalistaSeguimiento->info(Zend_Db_Table::SCHEMA).'.'.$tAnalistaSeguimiento->info(Zend_Db_Table::NAME).' GROUP BY 1)'
			)
			),
			"c.asignado_a = b.datb_cedula",
			null,
			null
      	)
      	->where("id_grupo IN ('4','5')");

      	return $tGrupoUsuario->getAdapter()->fetchAll($select);
		/*
		SELECT 
		b.datb_cedula AS "cedula",
		b.datb_nrotrab AS "ficha",
		b.datb_nombre AS "nombre",
		b.datb_apellid AS "apellido",
		c.asignaciones AS "asignaciones"
		FROM sch_sac.zf_seguridad_grupo_usuario a
		LEFT JOIN sch_rpsdatos.sn_tdatbas b ON (b.datb_cedula = a.id_usuario)
		LEFT JOIN (
			  SELECT asignado_a, count(*)::INTEGER AS asignaciones
			  FROM sch_sac.analista_seguimiento
			  GROUP BY 1
		) AS c ON (c.asignado_a = b.datb_cedula)  
		WHERE a.id_grupo = '4'*/

	}


	public static function eliminarAsignacion($pedido,$analista){

      	$tAsignacion = new Application_Model_DbTable_Sac_AnalistaSeguimiento;
      	$tAsignacion->fetchRow("nro_pedido = '$pedido' AND asignado_a = '$analista'")->delete();
      	
      	return 1;
	}
}