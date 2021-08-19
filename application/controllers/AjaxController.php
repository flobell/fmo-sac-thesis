<?php

/**
 * Controlador para los ajax
 */
class AjaxController extends Zend_Controller_Action
{
    /**
     * Inicialización del controlador
     */
    public function init()
    {
        $context = $this->_helper->ajaxContext();
        foreach (get_class_methods(__CLASS__) as $method) {
            if (strpos($method, 'Action') !== false) {
                $context->addActionContext($method, 'json');
            }
        }
        $context->initContext();
    }

    public function getpedidosnacionalesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $datos = Application_Model_PedidoSap::listarPedidosNacionales();
        echo json_encode($datos);
    }

    public function getpedidosinternacionalesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $datos = Application_Model_PedidoSap::listarPedidosInternacionales();
        echo json_encode($datos);
    }


    public function getposicionespedidoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $nro_pedido = $this->getParam("id");
        $datos = Application_Model_PedidoSap::getPosiciones($nro_pedido);
        echo json_encode($datos);
    }

    public function getarchivospedidoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $nro_pedido = $this->getParam("id");
        $datos = Application_Model_Archivo::getArchivos($nro_pedido);
        echo json_encode($datos);
    }

    public function getcomentariospedidoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $nro_pedido = $this->getParam("id");
        $datos = Application_Model_Comentario::getComentarios($nro_pedido);
        echo json_encode($datos);
    }

    public function getproveedoresAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $datos = Application_Model_Proveedor::getProveedores();
        echo json_encode($datos);

    }

    public function getseguimientoposicionAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $nro_pedido = $this->getParam("ped");
        $nro_posicion = $this->getParam("pos");
        $datos = Application_Model_SeguimientoPosicion::getInfoPosicion($nro_pedido, $nro_posicion);
        echo json_encode($datos);

    }

    public function getanalistasAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $datos = Application_Model_AnalistaSeguimiento::getAnalistas();
        echo json_encode($datos);
    }

    public function getasignacionesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $cedula = $this->getParam("cedula");
        $datos = Application_Model_AnalistaSeguimiento::getAsignaciones($cedula);
        echo json_encode($datos);
    }

    public function getasignacionesnacionalesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $cedula = $this->getParam("cedula");

        $array = Application_Model_AnalistaSeguimiento::getAsignacionesArray($cedula);

        if($array){
            $datos = Application_Model_AnalistaSeguimiento::getAsignacionesNacionales($array);
            echo json_encode($datos);
        } else {
            $datos = Application_Model_AnalistaSeguimiento::getAsignacionesNacionales(array(null));
            echo json_encode($datos);
        }

    }

    public function getasignacionesinternacionalesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $cedula = $this->getParam("cedula");

        $array = Application_Model_AnalistaSeguimiento::getAsignacionesArray($cedula);

        if($array){
            $datos = Application_Model_AnalistaSeguimiento::getAsignacionesInternacionales($array);
            echo json_encode($datos);
        } else {
            $datos = Application_Model_AnalistaSeguimiento::getAsignacionesInternacionales(array(null));
            echo json_encode($datos);
        }

    }

    public function getmodificacionespedidoAction(){

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $pedido = $this->getParam("pedido");
        $datos = Application_Model_Modificacion::getModPedido($pedido);
        echo json_encode($datos);

    }

    public function getmodificacionposicionAction(){

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $pedido = $this->getParam("pedido");
        $posicion = $this->getParam("posicion");
        $datos = Application_Model_Modificacion::getModPosicion($pedido, $posicion);
        echo json_encode($datos);

    }


}
