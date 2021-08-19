<?php

/*
 */

class Application_Model_PedidoSap {


    //verifica la existencia del pedido en sistema
    public static function verificarPedido($nro_pedido) {
    $tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();

    $select = $tPedido->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
      array('a' => $tPedido->info(Zend_Db_Table::NAME)),
      array(
        'numero_documento' => 'a.nro_pedido', 
      ),
      $tPedido->info(Zend_Db_Table::SCHEMA)
    )
    ->where("a.nro_pedido = '$nro_pedido'");

    return $tPedido->getAdapter()->fetchRow($select);
   }

  //Lista todos los pedidos nacionales
  public static function listarPedidosNacionales() {
    $tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    $tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();
    $tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();
    //$tTipoBien = new Application_Model_DbTable_Sigepro_TipoBien();

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
              ->where("b.numero_solped LIKE '00100%'");

    return $tPedido->getAdapter()->fetchAll($select);

    /*
    SELECT  
          DISTINCT a.nro_pedido AS "Documento de compras",
          a.fecha_doc_compras AS "Fecha documento", 
          d.descripcion_tipo_bien AS "tipo_bien", 
          c.renglones,
          a.moneda,
          a.precio_neto AS "Monto pedido", 
          a.nro_cta_desc_proved AS "Proveedor",
          CASE WHEN 
          a.ind_lib_doc_comp = '1'  
          THEN 
          'LIBERADO' 
          ELSE 
          'BLOQUEADO' 
          END AS "estado"
        FROM 
          sch_sigepro.cabecera_pedido_sap a 
          LEFT JOIN sch_sigepro.solped_sap b
          ON (b.numero_solped = a.numero_solped)
          LEFT JOIN (
                  SELECT nro_pedido, count(*) AS renglones
                  FROM sch_sigepro.detalle_pedido_sap
                  GROUP BY 1
                ) AS c ON (c.nro_pedido = a.nro_pedido)  
          LEFT JOIN sch_sigepro.tipo_bien d ON d.id_tipo_bien = b.tipo_bien
    WHERE b.departamento = 'NACIONAL' AND b.numero_solped LIKE '00100%'
    */
  }

  //Lista todos los pedidos internacionales
  public static function listarPedidosInternacionales(){
    $tPedido = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    $tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();
    $tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();
    $tTipoBien = new Application_Model_DbTable_Sigepro_TipoBien();

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
              ->where("b.numero_solped LIKE '00100%'");
              
    return $tPedido->getAdapter()->fetchAll($select);

    /*
    SELECT  
          DISTINCT a.nro_pedido AS "Documento de compras",
          a.fecha_doc_compras AS "Fecha documento", 
          d.descripcion_tipo_bien AS "tipo_bien", 
          c.renglones,
          a.moneda,
          a.precio_neto AS "Monto pedido", 
          a.nro_cta_desc_proved AS "Proveedor",
          CASE WHEN 
          a.ind_lib_doc_comp = '1'  
          THEN 
          'LIBERADO' 
          ELSE 
          'BLOQUEADO' 
          END AS "estado"
        FROM 
          sch_sigepro.cabecera_pedido_sap a 
          LEFT JOIN sch_sigepro.solped_sap b
          ON (b.numero_solped = a.numero_solped)
          LEFT JOIN (
                  SELECT nro_pedido, count(*) AS renglones
                  FROM sch_sigepro.detalle_pedido_sap
                  GROUP BY 1
                ) AS c ON (c.nro_pedido = a.nro_pedido)  
          LEFT JOIN sch_sigepro.tipo_bien d ON d.id_tipo_bien = b.tipo_bien
    WHERE b.departamento = 'INTERNACIONAL' AND b.numero_solped LIKE '00100%'
    */
  }

  public function getPedidoInfo($numero){
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
                    'estado' => new Zend_Db_Expr("CASE WHEN a.ind_lib_doc_comp = '1' THEN 'LIBERADO' ELSE 'BLOQUEADO' END"),
                    'tipo' => 'b.departamento',
                    'lib_cargo_n1' => 'a.desc_cod_lib_n1',
                    'lib_fecha_n1' => new Zend_Db_Expr("to_char(a.fecha_hora_lib_n1, 'dd/mm/yyyy hh:MI:SS AM')"),
                    'lib_cargo_n2' => 'a.desc_cod_lib_n2',
                    'lib_fecha_n2' => new Zend_Db_Expr("to_char(a.fecha_hora_lib_n2, 'dd/mm/yyyy hh:MI:SS AM')"),
                    'lib_cargo_n3' => 'a.desc_cod_lib_n3',
                    'lib_fecha_n3' => new Zend_Db_Expr("to_char(a.fecha_hora_lib_n3, 'dd/mm/yyyy hh:MI:SS AM')"),
                    'lib_cargo_n4' => 'a.desc_cod_lib_n4',
                    'lib_fecha_n4' => new Zend_Db_Expr("to_char(a.fecha_hora_lib_n4, 'dd/mm/yyyy hh:MI:SS AM')"),
                    'lib_cargo_n5' => 'a.desc_cod_lib_n5',
                    'lib_fecha_n5' => new Zend_Db_Expr("to_char(a.fecha_hora_lib_n5, 'dd/mm/yyyy hh:MI:SS AM')"),
                  ),
                  $tPedido->info(Zend_Db_Table::SCHEMA)
              )
              ->joinLeft(
                array('b' => $tSolped->info(Zend_Db_Table::NAME)),
                "b.numero_solped = a.numero_solped",
                null,
                $tSolped->info(Zend_Db_Table::SCHEMA)
              )
              ->joinLeft(
                  array(
                    'c' => new Zend_Db_Expr(
                      '(SELECT nro_pedido, count(*) AS renglones FROM '.$tDetalle->info(Zend_Db_Table::SCHEMA).'.'.$tDetalle->info(Zend_Db_Table::NAME).' GROUP BY 1)'
                    )
                  ),
                  "c.nro_pedido = a.nro_pedido",
                  null,
                  null
              )
              ->where("a.nro_pedido = '$numero'");
    return $tPedido->getAdapter()->fetchRow($select);

    /*
    SELECT DISTINCT 
      a.nro_pedido AS "Documento de compras",
      a.fecha_doc_compras AS "Fecha documento", 
      a.texto_breve, 
      c.renglones,
      a.moneda,
      a.precio_neto AS "Monto pedido", 
      a.nro_cta_desc_proved AS "Proveedor",
      CASE WHEN 
      a.ind_lib_doc_comp = '1'
      THEN 
      'LIBERADO' 
      ELSE 
      'BLOQUEADO' 
      END AS "estado",
      b.departamento AS "tipo",
      a.desc_cod_lib_n1 AS "lib_cargo_n1",
      a.fecha_hora_lib_n1 AS"lib_fecha_n1",
      a.desc_cod_lib_n2 AS "lib_cargo_n2",
      a.fecha_hora_lib_n2 AS"lib_fecha_n2",
      a.desc_cod_lib_n3 AS "lib_cargo_n3",
      a.fecha_hora_lib_n3 AS"lib_fecha_n3",
      a.desc_cod_lib_n4 AS "lib_cargo_n4",
      a.fecha_hora_lib_n4 AS"lib_fecha_n4",
      a.desc_cod_lib_n5 AS "lib_cargo_n5",
      a.fecha_hora_lib_n5 AS"lib_fecha_n5"
    FROM 
      sch_sigepro.cabecera_pedido_sap a 
      LEFT JOIN sch_sigepro.solped_sap b
      ON (b.numero_solped = a.numero_solped)
      LEFT JOIN (
        SELECT nro_pedido, count(*) AS renglones
        FROM sch_sigepro.detalle_pedido_sap
        GROUP BY 1
      ) AS c ON (c.nro_pedido = a.nro_pedido)  
    WHERE a.nro_pedido = '4500041174';
    */
  }

  public static function getPosiciones($numero){
    $tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();
    $tCabecera = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    $tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();

    $select = $tDetalle->select()
    ->setIntegrityCheck(false)
    ->from(
      array('a' => $tDetalle->info(Zend_Db_Table::NAME)),
      array(
        'nro_pedido' => 'a.nro_pedido',
        'posicion' => 'a.nro_pos_doc_comp',
        'descripcion' => 'a.texto_breve',
        'neto' => 'a.precio_net_doc_comp',
        'subtotal' => 'a.monto_total_pos',
        'departamento' => 'c.departamento'
      ),
      $tDetalle->info(Zend_Db_Table::SCHEMA)
    )
    ->joinInner(
      array('b' => $tCabecera->info(Zend_Db_Table::NAME)),
      "b.nro_pedido = a.nro_pedido",
      null,
      $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinInner(
      array('c' => $tSolped->info(Zend_Db_Table::NAME)),
      "c.numero_solped = b.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("a.nro_pedido = '$numero'");

    return $tDetalle->getAdapter()->fetchAll($select);

    /*
    SELECT 
    a.nro_pedido AS nro_pedido,
    a.nro_pos_doc_comp AS posicion,
    (monto_total_pos::decimal/precio_net_doc_comp::decimal)::integer AS cantidad,
    a.texto_breve AS descripcion,
    a.precio_net_doc_comp AS neto,
    a.monto_total_pos AS subtotal,
    c.departamento AS departamento
    FROM sch_sigepro.detalle_pedido_sap a
    INNER JOIN sch_sigepro.cabecera_pedido_sap b ON b.nro_pedido = a.nro_pedido
    INNER JOIN sch_sigepro.solped_sap c ON c.numero_solped = b.numero_solped
    WHERE nro_pedido = '4500041174'
    */
  }

  public static function getMonto($numero){
    $tDetalle = new Application_Model_DbTable_Sigepro_DetallePedidoSap();

    $select = $tDetalle->select()
    ->setIntegrityCheck(false)
    ->from(
      array('a' => $tDetalle->info(Zend_Db_Table::NAME)),
      array(
        'total' => new Zend_Db_Expr("SUM(a.monto_total_pos)")
      ),
      $tDetalle->info(Zend_Db_Table::SCHEMA)
    )
    ->where("nro_pedido = '$numero'");

    return $tDetalle->getAdapter()->fetchRow($select);
    /*
    SELECT 
    SUM(a.monto_total_pos) AS total
    FROM sch_sigepro.detalle_pedido_sap a
    WHERE nro_pedido = '5500000066'*/

  }

  public static function getTotalidadPedidos(){
    $tCabecera = new Application_Model_DbTable_Sigepro_CabeceraPedidoSap();
    $tSolped = new Application_Model_DbTable_Sigepro_SolpedSap();


   /* SELECT DISTINCT COUNT(*) AS total_pedidos
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped */
    $s1 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'total_pedidos' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento IN('NACIONAL','INTERNACIONAL')");
    $total_pedidos = $tCabecera->getAdapter()->fetchRow($s1)->total_pedidos;

    /*CANTIDAD DE PEDIDOS DE MATERIAL DE STOCK
    SELECT DISTINCT COUNT(*) AS stock_total
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.departamento IN('NACIONAL','INTERNACIONAL') AND b.numero_solped LIKE '00100%'*/
    $s2 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'stock_total' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento IN('NACIONAL','INTERNACIONAL')")
    ->where("b.numero_solped LIKE '00100%'");
    $stock_total = $tCabecera->getAdapter()->fetchRow($s2)->stock_total;

    /*--> CANTIDAD DE PEDIDOS NACIONALES DE MATERIAL DE STOCK
    SELECT DISTINCT COUNT(*) AS stock_nac
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.departamento = 'NACIONAL' AND b.numero_solped LIKE '00100%'*/
    $s3 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'stock_nac' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento = 'NACIONAL'")
    ->where("b.numero_solped LIKE '00100%'");
    $stock_nac = $tCabecera->getAdapter()->fetchRow($s3)->stock_nac;

    /*--> CANTIDAD DE PEDIDOS INTERNACIONALES DE MATERIAL DE STOCK
    SELECT DISTINCT COUNT(*) AS stock_int
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.departamento = 'INTERNACIONAL' AND b.numero_solped LIKE '00100%'*/
    $s4 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'stock_int' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento = 'INTERNACIONAL'")
    ->where("b.numero_solped LIKE '00100%'");
    $stock_int = $tCabecera->getAdapter()->fetchRow($s4)->stock_int;

    /*CANTIDAD DE PEDIDOS DE CARGO DIRECTO
    SELECT DISTINCT COUNT(*) AS directo_total
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.numero_solped LIKE '30000%'*/
    $s5 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'directo_total' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento IN('NACIONAL','INTERNACIONAL')")
    ->where("b.numero_solped LIKE '30000%'");
    $directo_total = $tCabecera->getAdapter()->fetchRow($s5)->directo_total;

    /*--> CANTIDAD DE PEDIDOS NACIONALES DE CARGO DIRECTO
    SELECT DISTINCT COUNT(*) AS directo_nac
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.departamento = 'NACIONAL' AND b.numero_solped LIKE '30000%'*/
    $s6 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'directo_nac' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento = 'NACIONAL'")
    ->where("b.numero_solped LIKE '30000%'");
    $directo_nac = $tCabecera->getAdapter()->fetchRow($s6)->directo_nac;

    /*--> CANTIDAD DE PEDIDOS INTERNACIONALES DE CARGO DIRECTO
    SELECT DISTINCT COUNT(*) AS directo_int
    FROM sch_sigepro.cabecera_pedido_sap a
    INNER JOIN sch_sigepro.solped_sap b ON b.numero_solped = a.numero_solped
    WHERE b.departamento = 'INTERNACIONAL' AND b.numero_solped LIKE '30000%'*/
    $s7 = $tCabecera->select()
    ->distinct()
    ->setIntegrityCheck(false)
    ->from(
        array('a' => $tCabecera->info(Zend_Db_Table::NAME)),
        array(
          'directo_int' => 'COUNT(*)'
        ),
        $tCabecera->info(Zend_Db_Table::SCHEMA)
    )
    ->joinLeft(
      array('b' => $tSolped->info(Zend_Db_Table::NAME)),
      "b.numero_solped = a.numero_solped",
      null,
      $tSolped->info(Zend_Db_Table::SCHEMA)
    )
    ->where("b.departamento = 'INTERNACIONAL'")
    ->where("b.numero_solped LIKE '30000%'");
    $directo_int = $tCabecera->getAdapter()->fetchRow($s7)->directo_int;

    $params = Array(
      'total_pedidos' => $total_pedidos,
      'stock_total' => $stock_total,
      'stock_nac' => $stock_nac,
      'stock_int' => $stock_int,
      'directo_total' => $directo_total,
      'directo_nac' => $directo_nac,
      'directo_int' => $directo_int
    );

    return $params;
  }



}

