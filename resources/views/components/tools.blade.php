@if($crud == 'cart')
    <li class="m-portlet__nav-item">
        <a href="javascript:" onclick="order()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
            <span>
                <i class="fa fa-clipboard-list"></i>
                <span>{{ __('app.buttons.orders') }}</span>
            </span>
        </a>
    </li>
@endif
@if($reload)
    <li class="m-portlet__nav-item">
        <a onclick="createRow()"
           data-toggle="m-tooltip" data-original-title="{{__('base.buttons.reload')}}"
           class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
            <i class="fa fa-sync-alt m--font-brand"></i>
        </a>
    </li>
@endif
@if($changeStatus)
    <li class="m-portlet__nav-item">
        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
            <a data-toggle="m-tooltip" data-original-title="{{__('base.buttons.massive')}}"
               class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill m-dropdown__toggle">
                <i class="fa fa-check-square m--font-brand"></i>
            </a>
            <div class="m-dropdown__wrapper">
                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                <div class="m-dropdown__inner">
                    <div class="m-dropdown__body">
                        <div class="m-dropdown__content">
                            <ul class="m-nav">
                                <li class="m-nav__item">
                                    <a href="javascript:" class="m-nav__link" onclick="openMassive(changeStatus, 1)">
                                        <i class="m-nav__link-icon la la-check-circle"></i>
                                        <span class="m-nav__link-text">{{__('base.massive.activate')}}</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="javascript:" class="m-nav__link" onclick="openMassive(changeStatus, 0)">
                                        <i class="m-nav__link-icon la la-times-circle"></i>
                                        <span class="m-nav__link-text">{{__('base.massive.deactivate')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
@if($create)
    <li class="m-portlet__nav-item">
        <a onclick="create()"
           data-toggle="m-tooltip" data-original-title="{{__('base.buttons.create')}}"
           class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
            <i class="fa fa-plus m--font-brand"></i>
        </a>
    </li>
@endif
