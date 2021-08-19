<?php

class Application_Form_ConsultaSolp extends Fmo_Form_Abstract
{
	const E_CODIGO  	= 'txtCodigo';
    const E_BUSCAR		= 'btnBuscar';

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

        $this->addElement('text',self::E_CODIGO,
            array(
                'id' => self::E_CODIGO,
                'class' => 'form-control',
                'placeholder' => 'Ingrese codigo de solicitud',
                'required' => 'true',
                'onkeypress' => 'return validarDigitos(event)'
            )
        );

        $this->addElement('button',self::E_BUSCAR,
            array(
                'label' => 'Buscar',
                'class' => 'btn btn-warning btn-flat',
                'type' => 'submit'
            )
        );




        /*ELEMENTO
            $this->addElement('text', 'age', array(
            'label'=>'Age',
            'maxlength'=>2,
            'class'=>'age',
            'filters'=>array('StringTrim'),
            'validators'=>array(
                array(
                    'validator'=>'Int',
                    'options'=>array(
                        'messages'=>'Age must be a number.'
                    )
                ),
                array(
                    'validator'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>'Please enter your age.'
                    )
                ),
                array(
                    'validator'=>'between',
                    'options'=>array(
                        'min'=>8,
                        'max'=>10,
                        'messages'=>array(
                            Zend_Validate_Between::NOT_BETWEEN => 'Your age must be between %min% to %max%.'
                        )
                    )
                )
            ),
            'decorators'=>array(
                'ViewHelper',
                'Errors',
                array(array('control'=>'HtmlTag'), array('tag'=>'div', 'class'=>'fieldcontrol')),
                array('Label', array('tag'=>'div', 'class'=>'age')),
                array(array('row'=>'HtmlTag'), array('tag' => 'div', 'class'=>'row')),
            ),
        ));

        */
    }

}