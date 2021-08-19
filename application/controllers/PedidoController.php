<?php

/**
 * Controlador de compras Nacionales
 * @author Pedro Flores
 */
class PedidoController extends Fmo_Controller_Action_Abstract
{

	 /**
     * Acción de listado nacionales
     */
    public function listarnacionalAction()
    {   
        
    }

    public function listarinternacionalAction()
    {   

    }

    public function seguimientoAction(){

        $request = $this->getRequest(); //Zend_Debug::dd($request); 
        try{
            //numero de pedido
            $params = $this->getAllParams();
            // $id = $request->getQuery('id');
            $id = $params['id'];
            $this->view->id = $id;

	        //informacion de pedido
	        $tPedidos = new Application_Model_PedidoSap();
	        $dato = $tPedidos->getPedidoInfo($id); //echo var_dump($dato);
	        $this->view->pedido = $dato;
	        $monto = $tPedidos->getMonto($id);
	        $this->view->monto = $monto;

	        $tSeguimiento = new Application_Model_SeguimientoPedido();
            $tSegPedido = $tSeguimiento->getInfoPedido($id);
            $this->view->segPedido = $tSegPedido;

	    }catch (Exception $e) {
            $this->addMessageError('Error: ' . $e->getMessage());
        }

    }
    
    public function descargarAction(){

        $request = $this->getRequest();
        try {
            $idArchivo = $request->getQuery('id');

            $adjunto = Application_Model_DbTable_Sac_ArchivoPedido::findOneById($idArchivo);
            if (!$adjunto) {
                throw new Exception("No existe archivo '{$adj->nombre}'");
            }
            if (!is_readable($adjunto->directorio)) {
                throw new Exception("No es posible leer el archivo '{$adjunto->nombre}'");
            }
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->layout()->disableLayout();
            $this->getResponse()
                 ->setHeader('Content-Type', "{$adjunto->mime}; charset=UTF-8")
                 ->setHeader('Content-disposition', "attachment; filename=\"{$adjunto->nombre}\"")
                 ->setHeader('Cache-Control', 'public, must-revalidate, max-age=0')
                 ->setHeader('Content-Length', $adjunto->tamano)
                 ->setHeader('Pragma', 'public')
                 ->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT')
                 ->setHeader('Last-Modified', gmdate('D, d M Y H:i:s \G\M\T'));
            ob_clean();
            readfile($adjunto->directorio);
        } catch (Exception $ex) {
            $this->addMessageException($ex);
            $this->redirect('/default/pedido/seguimiento?id='.$adjunto->nro_pedido);         
        }
        

    }

    public function posicionAction(){
        $params = $this->getAllParams();
        //$request = $this->getRequest();
        $id = $params['id'];
        $this->view->id = $id;
        $pos = $params['pos'];
        $this->view->pos = $pos;
        $dep = $params['dep'];
        $this->view->dep = $dep;
        $des = $params['des'];
        $this->view->des = $des;

        $tSegPosicion = new Application_Model_SeguimientoPosicion();
        $seguimientoPosicion = $tSegPosicion->getInfoPosicion($id,$pos); 
        $this->view->segPosicion = $seguimientoPosicion;

    }

}
