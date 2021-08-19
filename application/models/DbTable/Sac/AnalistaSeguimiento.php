<?php

/*
 * Copyright (C) 2019 Pedro Flores
 */

/**
 * Description of Beneficiarios
 *
 * @author Pedro Flores
 */
class Application_Model_DbTable_Sac_AnalistaSeguimiento extends Application_Model_DbTable_Sac_Abstract
{
    protected $_name    = 'analista_seguimiento';
    protected $_primary = array('nro_pedido', 'asignado_a');
}