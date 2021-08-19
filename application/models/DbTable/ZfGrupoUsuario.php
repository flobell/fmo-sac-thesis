<?php

class Application_Model_DbTable_ZfGrupoUsuario extends Application_Model_DbTable_Abstract
{
    protected $_name = 'zf_seguridad_grupo_usuario';
    protected $_sequence = false;
 	protected $_primary = Array('id_usuario','id_grupo');

}