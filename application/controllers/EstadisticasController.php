<?php

/**
 * Controlador de Estadisticas
 * @author Pedro Flores
 */
class EstadisticasController extends Fmo_Controller_Action_Abstract
{

    /**
     * Acción por defecto
     */
    public function indexAction()
    {   

    	$params = Application_Model_PedidoSap::getTotalidadPedidos();
    	//Zend_Debug::dd($params);
    	$this->view->totalidades = $params;


    	
    }


}
