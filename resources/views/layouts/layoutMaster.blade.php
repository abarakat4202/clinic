@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = Helper::appClasses();
    $isNavbar = true;
    $navbarType = 'layout-navbar-hidden';

@endphp

@isset($configData['layout'])
    @include(
        $configData['layout'] === 'horizontal'
            ? 'layouts.horizontalLayout'
            : ($configData['layout'] === 'blank'
                ? 'layouts.blankLayout'
                : ($configData['layout'] === 'front'
                    ? 'layouts.layoutFront'
                    : 'layouts.contentNavbarLayout')))
@endisset
