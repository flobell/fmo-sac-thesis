<?php

/*
 */

class Application_Model_Proveedor {


	public static function getProveedores(){
		$tProveedor = new Application_Model_DbTable_Sac_Proveedor();

		$select = $tProveedor->select()
		->setIntegrityCheck(false)
      	->from(
          	array('a' => $tProveedor->info(Zend_Db_Table::NAME)),
          	array(
				'cod_prov' => 'a.cod_prov', 
				'nombre' => 'a.nombre', 
				'rif' => 'a.rif', 
				'direccion' => 'a.direccion', 
				'tlf1' => 'a.tlf1', 
				'tlf2' => 'a.tlf2', 
				'ciudad' => 'a.ciudad',
				'estado' => 'a.estado',
				'fch_inscripcion' => 'a.fch_inscripcion',
				'correo' => 'a.correo',
				'rprs_legal' => 'a.rprs_legal'
      		),
          	$tProveedor->info(Zend_Db_Table::SCHEMA)
      	);
      	return $tProveedor->getAdapter()->fetchAll($select);
		/*
		SELECT 
		a.cod_prov, 
		a.nombre, 
		a.rif, 
		a.direccion, 
		a.tlf1, 
		a.tlf2, 
		a.ciudad,
		a.estado,
		a.fch_inscripcion,
		a.correo,
		a.rprs_legal
		FROM sch_sac.proveedor a
		*/
	}

	public static function getInfoProveedor($numero) {
		$tProveedor = new Application_Model_DbTable_Sac_Proveedor();

		$select = $tProveedor->select()
		->setIntegrityCheck(false)
      	->from(
          	array('a' => $tProveedor->info(Zend_Db_Table::NAME)),
          	array(
				'cod_prov' => 'a.cod_prov', 
				'nombre' => 'a.nombre', 
				'rif' => 'a.rif', 
				'direccion' => 'a.direccion', 
				'tlf1' => 'a.tlf1', 
				'tlf2' => 'a.tlf2', 
				'ciudad' => 'a.ciudad',
				'estado' => 'a.estado',
				'fch_inscripcion' => 'a.fch_inscripcion',
				'correo' => 'a.correo',
				'rprs_legal' => 'a.rprs_legal'
      		),
          	$tProveedor->info(Zend_Db_Table::SCHEMA)
      	)
      	->where("a.cod_prov = '$numero'");

      	return $tProveedor->getAdapter()->fetchRow($select);

		/*
		SELECT 
		a.cod_prov, 
		a.nombre, 
		a.rif, 
		a.direccion, 
		a.tlf1, 
		a.tlf2, 
		a.ciudad,
		a.estado,
		a.fch_inscripcion,
		a.correo,
		a.rprs_legal
		FROM sch_sac.proveedor a
		WHERE cod_prov = '0040004460';
		*/

	}

}