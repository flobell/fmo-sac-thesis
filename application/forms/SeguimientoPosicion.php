<?php

class Application_Form_SeguimientoPosicion extends Fmo_Form_Abstract
{

    const E_PEDIDO          = 'id';
    const E_POSICION        = 'pos';
    const E_FCH_DESPACHADOR = 'fchDespachador';
    const E_FCH_EMBARQUE	= 'fchEmbarque';
    const E_PUERTO_DESTINO  = 'txtPuertoDestino';
    const E_FCH_ARRIBO 	    = 'fchArribo';
    const E_FCH_TRASLADO 	= 'fchTraslado';
    const E_FCH_ALMACEN	    = 'fchAlmacen';
    const E_TIPO_ENTREGA    = 'selTipoEntrega';
    const E_CONFORME 	    = 'selConforme';
    const E_FCH_RECLAMO     = 'fchReclamo';
    const E_FCH_ENTRADA     = 'fchEntrada';
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

        //Campo oculta del numero de posicion
        $this->addElement('hidden', self::E_POSICION,
            array(
                'id' => self::E_POSICION,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de entrega material al agente despachador
        $this->addElement('text', self::E_FCH_DESPACHADOR,
            array(
                'id' => self::E_FCH_DESPACHADOR,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de embarque
        $this->addElement('text', self::E_FCH_EMBARQUE,
            array(
                'id' => self::E_FCH_EMBARQUE,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo del puerto destino
        $this->addElement('text', self::E_PUERTO_DESTINO,
            array(
                'id' => self::E_PUERTO_DESTINO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de arribo
        $this->addElement('text', self::E_FCH_ARRIBO,
            array(
                'id' => self::E_FCH_ARRIBO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de traslado
        $this->addElement('text', self::E_FCH_TRASLADO,
            array(
                'id' => self::E_FCH_TRASLADO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de firma del proveedor
        $this->addElement('text', self::E_FCH_ALMACEN,
            array(
                'id' => self::E_FCH_ALMACEN,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Selector de tipo de entrega
        $this->addElement('select', self::E_TIPO_ENTREGA,
            array(
                'id' => self::E_TIPO_ENTREGA,
                'class' => 'form-control',
                'required' => false,
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'total' => 'Total', 
                    'parcial' => 'Parcial'
                )
            )
        );

        //Selector de conformidad
        $this->addElement('select', self::E_CONFORME,
            array(
                'id' => self::E_CONFORME,
                'class' => 'form-control',
                'required' => false,
                'multiOptions' => array(
                    null => 'Seleccionar',
                    'si' => 'Si', 
                    'no' => 'No'
                )
            )
        );

        //Campo fecha de reclamo
        $this->addElement('text', self::E_FCH_RECLAMO,
            array(
                'id' => self::E_FCH_RECLAMO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de fecha de entrada de mercancia en almacen
        $this->addElement('text', self::E_FCH_ENTRADA,
            array(
                'id' => self::E_FCH_ENTRADA,
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
