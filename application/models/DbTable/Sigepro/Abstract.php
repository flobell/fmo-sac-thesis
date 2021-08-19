<?php

/*
 * Copyright (C) 2019 Juan Durán - F15632 <juanfd@ferrominera.gob.ve>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Clase abstracta de las DbTable
 *
 * @author Juan Durán - F15632 <juanfd@ferrominera.gob.ve>
 */
class Application_Model_DbTable_Sigepro_Abstract extends Fmo_DbTable_Abstract
{
    protected $_schema   = 'sch_sigepro';
    protected $_primary  = 'id';
    protected $_sequence = false;
    
    /**
     * MultiDB name
     * 
     * @var string
     */
    protected $multidbName = 'sigepro';
    
    /**
     * Preguntar al señor rafael como es la forma correcta de hacere esto.
     * 
     * 
     * Configuración de la BD
     */
    public function init()
    {
        $this->_db = Zend_Controller_Front::getInstance()
            ->getParam('bootstrap')
            ->getPluginResource('multidb')
            ->getDb($this->multidbName);
    }
}