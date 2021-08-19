<?php

/**
 * Controlador de compras Nacionales
 * @author Pedro Flores
 */
class SeguimientoController extends Fmo_Controller_Action_Abstract
{


    /**
     * Acción por defecto
     */
    public function indexAction()
    {   

    
    }

    /**
     * Acción de listado nacionales
     */
    public function listarnacionalAction()
    {   
        $cedula = Fmo_Model_Seguridad::getUsuarioSesion()->cedula;
        $this->view->cedula = $cedula;

    }

    /**
     * Acción de listado internacionales
     */
    public function listarinternacionalAction()
    {   
        $cedula = Fmo_Model_Seguridad::getUsuarioSesion()->cedula;
        $this->view->cedula = $cedula;
    }

    /**
     * Acción de listado internacionales
     */
    public function editarAction()
    {   
        //Zend_Debug::dd(Fmo_Model_Seguridad::getUsuarioSesion()->{Fmo_Model_Personal::SIGLADO});
        $formSeguimiento = new Application_Form_SeguimientoPedido();
        $formArchivo = new Application_Form_Archivo();
        $formComentario = new Application_Form_Comentario();
    
        $params = $this->getAllParams();
        try{
            //numero de pedido
            // $id = $request->getQuery('id');
            $id = $params['id'];
            //informacion de pedido
            $tPedidos = new Application_Model_PedidoSap();
            $dato = $tPedidos->getPedidoInfo($id); //echo var_dump($dato);
            $this->view->pedido = $dato;
            $monto = $tPedidos->getMonto($id);
            $this->view->monto = $monto;

            //verifica si existe seguimiento
            $tSeguimiento = new Application_Model_SeguimientoPedido();
            $tSeguimientoPosicion = new Application_Model_SeguimientoPosicion();

            if($tSeguimiento->verificarSeguimiento($id) == NULL) {
                //si no existe entonces lo crear - SQL INSERT
                $vrfSeg = $tSeguimiento->crearSeguimiento($id);
                $tPosiciones = Application_Model_PedidoSap::getPosiciones($id);
                
                foreach($tPosiciones AS $posicion => $value){
                    //echo $value->posicion;
                    $tSeguimientoPosicion->crearSeguimientoPosicion($id,$value->posicion);
                }
            }

            $tSegPedido = $tSeguimiento->getInfoPedido($id);
            $this->view->segPedido = $tSegPedido;
            //Zend_Debug::dd($this->view->segPedido); 

            $request = $this->getRequest(); //Zend_Debug::dd($request); 
            //verifica si hay solicitud de POST
            if ($request->isPost()) {
                $post = $request->getPost();
                //Zend_Debug::dd($post);
                //Si es guardado de seguimiento pedido
                if(isset($post[Application_Form_SeguimientoPedido::E_GUARDAR])){
                    //UPDATE sch_sac.seguimiento_pedido()
                    $pedido = $post[Application_Form_SeguimientoPedido::E_PEDIDO];

                    $params = Array(
                       'interlocutor'       => $post[Application_Form_SeguimientoPedido::E_INTERLOCUTOR],
                       'cond_pago'          => $post[Application_Form_SeguimientoPedido::E_COND_PAGO],
                       'cond_entrega'       => $post[Application_Form_SeguimientoPedido::E_COND_ENTREGA],
                       'tmp_entr_numero'    => $post[Application_Form_SeguimientoPedido::E_TIEMPO_ENTREGA_NUMERO],
                       'tmp_entr_ciclo'     => $post[Application_Form_SeguimientoPedido::E_TIEMPO_ENTREGA_CICLO],
                       'tmp_entr_tipo'      => $post[Application_Form_SeguimientoPedido::E_TIEMPO_ENTREGA_TIPO],
                       'fch_firma_prov'     => $post[Application_Form_SeguimientoPedido::E_FCH_PROVEEDOR],
                       'fch_venci_ped'      => $post[Application_Form_SeguimientoPedido::E_FCH_VENCIMIENTO],
                       'fch_recep_ped'      => $post[Application_Form_SeguimientoPedido::E_FCH_RECEPCION],
                       'fch_pago_prov'      => $post[Application_Form_SeguimientoPedido::E_FCH_PAGO_PROV],
                       'fianza'             => $post[Application_Form_SeguimientoPedido::E_FIANZA],
                       'fch_pago_anti'      => $post[Application_Form_SeguimientoPedido::E_FCH_PAGO_ANTICIPO],
                       'fch_entr_fianza'    => $post[Application_Form_SeguimientoPedido::E_FCH_ENTREGA_FIANZA],
                       'fch_aprob_fianza'   => $post[Application_Form_SeguimientoPedido::E_FCH_APROB_FIANZA],
                       'fch_dev_fianza'     => $post[Application_Form_SeguimientoPedido::E_FCH_DEVOL_FIANZA],
                       'compromiso'         => $post[Application_Form_SeguimientoPedido::E_COMPROMISO],
                       'fch_compr_resp'     => $post[Application_Form_SeguimientoPedido::E_FCH_COMPROMISO],
                       'fch_eval_prov'      => $post[Application_Form_SeguimientoPedido::E_FCH_EVALUACION],
                       'fch_remis_eval'     => $post[Application_Form_SeguimientoPedido::E_FCH_REM_EVAL],
                    );
                    //Se realiza la modificacion
                    //Zend_Debug::dd($params);
                    $result = Application_Model_SeguimientoPedido::update($pedido, $params);

                    //Se guarda la modificacion que se hizo
                    $usuario = Fmo_Model_Seguridad::getUsuarioSesion();
                    $modificacion = Application_Model_Modificacion::guardarCambios(
                        $usuario->siglado,
                        $pedido,
                        null,
                        $tSegPedido,
                        $params
                    );
                    
                    $this->addMessageSuccessful('Seguimiento de pedido <'.$pedido.'> guardado!');
                    $this->redirect('/default/seguimiento/editar/id/'.$id);
                    //Zend_Debug::dd($result); 

                } 

                //Si es adjuntar un archivo
                if(isset($post[Application_Form_Archivo::E_CARGAR])){
                    //CARGAR ARCHIVO
                    $pedido = $post[Application_Form_Archivo::E_PEDIDO];
                    $cedula = $post[Application_Form_Archivo::E_CEDULA];
                    $usuario = $post[Application_Form_Archivo::E_USUARIO];
                    $descripcion = $post[Application_Form_Archivo::E_DESCRIPCION];

                    $formArchivo->cargarArchivo($pedido, $cedula, $usuario, $descripcion);
                    $this->addMessageSuccessful('Archivo cargado!');



                }

                //Si es enviar un comentario
                if(isset($post[Application_Form_Comentario::E_ENVIAR])){
                    //INSERT sch_sac.comentario
                    $comentario = new Application_Model_Comentario();
                    $resultado = $comentario->enviarComentario(
                        $post[Application_Form_Comentario::E_CEDULA],
                        $post[Application_Form_Comentario::E_USUARIO],
                        $post[Application_Form_Comentario::E_PEDIDO],
                        $post[Application_Form_Comentario::E_COMENTARIO]
                    );
                    $this->addMessageSuccessful('Comentario enviado!');
                } 

                if(isset($post['btnEliminar'])){
                    //DELETE sch_sac.comentario
                    $comentario = new Application_Model_Comentario();
                    $resultado = $comentario->eliminarComentario($post['txtId']);
                    $this->addMessageSuccessful('Comentario eliminado!');
                }
            }
        }
        catch (Exception $e) {
            $this->addMessageError('Error: ' . $e->getMessage());
        }

        $this->view->formSeguimiento = $formSeguimiento;
        $this->view->formArchivo = $formArchivo;
        $this->view->formComentario = $formComentario;
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
            $this->redirect('/default/seguimiento/editar/id/'.$adjunto->nro_pedido);
            //$this->backUrlSession();            
        }
        

    }

    public function editarposicionAction(){

        $formSeguimientoPos = new Application_Form_SeguimientoPosicion();

        $params = $this->getAllParams();
        $id =  $params['id'];
        $this->view->id = $id;
        $pos =  $params['pos'];
        $this->view->pos = $pos;
        $dep =  $params['dep'];
        $this->view->dep = $dep;
        $des =  $params['des'];
        $this->view->des = $des;

        $tSegPedido = new Application_Model_SeguimientoPedido();
        $seguimientoPedido = $tSegPedido->getInfoPedido($id);
        $this->view->segPedido = $seguimientoPedido;
        //Zend_Debug::dd($this->view->segPedido);
        $tSegPosicion = new Application_Model_SeguimientoPosicion();
        $seguimientoPosicion = $tSegPosicion->getInfoPosicion($id,$pos); 
        $this->view->segPosicion = $seguimientoPosicion;
        //Zend_Debug::dd($this->view->segPosicion);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $post = $request->getPost();
            //Zend_Debug::dd($post);

            //Si es guardado de seguimiento pedido
            if(isset($post[Application_Form_SeguimientoPosicion::E_GUARDAR])){
                //UPDATE sch_sac.seguimiento_posición()
                $pedido = $post[Application_Form_SeguimientoPosicion::E_PEDIDO];
                $posicion = $post[Application_Form_SeguimientoPosicion::E_POSICION];

                $params = Array(
                    'fch_entrega_desp'  => $post[Application_Form_SeguimientoPosicion::E_FCH_DESPACHADOR],
                    'fch_embarque'      => $post[Application_Form_SeguimientoPosicion::E_FCH_EMBARQUE],
                    'puerto_destino'    => $post[Application_Form_SeguimientoPosicion::E_PUERTO_DESTINO],
                    'fch_arribo_vzla'   => $post[Application_Form_SeguimientoPosicion::E_FCH_ARRIBO],
                    'fch_traslado'      => $post[Application_Form_SeguimientoPosicion::E_FCH_TRASLADO],
                    'fch_entrega_alma'  => $post[Application_Form_SeguimientoPosicion::E_FCH_ALMACEN],
                    'fch_entrada_alma'  => $post[Application_Form_SeguimientoPosicion::E_FCH_ENTRADA],
                    'tipo_entrega'      => $post[Application_Form_SeguimientoPosicion::E_TIPO_ENTREGA],
                    'material_conforme' => $post[Application_Form_SeguimientoPosicion::E_CONFORME],
                    'fch_reclamo'       => $post[Application_Form_SeguimientoPosicion::E_FCH_RECLAMO],
                );
                //Se realiza la modificacion
                $result = Application_Model_SeguimientoPosicion::update($pedido, $posicion, $params);

                //Se guarda la modificacion que se hizo
                $usuario = Fmo_Model_Seguridad::getUsuarioSesion();
                $modificacion = Application_Model_Modificacion::guardarCambios(
                    $usuario->siglado,
                    $pedido,
                    $posicion,
                    $seguimientoPosicion,
                    $params
                );
                $this->addMessageSuccessful('Seguimiento de posicion <'.$posicion.'> guardado!');
                $this->redirect('/default/seguimiento/editar/id/'.$pedido);

            } 

        }

        $this->view->formulario = $formSeguimientoPos;

    }
}
