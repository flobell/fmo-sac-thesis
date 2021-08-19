<?php

/*
 * Copyright (C) 2019Juan Durán FMO-15632 <juanfd@ferrominera.gob.ve>
 */

/**
 * Description of Beneficiarios
 *
 * @author Juan Durán - F15632 <juanfd@ferrominera.gob.ve>
 */
class Application_Model_DbTable_Sigepro_CabeceraPedidoSap extends Application_Model_DbTable_Sigepro_Abstract
{
    protected $_name    = 'cabecera_pedido_sap';
    protected $_primary = array('numero_solped', 'nro_pedido');
}