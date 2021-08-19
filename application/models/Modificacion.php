<?php

/*
 */

class Application_Model_Modificacion {


	public static function guardarCambios($siglado, $nro_pedido, $nro_posicion = null, $anterior, $actual){
		if($nro_posicion == null){

			if($anterior->interlocutor != $actual['interlocutor']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'interlocutor', $actual['interlocutor']);
			if($anterior->cond_pago != $actual['cond_pago']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'condicion de pago', $actual['cond_pago']);
			if($anterior->cond_entrega 	!= $actual['cond_entrega']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'condicion de entrega', $actual['cond_entrega']);
			if($anterior->tmp_entr_numero != $actual['tmp_entr_numero']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'tiempo de entrega', $actual['tmp_entr_numero']);
			if($anterior->tmp_entr_ciclo != $actual['tmp_entr_ciclo']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'tiempo de entrega', $actual['tmp_entr_ciclo']);
			if($anterior->tmp_entr_tipo != $actual['tmp_entr_tipo']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'tiempo de entrega', $actual['tmp_entr_tipo']);
			if($anterior->fch_firma_prov != $actual['fch_firma_prov']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha de firma del proveedor', $actual['fch_firma_prov']);
			if($anterior->fch_venci_ped != $actual['fch_venci_ped']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha de vencimiento', $actual['fch_venci_ped']);
			if($anterior->fch_recep_ped != $actual['fch_recep_ped']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha de recepcion', $actual['fch_recep_ped']);
			if($anterior->fch_pago_prov != $actual['fch_pago_prov']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha de pago proveedor', $actual['fch_pago_prov']);
			if($anterior->fianza != $actual['fianza']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fianza', $actual['fianza']);
			if($anterior->fch_pago_anti != $actual['fch_pago_anti']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha pago anticipo', $actual['fch_pago_anti']);
			if($anterior->fch_entr_fianza != $actual['fch_entr_fianza']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha entrega fianza', $actual['fch_entr_fianza']);
			if($anterior->fch_aprob_fianza != $actual['fch_aprob_fianza']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha aprobacion fianza', $actual['fch_aprob_fianza']);
			if($anterior->fch_dev_fianza != $actual['fch_dev_fianza']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'fecha devolucion fianza', $actual['fch_dev_fianza']);
			if($anterior->compromiso != $actual['compromiso']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'CRS', $actual['compromiso']);
			if($anterior->fch_compr_resp != $actual['fch_compr_resp']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'Fecha de compromiso', $actual['fch_compr_resp']);
			if($anterior->fch_eval_prov != $actual['fch_eval_prov']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'Fecha evaluacion proveedor', $actual['fch_eval_prov']);
			if($anterior->fch_remis_eval != $actual['fch_remis_eval']) Application_Model_Modificacion::modificacionPedido($siglado, $nro_pedido, 'Fecha remision evaluacion', $actual['fch_remis_eval']);

		} else {

			if($anterior->fch_entrega_desp != $actual['fch_entrega_desp']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha entrega despachador', $actual['fch_entrega_desp']);
			if($anterior->fch_embarque != $actual['fch_embarque']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha embarque', $actual['fch_embarque']);
			if($anterior->puerto_destino != $actual['puerto_destino']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'puerto destino', $actual['puerto_destino']);
			if($anterior->fch_arribo_vzla != $actual['fch_arribo_vzla']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha arriba venezuela', $actual['fch_arribo_vzla']);
			if($anterior->fch_traslado != $actual['fch_traslado']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha orden traslado', $actual['fch_traslado']);
			if($anterior->fch_entrega_alma != $actual['fch_entrega_alma']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha entrega almacen', $actual['fch_entrega_alma']);
			if($anterior->fch_entrada_alma != $actual['fch_entrada_alma']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha entrada almacen', $actual['fch_entrada_alma']);
			if($anterior->tipo_entrega != $actual['tipo_entrega']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'tipo de entrega', $actual['tipo_entrega']);
			if($anterior->material_conforme != $actual['material_conforme']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'material conforme', $actual['material_conforme']);
			if($anterior->fch_reclamo != $actual['fch_reclamo']) Application_Model_Modificacion::modificacionPosicion($siglado, $nro_pedido, $nro_posicion, 'fecha de reclamo', $actual['fch_reclamo']);


		}

		return 1;
	}



	//@param $siglado - siglado del usuario que hizo la modificacion
	//@param $nro_pedido - numero del pedido donde se modifico el seguimiento
	//@param $campo - campo que se modifico
	//@param $modificacion - modificacion que se hizo en el campo
	//inserta una modificacion del seguimiento
	public static function modificacionPedido($siglado, $nro_pedido, $campo, $modificacion){

  		$tModificacionPedido = new Application_Model_DbTable_Sac_ModificacionPedido();

  		$insert = $tModificacionPedido->createRow();

  		$insert->siglado = $siglado;
		$insert->nro_pedido = $nro_pedido;
		$insert->campo = $campo;
		$insert->modificacion = $modificacion != null ? $modificacion : "Campo Vacio!";

  		return $insert->save();

	}



	//@param $siglado - siglado del usuario que hizo la modificacion
	//@param $nro_pedido - numero del pedido donde se modifico el seguimiento
	//@param $nro_posicion - numero del pedido donde se modifico el seguimiento
	//@param $campo - campo que se modifico
	//@param $modificacion - modificacion que se hizo en el campo
	//inserta una modificacion del seguimiento de posicion
	public static function modificacionPosicion($siglado, $nro_pedido, $nro_posicion, $campo, $modificacion){

  		$tModificacionPosicion = new Application_Model_DbTable_Sac_ModificacionPosicion();

  		$insert = $tModificacionPosicion->createRow();

  		$insert->siglado = $siglado;
		$insert->nro_pedido = $nro_pedido;
		$insert->nro_posicion = $nro_posicion;
		$insert->campo = $campo;
		$insert->modificacion = $modificacion != null ? $modificacion : "Campo Vacio!";

  		return $insert->save();

	}



	//obtiene el listado de modificaciones del seguimiento de un pedido
	public static function getModPedido($numero){
		$tModificacionPedido = new Application_Model_DbTable_Sac_ModificacionPedido();

		/*
		SELECT 
		siglado AS modificado_por, 
		fch_mod_ped AS fecha, 
		campo AS campo, 
		modificacion AS modificacion
		FROM sch_sac.modificacion_pedido
		WHERE nro_pedido = '4500040118'
		*/

		$select = $tModificacionPedido->select()
      	->setIntegrityCheck(false)
	  	->from(
    		array('a' => $tModificacionPedido->info(Zend_Db_Table::NAME)),
    		array(
				'modificado_por'=> 'a.siglado',
				'fecha'			=> new Zend_Db_Expr("to_char(a.fch_mod_ped, 'dd/mm/yyyy')"),
				'hora' 			=> new Zend_Db_Expr("to_char(a.fch_mod_ped, 'HH:MI:SS AM')"),
				'campo'			=> 'a.campo',
				'modificacion'	=> 'a.modificacion',
    		),
	    	$tModificacionPedido->info(Zend_Db_Table::SCHEMA)
	  	)
	  	->where("nro_pedido = '$numero'");

	    return $tModificacionPedido->getAdapter()->fetchAll($select); 
	}

	//obtiene el listado de modificaciones del seguimiento de una posicon
	public static function getModPosicion($numero, $posicion){
		$tModificacionPosicion = new Application_Model_DbTable_Sac_ModificacionPosicion();

		/*
		SELECT 
		siglado AS modificado_por, 
		fch_mod_ped AS fecha, 
		campo AS campo, 
		modificacion AS modificacion
		FROM sch_sac.modificacion_posicion
		WHERE nro_pedido = '4500040118' AND nro_posicion = '00030'*/

		$select = $tModificacionPosicion->select()
      	->setIntegrityCheck(false)
	  	->from(
    		array('a' => $tModificacionPosicion->info(Zend_Db_Table::NAME)),
    		array(
				'modificado_por'=> 'a.siglado',
				'fecha'			=> new Zend_Db_Expr("to_char(a.fch_mod_ped, 'dd/mm/yyyy')"),
				'hora' 			=> new Zend_Db_Expr("to_char(a.fch_mod_ped, 'HH:MI:SS AM')"),
				'campo'			=> 'a.campo',
				'modificacion'	=> 'a.modificacion'
    		),
	    	$tModificacionPosicion->info(Zend_Db_Table::SCHEMA)
	  	)
	  	->where("nro_pedido = '$numero'")
	  	->where("nro_posicion = '$posicion'");

	    return $tModificacionPosicion->getAdapter()->fetchAll($select); 

	}


}
