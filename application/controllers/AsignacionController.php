<?php

/**
 * Controlador asignación
 * @author Pedro Flores
 */
class AsignacionController extends Fmo_Controller_Action_Abstract
{

    /**
     * Acción por defecto
     */
    public function indexAction()
    {   

    }

    /**
     * Acción por consulta
     */
    public function consultaAction()
    {   

    }

    /*Accion para la pagina de analista*/
    public function analistaAction(){

        $formulario = new Application_Form_AsignarPedido();

        $request = $this->getRequest();
        $ficha = $request->getQuery('ficha');
    	$this->view->nro_ficha = $ficha; 

        $analista = Fmo_Model_Personal::findOneByFicha($ficha);
    	$this->view->analista = $analista;

        $jefe = Fmo_Model_Seguridad::getUsuarioSesion();
        $this->view->jefe = $jefe;

        $request = $this->getRequest();
        try {
            if ($this->getRequest()->isPost()) {
                $post = $request->getPost();

                //Si es guardado de seguimiento pedido
                if(isset($post[Application_Form_AsignarPedido::E_ASIGNAR])){

                    if(Application_Model_PedidoSap::verificarPedido($post[Application_Form_AsignarPedido::E_NRO_PEDIDO])){

                    $nro_pedido     = $post[Application_Form_AsignarPedido::E_NRO_PEDIDO];
                    $asignado_a     = $post[Application_Form_AsignarPedido::E_CEDULA_ANALISTA];
                    $asignado_por   = $post[Application_Form_AsignarPedido::E_CEDULA_JEFE];

                    $resultado = Application_Model_AnalistaSeguimiento::asignarPedido($nro_pedido, $asignado_a, $asignado_por);

                    $this->addMessageInformation('El pedido <'.$nro_pedido.'> fue asignado al analista ficha <'.$ficha.'>');
                    } else {
                        $this->addMessageWarning('El pedido <'.$post[Application_Form_AsignarPedido::E_NRO_PEDIDO].'> no existe. ');
                    }

                }

                if(isset($post['btnDesasignar'])){
                    //Zend_Debug::dd($post);
                    $nro_pedido = $post['txtPedido'];
                    $asignado_a = $post['txtAnalista'];

                    Application_Model_AnalistaSeguimiento::eliminarAsignacion($nro_pedido,$asignado_a);
                    $this->addMessageInformation('El pedido <'.$nro_pedido.'> fue desasignado al analista ficha <'.$ficha.'>');
                }

            }
        } catch (Exception $e) {
            $this->addMessageException($e);
        }

        $this->view->formulario = $formulario;
    }
}