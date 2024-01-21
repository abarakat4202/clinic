@extends('layouts/layoutMaster')

@section('title', 'Users')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script>
        $('form .form-control, form .form-check-input, form select').on('invalid', function() {
            $parent = $(this).parents('.col-md-6')
            $parent.find('.error').text(
                this.validationMessage
            );
        }).on('keyup', function() {
            $(this).parents('.col-md-6').find('.error').empty()
        })

        // Update/reset user image of account page
        let accountUserImage = document.getElementById('uploadedAvatar');
        const fileInput = document.querySelector('.account-file-input'),
            resetFileInput = document.querySelector('.account-image-reset');

        if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                accountUserImage.src = resetImage;
            };
        }
    </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10 offset-xl-1">
            <form id="formAccountSettings" method="post" action="{{ request()->url() }}" novalidate="novalidate"
                class="card mb-4" enctype="multipart/form-data">
                @csrf
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $user->avatar }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                            id="uploadedAvatar">
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" name="avatar"
                                    hidden="" accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-3 waves-effect">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <div class="text-muted">Allowed JPG or PNG. Max size of 800K</div>
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="mb-3 col-md-12 fv-plugins-icon-container">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" id="name" type="text" value="{{ $user->name }}"
                                    disabled autofocus="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12 fv-plugins-icon-container">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input class="form-control" id="current_password" name="current_password" type="password"
                                    value="" autofocus="">
                                @error('current_password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12 fv-plugins-icon-container">
                                <label for="password" class="form-label">New Password</label>
                                <input class="form-control" id="password" name="password" type="password" value=""
                                    autofocus="" minlength="6">
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12 fv-plugins-icon-container">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation"
                                    type="password" value="" autofocus="" minlength="6">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Save
                                changes</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
                        </div>
                        <input type="hidden">
                    </div>
                </div>
                <!-- /Account -->
            </form>
        </div>
    </div>
@endsection
