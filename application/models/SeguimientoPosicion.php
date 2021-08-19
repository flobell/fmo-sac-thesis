<?php

/*
 */

class Application_Model_SeguimientoPosicion {

    //Funcion para crear el seguimiento de las posiciones de un Pedido
  	public static function crearSeguimientoPosicion($numero, $posicion){
  		$tSegPosicion = new Application_Model_DbTable_Sac_SeguimientoPosicion();

  		$insert = $tSegPosicion->createRow();
  		$insert->nro_pedido = $numero;
  		$insert->nro_posicion = $posicion;
  		return $insert->save();
  	}

  	//Obtiene un arreglo de las posiones de un pedido
    public static function getInfoPosicion($numero, $posicion){
      $tSegPosicion = new Application_Model_DbTable_Sac_SeguimientoPosicion();

      $select = $tSegPosicion->select()
      ->setIntegrityCheck(false)
      ->from(
        array('a' => $tSegPosicion->info(Zend_Db_Table::NAME)),
        array(
          'nro_pedido'        => 'a.nro_pedido',
          'nro_posicion'      => 'a.nro_posicion',
          'dias_retraso'      => 'a.dias_retraso',
          'fch_entrega_desp'  => new Zend_Db_Expr("to_char(a.fch_entrega_desp, 'DD/MM/YYYY')"),
          'fch_embarque'      => new Zend_Db_Expr("to_char(a.fch_embarque, 'DD/MM/YYYY')"),
          'puerto_destino'    => 'a.puerto_destino',
          'fch_arribo_vzla'   => new Zend_Db_Expr("to_char(a.fch_arribo_vzla, 'DD/MM/YYYY')"),
          'fch_traslado'      => new Zend_Db_Expr("to_char(a.fch_traslado, 'DD/MM/YYYY')"),
          'fch_entrega_alma'  => new Zend_Db_Expr("to_char(a.fch_entrega_alma, 'DD/MM/YYYY')"),
          'fch_entrada_alma'  => new Zend_Db_Expr("to_char(a.fch_entrada_alma, 'DD/MM/YYYY')"),
          'tipo_entrega'      => 'a.tipo_entrega',
          'material_conforme' => 'a.material_conforme',
          'fch_reclamo'       => new Zend_Db_Expr("to_char(a.fch_reclamo, 'DD/MM/YYYY')"),
        ),
        $tSegPosicion->info(Zend_Db_Table::SCHEMA)
      )
      ->where("nro_pedido = '$numero'")
      ->where("nro_posicion = '$posicion'");
      
      return $tSegPosicion->getAdapter()->fetchRow($select); 
    }

    public static function update($numero, $posicion, $params){
      $tSeguimientoPosicion = new Application_Model_DbTable_Sac_SeguimientoPosicion();

      $row = $tSeguimientoPosicion->fetchRow("nro_pedido = '$numero' AND nro_posicion = '$posicion'");

      $row->fch_entrega_desp   = $params['fch_entrega_desp']  !=NULL ? $params['fch_entrega_desp'] : NULL;
      $row->fch_embarque       = $params['fch_embarque']      !=NULL ? $params['fch_embarque'] : NULL; 
      $row->puerto_destino     = $params['puerto_destino']    !=NULL ? $params['puerto_destino'] : NULL;
      $row->fch_arribo_vzla    = $params['fch_arribo_vzla']   !=NULL ? $params['fch_arribo_vzla'] : NULL; 
      $row->fch_traslado       = $params['fch_traslado']      !=NULL ? $params['fch_traslado'] : NULL;
      $row->fch_entrega_alma   = $params['fch_entrega_alma']  !=NULL ? $params['fch_entrega_alma'] : NULL;
      $row->fch_entrada_alma   = $params['fch_entrada_alma']  !=NULL ? $params['fch_entrada_alma'] : NULL;
      $row->tipo_entrega       = $params['tipo_entrega']      !=NULL ? $params['tipo_entrega'] : NULL;
      $row->material_conforme  = $params['material_conforme'] !=NULL ? $params['material_conforme'] : NULL;
      $row->fch_reclamo        = $params['fch_reclamo']       !=NULL ? $params['fch_reclamo'] : NULL;

      return $row->save();

    }

}