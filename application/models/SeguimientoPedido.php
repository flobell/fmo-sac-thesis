<?php

/*
 */

class Application_Model_SeguimientoPedido {

  	//Verifica si existe un seguimiento dado en numero del pedido de compras
  	public static function verificarSeguimiento($numero){
      $tSegPedido = new Application_Model_DbTable_Sac_SeguimientoPedido();

      $select = $tSegPedido->select()
      ->setIntegrityCheck(false)
		  ->from(
        array('a' => $tSegPedido->info(Zend_Db_Table::NAME)),
        array('a.*'),
		    $tSegPedido->info(Zend_Db_Table::SCHEMA)
		  )
		  ->where("nro_pedido = '$numero'");

	    return $tSegPedido->getAdapter()->fetchRow($select); 
  	}

    //Funcion para crear el seguimiento de un pedido
  	public function crearSeguimiento($numero){
  		$tSegPedido = new Application_Model_DbTable_Sac_SeguimientoPedido();

  		$insert = $tSegPedido->createRow();
  		$insert->nro_pedido = $numero;
  		return $insert->save();
  		/*
		INSERT INTO sch_sac.seguimiento_pedido(id, nro_pedido)
		VALUES (default, '?', '?');
  		*/
  	}


    //Devuelve el seguimiento de un pedido
    public static function getInfoPedido($numero){
      $tSegPedido = new Application_Model_DbTable_Sac_SeguimientoPedido();

      $select = $tSegPedido->select()
      ->setIntegrityCheck(false)
      ->from(
        array('a' => $tSegPedido->info(Zend_Db_Table::NAME)),
        array(
          'nro_pedido'      =>  'a.nro_pedido',
          'interlocutor'    =>  'a.interlocutor',
          'cond_pago'       =>  'a.cond_pago',
          'cond_entrega'    =>  'a.cond_entrega',
          'tmp_entr_numero' =>  'a.tmp_entr_numero',
          'tmp_entr_ciclo'  =>  'a.tmp_entr_ciclo',
          'tmp_entr_tipo'   =>  'a.tmp_entr_tipo',
          'fch_firma_prov'  =>  new Zend_Db_Expr("to_char(a.fch_firma_prov, 'DD/MM/YYYY')"),
          'fch_venci_ped'   =>  new Zend_Db_Expr("to_char(a.fch_venci_ped, 'DD/MM/YYYY')"),
          'fch_recep_ped'   =>  new Zend_Db_Expr("to_char(a.fch_recep_ped, 'DD/MM/YYYY')"),
          'fch_pago_prov'   =>  new Zend_Db_Expr("to_char(a.fch_pago_prov, 'DD/MM/YYYY')"),
          'fianza'          =>  'a.fianza',
          'fch_pago_anti'   =>  new Zend_Db_Expr("to_char(a.fch_pago_anti, 'DD/MM/YYYY')"),
          'fch_entr_fianza' =>  new Zend_Db_Expr("to_char(a.fch_entr_fianza, 'DD/MM/YYYY')"),
          'fch_aprob_fianza'=>  new Zend_Db_Expr("to_char(a.fch_aprob_fianza, 'DD/MM/YYYY')"),
          'fch_dev_fianza'  =>  new Zend_Db_Expr("to_char(a.fch_dev_fianza, 'DD/MM/YYYY')"),
          'compromiso'      =>  'a.compromiso',
          'fch_compr_resp'  =>  new Zend_Db_Expr("to_char(a.fch_compr_resp, 'DD/MM/YYYY')"),
          'fch_eval_prov'   =>  new Zend_Db_Expr("to_char(a.fch_eval_prov, 'DD/MM/YYYY')"),
          'fch_remis_eval'  =>  new Zend_Db_Expr("to_char(a.fch_remis_eval, 'DD/MM/YYYY')"),
        ),
        $tSegPedido->info(Zend_Db_Table::SCHEMA)
      )
      ->where("nro_pedido = '$numero'");

      return $tSegPedido->getAdapter()->fetchRow($select); 
    }

    public static function update($numero, $params){
            
      $tSeguimientoPedido = Application_Model_DbTable_Sac_SeguimientoPedido::findOneByColumn('nro_pedido', $numero);
      //Zend_Debug::dd($tSeguimientoPedido);
      $tSeguimientoPedido->interlocutor     = $params['interlocutor']     != NULL ? $params['interlocutor']     : NULL; 
      $tSeguimientoPedido->cond_pago        = $params['cond_pago']        != NULL ? $params['cond_pago']        : NULL;
      $tSeguimientoPedido->cond_entrega     = $params['cond_entrega']     != NULL ? $params['cond_entrega']     : NULL; 
      $tSeguimientoPedido->tmp_entr_numero  = $params['tmp_entr_numero']  != NULL ? $params['tmp_entr_numero']  : NULL;
      $tSeguimientoPedido->tmp_entr_ciclo   = $params['tmp_entr_ciclo']   != NULL ? $params['tmp_entr_ciclo']   : NULL;
      $tSeguimientoPedido->tmp_entr_tipo    = $params['tmp_entr_tipo']    != NULL ? $params['tmp_entr_tipo']    : NULL;
      $tSeguimientoPedido->fch_firma_prov   = $params['fch_firma_prov']   != NULL ? $params['fch_firma_prov']   : NULL;
      $tSeguimientoPedido->fch_venci_ped    = $params['fch_venci_ped']    != NULL ? $params['fch_venci_ped']    : NULL;    
      $tSeguimientoPedido->fch_recep_ped    = $params['fch_recep_ped']    != NULL ? $params['fch_recep_ped']    : NULL; 
      $tSeguimientoPedido->fch_pago_prov    = $params['fch_pago_prov']    != NULL ? $params['fch_pago_prov']    : NULL;    
      $tSeguimientoPedido->fianza           = $params['fianza']           != NULL ? $params['fianza']           : NULL;
      $tSeguimientoPedido->fch_pago_anti    = $params['fch_pago_anti']    != NULL ? $params['fch_pago_anti']    : NULL;  
      $tSeguimientoPedido->fch_entr_fianza  = $params['fch_entr_fianza']  != NULL ? $params['fch_entr_fianza']  : NULL;
      $tSeguimientoPedido->fch_aprob_fianza = $params['fch_aprob_fianza'] != NULL ? $params['fch_aprob_fianza'] : NULL;
      $tSeguimientoPedido->fch_dev_fianza   = $params['fch_dev_fianza']   != NULL ? $params['fch_dev_fianza']   : NULL; 
      $tSeguimientoPedido->compromiso       = $params['compromiso']       != NULL ? $params['compromiso']       : NULL;
      $tSeguimientoPedido->fch_compr_resp   = $params['fch_compr_resp']   != NULL ? $params['fch_compr_resp']   : NULL;    
      $tSeguimientoPedido->fch_eval_prov    = $params['fch_eval_prov']    != NULL ? $params['fch_eval_prov']    : NULL;  
      $tSeguimientoPedido->fch_remis_eval   = $params['fch_remis_eval']   != NULL ? $params['fch_remis_eval']   : NULL;  

      return $tSeguimientoPedido->save();

    }

}

