<?php

/*
 * Copyright (C) 2019 Pedro Flores
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
 * @author Pedro Flores
 */
class Application_Model_DbTable_Sac_Abstract extends Fmo_DbTable_Abstract
{
    protected $_schema   = 'sch_sac';
    protected $_sequence = false;
    protected $multidbName = 'sac';

    public function init()
    {
        $this->_db = Zend_Controller_Front::getInstance()
            ->getParam('bootstrap')
            ->getPluginResource('multidb')
            ->getDb($this->multidbName);
    }
}