<?php

class Application_Form_SeguimientoPedido extends Fmo_Form_Abstract
{
    const E_PEDIDO = 'id';
	const E_INTERLOCUTOR  	= 'txtInterlocutor';
    const E_COND_PAGO 		= 'txtCondPago';
    const E_COND_ENTREGA 	= 'txtCondEntrega';
    
    const E_TIEMPO_ENTREGA_NUMERO   = 'txtTmpEntNumero';
    const E_TIEMPO_ENTREGA_CICLO    = 'txtTmpEntCiclo';
    const E_TIEMPO_ENTREGA_TIPO     = 'txtTmpEntTipo';  
    const E_FCH_PROVEEDOR   = 'fchProveedor';
    const E_FCH_VENCIMIENTO = 'fchVencimiento';
    const E_FCH_RECEPCION   = 'fchRecepcion';
    const E_FCH_PAGO_PROV   = 'fchPagoProveedor';

    const E_FIANZA              = 'selFianza';
    const E_FCH_PAGO_ANTICIPO   = 'fchPagoAnticipo';
    const E_FCH_ENTREGA_FIANZA  = 'fchEntregaFianza';    
    const E_FCH_APROB_FIANZA    = 'fchAprobFianza';    
    const E_FCH_DEVOL_FIANZA    = 'fchDevFianza';
    
    const E_COMPROMISO      = 'selCompromiso';
    const E_FCH_COMPROMISO  = 'fchCompromiso';

    const E_FCH_EVALUACION  = 'fchEvaluacion';
    const E_FCH_REM_EVAL 	= 'fchRemEvaluacion';

    const E_GUARDAR			= 'btnGuardar';

    /**
     * Inicialización del formulario
     */
    /*
    public function __construct()
    { 
        parent::__construct(null);
    }
    */


    public function init()
    {
        $this->setAction($this->getView()->url())
        ->setAttrib('role','form')
        ->setMethod(self::METHOD_POST);

        //Campo oculta del numero de pedido
        $this->addElement('hidden', self::E_PEDIDO,
            array(
                'id' => self::E_PEDIDO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de interlocutor
        $this->addElement('text', self::E_INTERLOCUTOR,
            array(
                'id' => self::E_INTERLOCUTOR,
                'class' => 'form-control',
                'required' => false,
            )
        );

        //Campo de condicion de pago
        $this->addElement('text', self::E_COND_PAGO,
            array(
                'id' => self::E_COND_PAGO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de condicion de entrega
        $this->addElement('text', self::E_COND_ENTREGA,
            array(
                'id' => self::E_COND_ENTREGA,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de Tiempo de entrega
        $this->addElement('text', self::E_TIEMPO_ENTREGA_NUMERO,
            array(
                'id' => self::E_TIEMPO_ENTREGA_NUMERO,
                'class' => 'form-control',
                'required' => false,
                'onkeypress' => 'return validarDigitos(event)'
            )
        );

        //Selector del ciclo del tiempo de entrega
        $this->addElement('select', self::E_TIEMPO_ENTREGA_CICLO,
            array(
                'id' => self::E_TIEMPO_ENTREGA_CICLO,
                'class' => 'form-control',
                'required' => false,
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'dia' => 'dia(s)',
                    'semana' => 'semana(s)',
                    'mes' => 'mes(es)',
                    'año' => 'año(s)'
                )
            )
        );

        //Selector del tipo del tiempo de entrega
        $this->addElement('select', self::E_TIEMPO_ENTREGA_TIPO,
            array(
                'id' => self::E_TIEMPO_ENTREGA_TIPO,
                'class' => 'form-control',
                'required' => false,
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'continuo' => 'Dias continuos', 
                    'habil' => 'Dias habiles'
                )
            )
        );

        //Selector de Fianza/retencion
        $this->addElement('select', self::E_FIANZA,
            array(
                'id' => self::E_FIANZA,
                'class' => 'form-control',
                'required' => false,
                'onchange' => 'fianzaListener()',
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'si' => 'Aplica', 
                    'no' => 'No Aplica'
                )
            )
        );

        //Campo fecha de pago anticipo
        $this->addElement('text', self::E_FCH_PAGO_ANTICIPO,
            array(
                'id' => self::E_FCH_PAGO_ANTICIPO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Fecha de Devolucion de fianza
        $this->addElement('text', self::E_FCH_ENTREGA_FIANZA,
            array(
                'id' => self::E_FCH_ENTREGA_FIANZA,
                'class' => 'form-control',
                'required' => false
            )
        );
                //Fecha de Devolucion de fianza
        $this->addElement('text', self::E_FCH_APROB_FIANZA,
            array(
                'id' => self::E_FCH_APROB_FIANZA,
                'class' => 'form-control',
                'required' => false,
            )
        );

        //Fecha de Devolucion de fianza
        $this->addElement('text', self::E_FCH_DEVOL_FIANZA,
            array(
                'id' => self::E_FCH_DEVOL_FIANZA,
                'class' => 'form-control',
                'required' => false
            )
        );


        //Campo de fecha de firma del proveedor
        $this->addElement('text', self::E_FCH_PROVEEDOR,
            array(
                'id' => self::E_FCH_PROVEEDOR,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo fecha de vencimiento del pedido
        $this->addElement('text', self::E_FCH_VENCIMIENTO,
            array(
                'id' => self::E_FCH_VENCIMIENTO,
                'class' => 'form-control',
                'required' => false,
                'readonly' => 'readonly'
            )
        );

        //Campo fecha de recepcion del pedido en ACMA
        $this->addElement('text', self::E_FCH_RECEPCION,
            array(
                'id' => self::E_FCH_RECEPCION,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo fecha de pago anticipo
        $this->addElement('text', self::E_FCH_PAGO_PROV,
            array(
                'id' => self::E_FCH_PAGO_PROV,
                'class' => 'form-control',
                'required' => false
            )
        );


        //Selector de CRS
        $this->addElement('select', self::E_COMPROMISO,
            array(
                'id' => self::E_COMPROMISO,
                'class' => 'form-control',
                'required' => false,
                'onchange' => 'crsListener()',
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'si' => 'Aplica', 
                    'no' => 'No Aplica'
                )
            )
        );

        //Campo de fecha de realizacion de CRS
        $this->addElement('text', self::E_FCH_COMPROMISO,
            array(
                'id' => self::E_FCH_COMPROMISO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Fecha de realizacion de evaluacion de proveedor
        $this->addElement('text', self::E_FCH_EVALUACION,
            array(
                'id' => self::E_FCH_EVALUACION,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Fecha de remision de evaluacion a procura
        $this->addElement('text', self::E_FCH_REM_EVAL,
            array(
                'id' => self::E_FCH_REM_EVAL,
                'class' => 'form-control',
                'required' => false
            )
        );

        //boton de guardado
        $this->addElement('button', self::E_GUARDAR,
            array(
                'id' => self::E_GUARDAR,
                'label' => 'Guardar',
                'class' => 'btn btn-primary btn-flat',
                'type' => 'submit',
                'onclick' => 'if (confirm("Desea guardar?")) { document.form.submit(); } return false;'
            )
        );
    }
}

