<?php

/*
 * Copyright (C) 2019Juan Durán FMO-15632 <juanfd@ferrominera.gob.ve>
 */

/**
 * Description of Beneficiarios
 *
 * @author Juan Durán - F15632 <juanfd@ferrominera.gob.ve>
 */
class Application_Model_DbTable_Sigepro_DetallePedidoSap extends Application_Model_DbTable_Sigepro_Abstract
{
    protected $_name    = 'detalle_pedido_sap';
    protected $_primary = array('nro_pedido', 'nro_pos_doc_comp');
}