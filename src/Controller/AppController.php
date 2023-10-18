<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 12/10/2023
 * Time: 09:33 PM
 */

namespace App\Controller;

use App\SMB\FileHandler;

class AppController
{

    protected $menus;
    protected $submenu;
    protected $AppMenu;
    protected $side_menu;


    public function __construct()
    {
    }


    public function Menus()
    {
        $this->side_menu = $this->BuildMenus();
        if (!empty($this->side_menu)) {
            $side = "";
            foreach ($this->side_menu as $menu => $options):
                extract($options);
                // $y = $this->menus->permissionName($menu);
                // if (!empty($this->access[$y])):
                if (empty($submenus)):
                    $side .= '<li class="nav-item"><a href="' . DASHBOARD . '/' . $menu . ';" class="nav-link">' . $label . '</a></li>';
                else:
                    if (!empty($status)):
                        $side .= '<li class="nav-item pcoded-hasmenu';
                        //if ('?p=' . $this->request === $menu):
                        //    $side .= ' menu-open';
                        // endif;
                        $side .= '">';
                        $side .= '<a href="javascript:;" class="nav-link text-white">' . $label . '</a>';
                        if (!empty($submenus)):
                            $side .= '<ul class="pcoded-submenu">';
                            foreach ($submenus as $sub): extract($sub);
                                $active = "";
                                // $x = $this->menus->permissionName($link_name);
                                //if (!empty($_GET['v'])) $active_view = $_GET['v'];
                                //if ('&v=' . $active_view === $link_name) $active = ' active';
                                // if (!empty($this->access[$x])):
                                if (!empty($sub['status'])):
                                    $side .= '<li class=""';
                                    if (empty($sub['status'])): echo 'hide'; endif;
                                    $side .= '>';
                                    $side .= '<a href="' . DASHBOARD . '/' . $link_name . '" class="nav-link ' . @$active . '">' . $sub_label . '</a>';
                                    $side .= '</li>';
                                endif;
                                // endif;
                            endforeach;
                            $side .= '</ul>';
                        endif;
                        $side .= '</li>';
                    endif;
                endif;
                //  endif;
            endforeach;
        }
        return $side;

    }

    public function BuildMenus()
    {
        $this->menus = $this->getMenus(MENU_DIR);
        $this->AppMenu = [];
        foreach ($this->menus as $menu) {
            $path = MENU_DIR . $menu;
            $menu_name = strtolower(str_replace('.json', '', $menu));
            if (file_exists($path)) {
                $json = file_get_contents($path);
                $json = json_decode($json, true);
                if (!empty($json)):
                    $module = $json;
                    if (!empty($module['inc'])):
                        $this->submenu = [];
                        foreach ($module['inc'] as $sub):
                            $sub_roles = "";
                            if (!empty($module['submenus'][$sub]['roles'])):
                                $sub_roles = $module['submenus'][$sub]['roles'];
                                $submenuRoles = [];
                                foreach ($sub_roles as $key => $param):
                                    $submenuRoles += [
                                        $key => [
                                            'label' => $param['label'],
                                        ]
                                    ];
                                endforeach;
                                if (!empty($submenuRoles)):
                                    $sub_roles = $submenuRoles;
                                endif;
                            endif;
                            $this->submenu[] = [
                                'sub_label' => @$module['submenus'][$sub]['sub_label'],
                                'link_name' => $menu_name . '/' . $sub,
                                'icon' => @$module['submenus'][$sub]['icon'],
                                'roles' => $sub_roles,
                                'status' => @$module['submenus'][$sub]['status']
                            ];
                        endforeach;
                    endif;
                    if (!empty($moduleSubmenu)):
                        $this->submenu = $moduleSubmenu;
                    endif;
                    $this->AppMenu += array(
                        @self::getMenuOrder($module['label']) => [
                            $menu_name => [
                                'label' => '<span class="pcoded-micon"><i class="' . $module['icon'] . '"></i></span> <span class="pcoded-mtext">' . $module['label'] . '</span>',
                                'submenus' => $this->submenu,
                                'status' => $module['status'],
                                'icon' => $module['icon']
                            ]
                        ]
                    );
                endif;
            }
        }
        ksort($this->AppMenu);
        $App = [];
        foreach ($this->AppMenu as $key => $Appmodule):
            $App += $Appmodule;
        endforeach;
        return ($App);
    }

    public function getMenus(string $path): array
    {
        $directories = [];
        $items = scandir($path);

        $FileHandler = new FileHandler();

        foreach ($items as $item) {
            if ($item !== '..' && $item !== '.' && $item !== 'Order.json') {
                $ext = $FileHandler->fileExtension($item);
                if ($ext === 'json') $directories[] = $item;
            }
        }
        return $directories;
    }

    static function getMenuOrder($menu = "")
    {
        if (!empty($menu)) {
            $menu_order = MENU_DIR . 'Order.json';
            $menu_order = file_get_contents($menu_order);
            $menu_order = json_decode($menu_order, true);
            return $menu_order[$menu];
        }
    }

}