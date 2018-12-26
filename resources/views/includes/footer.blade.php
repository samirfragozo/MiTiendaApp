<footer class="m-grid__item	m-footer">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                <span class="m-footer__copyright">
                    2018 &copy; {{ config('app.name') }}
                </span>
            </div>
            <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                    @unlessrole('storekeeper')
                    <li class="m-nav__item">
                        <a href="javascript:" onclick="storekeeper()" class="m-nav__link">
                            <span class="m-nav__link-text">{{ __('app.buttons.roles.storekeeper') }}</span>
                        </a>
                    </li>
                    @endunlessrole
                    @unlessrole('provider')
                    <li class="m-nav__item">
                        <a href="{{ route('providers.index') }}" class="m-nav__link">
                            <span class="m-nav__link-text">{{ __('app.buttons.roles.provider') }}</span>
                        </a>
                    </li>
                    @endunlessrole
                </ul>
            </div>
        </div>
    </div>
</footer>
