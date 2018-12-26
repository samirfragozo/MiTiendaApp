<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Base
{
    /**
     * Return the HTML for the bread crumbs.
     *
     * @return Menu
     */
    public function breadCrumbs()
    {
        $menu = Menu::new()
            ->addClass('m-subheader__breadcrumbs m-nav m-nav--inline')
            ->add(
                Link::toRoute('home', '<i class="m-nav__link-icon la la-home"></i>')
                    ->addClass('m-nav__link m-nav__link--icon')
                    ->addParentClass('m-nav__item m-nav__item--home')
            )
        ;

        foreach ($this->crumbs($this->sections()) as $item) {
            $menu
                ->add(
                    Html::raw('>')
                        ->addParentClass('m-nav__separator')
                )
                ->add(
                    Link::to($item['link'], '<span class="m-nav__link-text">'. $item['text'] . '</span>')
                        ->addClass('m-nav__link')
                        ->addParentClass('m-nav__item')
                )
            ;
        }

        return $menu;
    }

    /**
     * Return an array with the bread crumbs.
     *
     * @param array $options
     * @return array
     */
    private function crumbs(array $options)
    {
        foreach ($options as $option) {
            if (!isset($option['section'])) {
                if (!isset($option['submenu'])) {
                    $route = isset($option['route']) ? $option['route'] : $option['crud'] . '.index';
                    if (Route::currentRouteName() == $route) {
                        if ($route !== 'home') {
                            return [
                                [
                                    'link' => \route($route),
                                    'text' => __('app.titles.' . $option['crud']),
                                ]
                            ];
                        }
                    }
                } else {
                    $items = $this->crumbs($option['submenu']);

                    if (!empty($items)) {
                        array_unshift($items, [
                            'link' => '',
                            'text' => __('app.menu.' . $option['name']),
                        ]);

                        return $items;
                    }
                }
            }
        }

        return [];
    }

    /**
     * Return the HTML for the menu.
     *
     * @return Menu
     */
    public function menu()
    {
        return Menu::build($this->sections(), function ($menu, $option) {
            if (isset($option['section'])) {
                $menu->html(
                    '<li class="m-menu__section ">' .
                    '<h4 class="m-menu__section-text">' . __('app.roles.' . $option['section']) . '</h4>' .
                    '<i class="m-menu__section-icon flaticon-more-v2"></i>' .
                    '</li>'
                );
            } else {
                $menu->route(isset($option['route']) ? $option['route'] : $option['crud'] . '.index',
                    '<i class="m-menu__link-icon ' . $option['icon'] . '"></i>' .
                    '<span class="m-menu__link-title">' .
                    '<span class="m-menu__link-wrap">' .
                    '<span class="m-menu__link-text">' . __('app.titles.' . $option['crud']) . '</span>' .
                    '</span>' .
                    '</span>'
                );
            }
        })
            ->addClass('m-menu__nav m-menu__nav--dropdown-submenu-arrow')
            ->append('</div></div>')
            ->each(function (Link $link) {
                $link->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', 'true');
            })
            ->prepend(
                '<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark">' .
                '<div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">'
            )
            ->setActive(url()->current())
            ->setActiveClass('m-menu__item--active')
        ;
    }

    /**
     * Return an array whit the permissions.
     *
     * @param array $options
     * @return array
     */
    private function permissions(array $options)
    {
        $permissions = [];

        foreach ($options as $option) {
            if (!isset($option['submenu'])) {
                array_push($permissions, $option['crud']);
            } else {
                $permissions = array_merge($permissions, $this->permissions($option['submenu']));
            }
        }

        return $permissions;
    }

    /**
     * Returns an array with permissions grouped by roles..
     *
     * @return array
     */
    public function roles()
    {
        $roles = [];

        foreach (config('menu') as $section) if (isset($section['name'])) array_push($roles, $section['name']);

        return $roles;
    }

    /**
     * Dynamic instance of the models.
     *
     * @param string $model
     * @return Model
     */
    public static function dynamicInstanceModel(string $model)
    {
        $model = '\\App\\' . str_replace('_', '', ucwords(str_replace('_id', '', $model), '_'));
        return  new $model;
    }

    /**
     * Return data for the specified select.
     *
     * @param string $model
     * @return \Illuminate\Http\Response
     */
    public static function select(string $model)
    {
        return Base::dynamicInstanceModel($model)->select();
    }

    /**
     * Return an array for the menu and bread crumbs.
     *
     * @return array
     */
    private function sections()
    {
        $menu = [];

        foreach (config('menu') as $section) {
            if (!isset($section['name'])) {
                $menu = array_merge($menu, $section['menu']);
            } else if (Auth::user()->hasRole($section['name'])) {
                array_push($menu, ['section' => $section['name']]);
                $menu = array_merge($menu, $section['menu']);
            }
        }

        return $menu;
    }
}