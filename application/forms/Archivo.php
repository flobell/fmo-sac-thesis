<?php

class Application_Form_Archivo extends Fmo_Form_Abstract
{
	const E_ARCHIVO     = 'fileArchivo';
	const E_PEDIDO 		= 'txtNroPedido';
    const E_CEDULA      = 'txtCedula';
	const E_USUARIO		= 'txtUsuario';
	const E_DESCRIPCION = 'txtDescripcion';
	const E_CARGAR     	= 'btnCargar';

	public function init()
	{



        //campo de seleccion del archivo
        $fileArchivo = new Zend_Form_Element_File(self::E_ARCHIVO);
        $fileArchivo->setLabel('Archivo:')
            ->addValidator('File_Size', false, array('min' => '1kB', 'max' => '8MB'))
            ->addValidator('File_Extension', false, 'pdf, xls, doc, txt');

        if ($this->_busqueda) $fileArchivo->setRequired();
        
        $this->addElement($fileArchivo);


        //Campo oculto del numero de pedido
        $this->addElement('hidden', self::E_PEDIDO,
            array(
                'id' => self::E_PEDIDO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo oculto del la cedula del usuario
        $this->addElement('hidden', self::E_CEDULA,
            array(
                'id' => self::E_CEDULA,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo oculto del la cedula del usuario
        $this->addElement('hidden', self::E_USUARIO,
            array(
                'id' => self::E_USUARIO,
                'class' => 'form-control',
                'required' => false
            )
        );

        //Campo de la descripcion del archivo
        $this->addElement('text',self::E_DESCRIPCION,
            array(
                'id' => self::E_DESCRIPCION,
                'class' => 'form-control',
                'placeholder' => 'Escriba una descripcion para el archivo.',
                'required' => 'true'
            )
        );

        //campo para cargar el archivo seleccionado
        $this->addElement(
        	'button',
        	self::E_CARGAR,
            array(
                'label' => 'Cargar Archivo',
                'class' => 'btn btn-primary btn-flat',
                'type' => 'submit',
                'onclick' => 'if (confirm("Desea cargar el archivo seleccionado?")) { document.form.submit(); } return false;'
            )
        );

        $this->setCustomDecorators();
	}

    public function cargarArchivo($pedido, $cedula, $usuario, $descripcion) {
        $archivo = $this->getElement(self::E_ARCHIVO);
        $adapter = $archivo->getTransferAdapter();

        foreach ($adapter->getFileInfo() as $file => $info) {     

            $nombre = $usuario.'_'.$info['name'];

            $adapter->addFilter('Rename', $nombre, $file);

            $adapter->receive($file);

            $tamano = $adapter->getFileSize();
            $directorio = Fmo_Config::PATH_UPLOAD_FILES.'/'.$nombre;
            $mime = $adapter->getMimeType();

            $params = Array(
                'nro_pedido' => $pedido,
                'nro_cedula' => $cedula,
                'usuario' => $usuario,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'directorio' => $directorio,
                'tamano' => $tamano,
                'mime' => $mime
            );
            //Zend_Debug::dd($params);
            //se guarda informacion de archivo en base de datos
            Application_Model_Archivo::insert($params);

        }
    
        return $this;
    }
}