<?php

/**
 * Clase utilitaria que permite aplicar el estilo de adminLTE al menú del
 * sistema.
 *
 * @author Modificado por Pedro Flores
 */
class Sac_Helper_AdminMenu extends Zend_View_Helper_Abstract
{
    const CLASS_NAME_FOR_UL_0 = '<ul class="sidebar-menu" data-widget="tree">';
    const CLASS_NAME_FOR_UL_M = '<ul class="treeview-menu">';

    /** 
     * Método recursivo para la creación del menú del sistema.
     *
     * @param array $menus Menú con la página para realizar el recorrido.
     * @param array $html Matriz con la construcción del menú en formato HTML.
     * @param int $depth Indica la profundidad del nodo.
     * @return array Matriz con las líneas del menú.
     */
    private function _build(array $menus, array &$html = array(), $depth = 0)
    {
        if ($depth > 0) {
            $ul = self::CLASS_NAME_FOR_UL_M;
        } else {
            $ul = self::CLASS_NAME_FOR_UL_0;
        }
        //tag <ul>
        $html[] = $ul;
        foreach ($menus as $menu) {
            if (!isset($menu['display']) || (boolean) $menu['display']) {
                //tag <li>
                if(!(boolean) $menu['pages']){
                    $html[] = "<li >";
                } else {
                    if (isset($menu['dispages'])) $html[] = "<li >";
                    if (!isset($menu['dispages'])) $html[] = '<li class="treeview">';
                }

                //tag <a>
                $tag = "<a href=\"";
                if ($menu['type'] == 'Zend_Navigation_Page_Uri') {
                    $url = parse_url($menu['uri']);
                    if ($url && isset($url['scheme']) && ($url['scheme'] == 'http' || $url['scheme'] == 'https')) {
                        $tag .= $menu['uri'];
                    } else {
                        $tag .= $this->view->baseUrl($menu['uri']);
                    }
                } else {
                    $route = array('module' => $menu['module'],
                                   'controller' => $menu['controller'],
                                   'action' => $menu['action']);
                    if (isset($menu['params']) && is_array($menu['params']) && !empty($menu['params'])) {
                        foreach ($menu['params'] as $key => $value) {
                            if (!isset($route[$key])) {
                                $route[$key] = $value;
                            }
                        }
                    }
                    $tag .= $this->view->url($route, null, true, $menu['encodeUrl']);
                }
                $tag .= '"';
                if (isset($menu['target']) && !empty($menu['target'])) {
                    $tag .= " target=\"{$this->view->escape($menu['target'])}\"";
                }
                $html[] = "$tag>";

                //tag <i>
                if (isset($menu['fawesome']) && !empty($menu['fawesome'])) {
                    $html[] = '<i class="fa '.$menu['fawesome'].'"></i>';
                } else {
                    $html[] = '<i class="fa fa-circle-o"></i>';
                }

                //tag <span> de label
                if (!empty($menu['label'])) {
                    $html[] = '<span>'.$this->view->escape($menu['label']).'</span>';
                }

                //tag <span class="pull-right-container"> y <i class="fa fa-angle-left pull-right"> si tiene submenu
                if((boolean) $menu['pages']){
                    if (!isset($menu['dispages']))
                    $html[] = '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
                }

                if ($menu['pages']) {
                    $html[] = '</a>';
                    $this->_build($menu['pages'], $html, $depth + 1);
                } else {
                    $html[] = '</a>';
                }
                $html[] = '</li>';
            }
        }
        $html[] = '</ul>';
        return $html;
    }

    /**
     * Método para crear el menú del sistema
     *
     * @param Zend_Navigation_Container $container
     * @return string
     */
    public function adminMenu(Zend_Navigation_Container $container)
    {
        return implode(PHP_EOL, $this->_build($container->toArray()));
    }

}