<?php

class Application_Form_AsignarPedido extends Fmo_Form_Abstract
{
    const E_NRO_PEDIDO              = 'txtNroPedido';
    const E_CEDULA_ANALISTA         = 'txtCedulaAnalista';
    const E_CEDULA_JEFE             = 'txtCedulaJefe';
    const E_ASIGNAR		            = 'btnAsignar';

    /**
     * Inicialización del formulario
     */
    public function __construct()
    { 
        parent::__construct(null);
    }

    public function init()
    {
        $this->setAction($this->getView()->url())
        ->setAttrib('role','form')
        ->setMethod(self::METHOD_POST);

        //numero de pedido
        $this->addElement('text',self::E_NRO_PEDIDO,
            array(
                'id' => self::E_NRO_PEDIDO,
                'class' => 'form-control',
                'placeholder' => 'Numero de pedido',
                'required' => 'true',
                'onkeypress' => 'return validarDigitos(event)'
            )
        );
        
        //Campo oculta del numero de cedula del analista asignado
        $this->addElement('hidden', self::E_CEDULA_ANALISTA,
            array(
                'id' => self::E_CEDULA_ANALISTA,
                'class' => 'form-control',
                'required' => false
            )
        );
        
        //Campo oculta del numero de cedula del jefe asignador
        $this->addElement('hidden', self::E_CEDULA_JEFE,
            array(
                'id' => self::E_CEDULA_JEFE,
                'class' => 'form-control',
                'required' => false
            )
        );

        //boton de asigna
        $this->addElement('button',self::E_ASIGNAR,
            array(
                'label' => 'Asignar',
                'class' => 'btn btn-warning btn-flat',
                'type' => 'submit',
                'onclick' => 'if (confirm("Desea asignar el pedido?")) { document.form.submit(); } return false;'
            )
        );

    }

}