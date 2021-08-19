<?php

/*
 */

class Application_Model_Solped {

	public static function getStatus($numero){		
		$tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();
		$tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();

		$select = $tSolped->select()
		->setIntegrityCheck(false)
		->from(
			array('a' => $tSolped->info(Zend_Db_Table::NAME)),
			array(
				'nro_solp' => 'a.numero_solped',
				'departamento' => 'a.departamento',
				'estado_solp' => new Zend_Db_Expr("CASE WHEN (a.estatus_liberacion = '2') THEN 'LIBERADO' ELSE 'BLOQUEADO' END"),
				'fch_lib_pedido' => 'a.fecha_liberacion'
			),
			$tSolped->info(Zend_Db_Table::SCHEMA)
		)
		->where("a.numero_solped = '$numero'");
  
  	return $tSolped->getAdapter()->fetchRow($select);

  	/* 
		SELECT 
		a.numero_solped AS "nro_solp",
		a.departamento AS "departamento",
		CASE 
		WHEN (a.estatus_liberacion = '2') THEN 'LIBERADO' ELSE 'BLOQUEADO' END AS "estado_solp",
		a.fecha_liberacion AS "fch_lib_pedido",
		a.fcreacion_peticionoferta AS "fch_creacion_oferta",
		a.fenvio_peticionoferta AS "fch_peticion_oferta",
		a.ftope_entregaoferta AS "fch_entrega_oferta"
		FROM sch_sigepro.solped_sap a
		WHERE a.numero_solped = '0010049986';
	*/

	}


	public static function getStatusPedido($numero){
		$tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();

		$select = $tPedido->select()
		->setIntegrityCheck(false)
		->from(
			array('a' => $tPedido->info(Zend_Db_Table::NAME)),
			array(
				'fch_creacion_pedido' => 'a.fecha_doc_compras',
				'nro_pedido' => 'a.nro_pedido',
				'modalidad' => 'a.deno_clase_doc_comp',
				'estado_pedido' => new Zend_Db_Expr("CASE WHEN (a.ind_lib_doc_comp = '1') THEN 'LIBERADO' ELSE 'BLOQUEADO' END"),
				'lib_cargo_n1' => 'a.desc_cod_lib_n1',
				'lib_usuario_n1' => 'a.usuario_lib_n1',
				'lib_fecha_n1' => 'a.fecha_hora_lib_n1',
				'lib_cargo_n2' => 'a.desc_cod_lib_n2',
				'lib_usuario_n2' => 'a.usuario_lib_n2',
				'lib_fecha_n2' => 'a.fecha_hora_lib_n2',
				'lib_cargo_n3' => 'a.desc_cod_lib_n3',
				'lib_usuario_n3' => 'a.usuario_lib_n3',
				'lib_fecha_n3' => 'a.fecha_hora_lib_n3',
				'lib_cargo_n4' => 'a.desc_cod_lib_n4',
				'lib_usuario_n4' => 'a.usuario_lib_n4',
				'lib_fecha_n4' => 'a.fecha_hora_lib_n4',
				'lib_cargo_n5' => 'a.desc_cod_lib_n5',
				'lib_usuario_n5' => 'a.usuario_lib_n5',
				'lib_fecha_n5' => 'a.fecha_hora_lib_n5'			
			),
			$tPedido->info(Zend_Db_Table::SCHEMA)
		)

		->where("a.numero_solped = '$numero'");
  
  	return $tPedido->getAdapter()->fetchRow($select);

		/*
		SELECT
		a.fecha_doc_compras AS "fch_creacion_pedido",
		a.nro_pedido AS "nro_pedido",
		a.deno_clase_doc_comp AS "modalidad",
		CASE WHEN  (a.ind_lib_doc_comp = '1') THEN 'LIBERADO' ELSE 'BLOQUEADO' END AS "estado_pedido",
		a.desc_cod_lib_n1 AS "lib_cargo_n1",
		a.usuario_lib_n1 AS "lib_usuario_n1",
		a.fecha_hora_lib_n1 AS "lib_fecha_n1",
		a.desc_cod_lib_n2 AS "lib_cargo_n2",
		a.usuario_lib_n2 AS "lib_usuario_n2",
		a.fecha_hora_lib_n2 AS "lib_fecha_n2",
		a.desc_cod_lib_n3 AS "lib_cargo_n3",
		a.usuario_lib_n3 AS "lib_usuario_n3",
		a.fecha_hora_lib_n3 AS "lib_fecha_n3",
		a.desc_cod_lib_n4 AS "lib_cargo_n4",
		a.usuario_lib_n4 AS "lib_usuario_n4",
		a.fecha_hora_lib_n4 AS "lib_fecha_n4",
		a.desc_cod_lib_n5 AS "lib_cargo_n5",
		a.usuario_lib_n5 AS "lib_usuario_n5",
		a.fecha_hora_lib_n5 AS "lib_fecha_n5"
		FROM sch_sigepro.cabecera_pedido_sap a
		WHERE a.numero_solped = '0010049986'
		*/

	}

}