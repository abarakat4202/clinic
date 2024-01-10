<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/tabler-icons.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/fontawesome.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/flag-icons.css')) }}" />
<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css' . $configData['rtlSupport'] . '/core.css')) }}"
    class="{{ $configData['hasCustomizer'] ? 'template-customizer-core-css' : '' }}" />
<link rel="stylesheet"
    href="{{ asset(mix('assets/vendor/css' . $configData['rtlSupport'] . '/' . $configData['theme'] . '.css')) }}"
    class="{{ $configData['hasCustomizer'] ? 'template-customizer-theme-css' : '' }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/node-waves/node-waves.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/typeahead-js/typeahead.css')) }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
<!-- Vendor Styles -->
@yield('vendor-style')
<style>
    .AppointmentStatus-Missed {
        background-color: #FF4136 !important;
        /* Red */
        color: #FFFFFF !important;
        /* White */
    }

    .AppointmentStatus-Cancelled {
        background-color: #e4e4e4 !important;
        /* Orange */
        color: #000000 !important;
        /* White */
    }

    .AppointmentStatus-Pending {
        background-color: #FFD700 !important;
        /* Gold/Yellow */
        color: #000000 !important;
        /* Black */
    }

    .AppointmentStatus-Confirmed {
        background-color: #28A745 !important;
        /* Green */
        color: #FFFFFF !important;
        /* White */
    }

    .AppointmentStatus-Rescheduled {
        background-color: #007BFF !important;
        /* Blue */
        color: #FFFFFF !important;
        /* White */
    }

    .AppointmentStatus-InProgress {
        background-color: #17A2B8 !important;
        /* Cyan/Teal */
        color: #FFFFFF !important;
        /* White */
    }

    .AppointmentStatus-Completed {
        background-color: #6F42C1 !important;
        /* Purple */
        color: #FFFFFF !important;
        /* White */
    }

    @media only screen and (max-width: 1200px) {
        .layout-navbar-hidden .layout-navbar {
            display: block !important;
        }
    }

    select[readonly].select2-hidden-accessible+.select2-container {
        pointer-events: none;
        touch-action: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
        background: #eee;
        box-shadow: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
    select[readonly].select2-hidden-accessible+.select2-container .select2-selection__clear {
        display: none;
    }
</style>

<!-- Page Styles -->
@yield('page-style')
