@extends('backend.layouts.app')

@section('title')
    {{ $module_action }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
    <link rel="stylesheet" href="{{ mix('css/intlTelInput.css') }}">

@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
                <h4 id="form-offcanvasLabel" class="mb-0">
                    {{ isset($user) ? __('messages.edit') . ' ' . __('messages.admin') : __('messages.create') . ' ' . __('messages.admin') }}
                    </h4>
                <a href="{{ route('backend.users.index')}}" class="btn btn-primary">{{__('messages.back')}}</a>
            </div>
            <form id="user-form" enctype="multipart/form-data" method="POST" action="{{ route('backend.users.store')}}">
                @csrf
                <input type="hidden" name="id" value="{{ isset($user) ? $user->id : null }}">

                <div class="row align-items-center">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="first_name">{{__('messages.lbl_first_name')}} <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{__('profile.enter_first_name')}}" value="{{ isset($user) ? $user->first_name : '' }}">
                        <span class="error text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="last_name">{{__('messages.lbl_last_name')}}<span class="text-danger">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{__('profile.enter_last_name')}}" value="{{ isset($user) ? $user->last_name : '' }}">
                        <span class="error text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">{{__('messages.lbl_email')}} <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{__('profile.enter_email')}}" value="{{ isset($user) ? $user->email : '' }}">
                        @error('email')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                        <span class="error text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group mb-0">
                            <label for="mobile" class="form-label">
                                {{ __('messages.mobile') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{ __('messages.placeholder_phone') }}" value="{{ old('mobile', isset($user) ? $user->mobile : '') }}">
                            </div>
                        </div>
                        <div id="mobile-error" class="error text-danger" style="display: none;">
                            {{ __('messages.contact_required') }}
                        </div>
                    </div>

                    @if(!isset($user))
                    <div class="form-group col-md-6">
                        <label class="form-label" for="password">{{__('messages.lbl_password')}} <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{__('messages.enter_password')}}">
                        <span class="error text-danger"></span>
                        <div class="invalid-feedback" id="password_length_error" style="display: none;">{{ __('messages.password_must_be_between_8_and_12_characters') }}</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="password_confirmation">{{__('messages.confirm_password')}} <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{__('messages.enter_confirm_password')}}">
                        <span class="error text-danger"></span>
                    </div>
                    @endif
                    <div class="form-group col-md-6">
                        <label for="" class="w-100 form-label">{{__('messages.lbl_gender')}}<span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3 form-control">
                            <div class="form-check form-check-inline d-flex align-items-center gap-1">
                                <input class="form-check-input" type="radio" name="gender" value="male" {{ (!isset($user) || (isset($user) && $user->gender == 'male')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="male"> {{__('messages.male')}} </label>
                            </div>
                            <div class="form-check form-check-inline d-flex align-items-center gap-1">
                                <input class="form-check-input" type="radio" name="gender" value="female" {{ (isset($user) && $user->gender == 'female') ? 'checked' : '' }}>
                                <label class="form-check-label" for="female"> {{__('messages.female')}} </label>
                            </div>
                            <div class="form-check form-check-inline d-flex align-items-center gap-1">
                                <input class="form-check-input" type="radio" name="gender" value="other" {{ (isset($user) && $user->gender == 'other') ? 'checked' : '' }}>
                                <label class="form-check-label" for="other"> {{__('messages.intersex')}} </label>
                            </div>
                        </div>
                        <p class="mb-0 error text-danger"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">{{__('messages.status')}}</label>
                        <div class="form-group form-check form-switch form-control d-flex align-items-center justify-content-between gap-3">
                            <label class="form-label">{{__('messages.status')}}</label>
                            <input class="form-check-input" name="status" type="checkbox" {{ (isset($user) && $user->status == 0) ? '-' : 'checked' }}>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">{{__('messages.submit')}}</button>
            </form>
        </div>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ mix('js/jquery.validate.min.js') }}"></script>
<script src="{{ mix('js/intlTelInput.min.js') }}"></script>
<script src="{{ mix('js/utils.js') }}"></script>
<script>
    $(document).ready(function () {
        var input = document.querySelector("#mobile");
    var iti = window.intlTelInput(input, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{ mix('js/utils.js') }}"
    });

    $('#mobile').on('input', function () {
            const mobileValue = iti.getNumber();
            if (!iti.isValidNumber()) {
                $('#mobile').addClass('is-invalid');
                $('#mobile_error').show().text('Please enter a valid mobile number');
            } else {
                $('#mobile').removeClass('is-invalid');
                $('#mobile_error').hide();
            }
        });

        $("#user-form").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                },
                last_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                },
                email: {
                    required: true,
                    email: true,
                },

                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 12,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password",
                },
                gender: {
                    required: true,
                },
            },
            errorElement: "span",
            errorClass: "error text-danger",
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // Clear validation errors before submitting
                $(form).find('.error').remove();

                // Check password length
                const password = $('#password').val().trim();
                if (password.length < 8 || password.length > 12) {
                    $('#password_length_error').show();
                    $('#password').addClass('is-invalid');
                    return; // Stop form submission
                } else {
                    $('#password_length_error').hide();
                    $('#password').removeClass('is-invalid');
                }

                $(form).trigger("submit");
            },
        });




    // Handle form submission
$('#user-form').on('submit', function(e) {
    if (!iti.isValidNumber()) {
        e.preventDefault(); // Prevent form submission if the number is invalid
        if ($('#mobile-error').length === 0) {
            $('<div id="mobile-error"class="error text-danger" style="display: none;">Contact number field is required.</div>')
                .insertAfter('#mobile'); // Append error message after the mobile input field
        } else {
            $('#mobile-error').text('Please enter a valid mobile number.').show();
        }
    } else {
        $('#mobile-error').hide(); // Hide error message if valid
    }
});

    });
</script>

@endpush
