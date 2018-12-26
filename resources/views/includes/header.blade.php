<header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-brand m-brand--skin-dark">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                            <img src="{{ asset('img/logo_default_dark.png') }}" />
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <a href="javascript:" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                            <span></span>
                        </a>
                        <a href="javascript:" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark">
                    <div class="m-subheader" style="margin-top: -15px">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">@yield('title')</h3>
                                {{ (new \App\Utils\Base())->breadCrumbs() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            @role('storekeeper')
                            <li class="m-nav__item">
                                <a href="{{ route('storekeeper.cart.index') }}" class="m-nav__link">
                                    <span class="m-nav__link-badge"><span class="m-badge m-badge--danger">{{ Cart::session('providers_' . auth()->id())->getContent()->count() }}</span></span>
                                    <span class="m-nav__link-icon"><i class="fa fa-box-open"></i></span>
                                </a>
                            </li>
                            @endrole
                            <li class="m-nav__item">
                                <a href="{{ route('cart.index') }}" class="m-nav__link">
                                    <span class="m-nav__link-badge"><span class="m-badge m-badge--danger">{{ Cart::session('stores_' . auth()->id())->getContent()->count() }}</span></span>
                                    <span class="m-nav__link-icon"><i class="fa fa-shopping-cart"></i></span>
                                </a>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        <span class="m-type m--bg-brand">
                                            <span class="m--font-light">{{ str_limit(Auth::user()->full_name, 1, '') }}</span>
                                        </span>
                                    </span>
                                    <span class="m-topbar__username m--hide">{{ Auth::user()->full_name }}</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center m--bg-brand">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <span class="m-type m-type--lg m--bg-danger">
                                                        <span class="m--font-light">{{ str_limit(Auth::user()->full_name, 1, '') }}</span>
                                                    </span>
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">{{ str_limit(Auth::user()->full_name, 30, '...') }}</span>
                                                    <a class="m-card-user__email m--font-weight-300 m-link">{{ str_limit(Auth::user()->email, 50, '...') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('user.index') }}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-user"></i>
                                                            <span class="m-nav__link-text">{{ __('app.titles.user') }}</span>
                                                        </a>
                                                    </li>
                                                    @role('provider')
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('providers.index') }}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-store"></i>
                                                            <span class="m-nav__link-text">{{ __('app.titles.providers_rol') }}</span>
                                                        </a>
                                                    </li>
                                                    @endrole
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                                        document.getElementById('logout-form').submit();"
                                                           class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            {{ __('base.buttons.logout') }}
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
