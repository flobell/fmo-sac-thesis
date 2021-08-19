<?php

class Application_Form_Comentario extends Fmo_Form_Abstract
{
    const E_CEDULA      = 'txtCedula'; 
    const E_USUARIO     = 'txtUsuario';
    const E_PEDIDO      = 'txtNroPedido';
	const E_COMENTARIO 	= 'txtComentario';    
    const E_ENVIAR		= 'btnEnviar';

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


        //Campo oculto de la cedula del usuario
        $this->addElement('hidden', self::E_CEDULA,
            array(
                'id' => self::E_CEDULA,
                'class' => 'form-control',
                'required' => false
            )
        );


        //Campo oculto del siglado del usuario
        $this->addElement('hidden', self::E_USUARIO,
            array(
                'id' => self::E_USUARIO,
                'class' => 'form-control',
                'required' => false
            )
        );


        //Campo oculta del numero de pedido
        $this->addElement('hidden', self::E_PEDIDO,
            array(
                'id' => self::E_PEDIDO,
                'class' => 'form-control',
                'required' => false
            )
        );

        $this->addElement('text',self::E_COMENTARIO,
            array(
                'id' => self::E_COMENTARIO,
                'class' => 'form-control',
                'placeholder' => 'Escriba un comentario.',
                'required' => 'true'
            )
        );

        $this->addElement('button',self::E_ENVIAR,
            array(
                'label' => 'Enviar',
                'class' => 'btn btn-primary btn-flat',
                'type' => 'submit',
                'onclick' => 'if (confirm("Desea enviar el comentario?")) { document.form.submit(); } return false;'
            )
        );
    }

    

}