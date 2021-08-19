<?php

/**
 * Controlador de estadisticas
 * @author Pedro Flores
 */
class ConsultaController extends Fmo_Controller_Action_Abstract
{
    /**
     * Acción por defecto
     */
    public function indexAction()
    {   


    }

    public function consultaAction()
    {
        $formulario = new Application_Form_ConsultaSolp();
        
        $request = $this->getRequest();
        try {
            if ($this->getRequest()->isPost()) {
                $post = $request->getPost();

                if ($formulario->isValid($this->getRequest()->getPost())) {
                    //Zend_Debug::dd($estado);
                    //$this->forward('consultaestado',null,null,null);
                    if(Application_Model_Solped::getStatus($formulario->txtCodigo->getValue()) == false) {
                        $this->addMessageInformation("Solicitud de pedido numero <".$formulario->txtCodigo->getValue()."> no existe.");
                    }
                    else {
                        $this->redirect('/default/consulta/consultaestado/solp/'.$formulario->txtCodigo->getValue());
                    }
                } else {
                    $this->addMessageWarning("Por favor, ingrese un codigo de SOLP valido.");
                }

            }
        } catch (Exception $e) {
            $this->addMessageException($e);
        }
        
        $this->view->formulario = $formulario;
    }

    public function consultaestadoAction(){
        //Zend_Debug::dd($this->getParam('solp'));
        $nro_solped = $this->getParam('solp');

        try {
            $solped = new Application_Model_Solped();
            $infoSolp = $solped->getStatus($nro_solped);
            $infoPedido = $solped->getStatusPedido($nro_solped);
            //Zend_Debug::dd($infoSolp);
            //Zend_Debug::dd($infoPedido);
            $this->view->infosolp = $infoSolp;
            $this->view->infopedido = $infoPedido;

        } catch (Exception $e) {
            $this->addMessaggeException($e);
        }

    }

    
}
