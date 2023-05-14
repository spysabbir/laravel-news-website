<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{(Route::currentRouteName() == 'admin.dashboard') ? 'active' : ''}}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    <!-- Super Admin Panel -->
    @if (Auth::guard('admin')->user()->role == 'Super Admin')
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Super Admin Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.default.setting' || Route::currentRouteName() == 'admin.page_setting.index' || Route::currentRouteName() == 'admin.mail.setting' || Route::currentRouteName() == 'admin.seo.setting' || Route::currentRouteName() == 'admin.social-login.setting') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <div data-i18n="Settings">Settings</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'admin.default.setting') ? 'active' : ''}}">
                <a href="{{ route('admin.default.setting') }}" class="menu-link">
                    <div data-i18n="Default Setting">Default Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.mail.setting') ? 'active' : ''}}">
                <a href="{{ route('admin.mail.setting') }}" class="menu-link">
                    <div data-i18n="Mail Setting">Mail Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.page_setting.index') ? 'active' : ''}}">
                <a href="{{ route('admin.page_setting.index') }}" class="menu-link">
                    <div data-i18n="Page Setting">Page Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.seo.setting') ? 'active' : ''}}">
                <a href="{{ route('admin.seo.setting') }}" class="menu-link">
                    <div data-i18n="Seo Setting">Seo Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.social-login.setting') ? 'active' : ''}}">
                <a href="{{ route('admin.social-login.setting') }}" class="menu-link">
                    <div data-i18n="Social Login Setting">Social Login Setting</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.all.administrator') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="Administrator">Administrator</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
            <a href="{{ route('admin.administrator.register') }}" class="menu-link">
                <div data-i18n="Register">Register</div>
            </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.all.administrator') ? 'active' : ''}}">
            <a href="{{ route('admin.all.administrator') }}" class="menu-link">
                <div data-i18n="All Administrator">All Administrator</div>
            </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.about.us') ? 'active' : ''}}">
        <a href="{{ route('admin.about.us') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="About Us Page">About Us Page</div>
        </a>
    </li>
    @endif
    <!-- Super Admin Panel -->

    <!-- Admin Panel -->
    @if (Auth::guard('admin')->user()->role != 'Reporter')
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Admin Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.all.user') ? 'active' : ''}}">
        <a href="{{ route('admin.all.user') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="All User">All User</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.all.subscriber' || Route::currentRouteName() == 'admin.all.newsletter') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <div data-i18n="Subscriber">Subscriber</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'admin.all.subscriber') ? 'active' : ''}}">
                <a href="{{ route('admin.all.subscriber') }}" class="menu-link">
                    <div data-i18n="All Subscriber">All Subscriber</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.all.newsletter') ? 'active' : ''}}">
                <a href="{{ route('admin.all.newsletter') }}" class="menu-link">
                    <div data-i18n="All Newsletter">All Newsletter</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.all.contact.message') ? 'active' : ''}}">
        <a href="{{ route('admin.all.contact.message') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="All Contact Message">All Contact Message</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.advertisement.index') ? 'active' : ''}}">
        <a href="{{ route('admin.advertisement.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Advertisement">Advertisement</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.photo_gallery.index') ? 'active' : ''}}">
        <a href="{{ route('admin.photo_gallery.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Photo Gallery">Photo Gallery</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.video_gallery.index') ? 'active' : ''}}">
        <a href="{{ route('admin.video_gallery.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Video Gallery">Video Gallery</div>
        </a>
    </li>
    @endif
    <!-- Admin Panel -->

    <!-- Reporter Panel -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Reporter Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'admin.category.index' || Route::currentRouteName() == 'admin.tag.index' || Route::currentRouteName() == 'admin.news.create' || Route::currentRouteName() == 'admin.news.index' || Route::currentRouteName() == 'admin.news.edit' || Route::currentRouteName() == 'admin.news.show') ? 'active open' : ''}}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="News interface">News interface</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'admin.category.index') ? 'active' : ''}}">
                <a href="{{ route('admin.category.index') }}" class="menu-link">
                    <div data-i18n="Category">Category</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.tag.index') ? 'active' : ''}}">
                <a href="{{ route('admin.tag.index') }}" class="menu-link">
                    <div data-i18n="Tag">Tag</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'admin.news.create' || Route::currentRouteName() == 'admin.news.index' || Route::currentRouteName() == 'admin.news.edit' || Route::currentRouteName() == 'admin.news.show') ? 'active' : ''}}">
                <a href="{{ route('admin.news.index') }}" class="menu-link">
                    <div data-i18n="News">News</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
