@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} 
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
    <div class="card">
    <div class="card-body">
    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
        <h4 id="form-offcanvasLabel" class="mb-0">{{ isset($payment) ? __('frontend.edit_payment') : __('frontend.create_payment') }}</h4>
        <a href="{{ route('backend.payment.index')}}" class="btn btn-primary">{{ __('frontend.back') }}</a>
    </div>
    <form id="payment-form" enctype="multipart/form-data" method="POST" action="{{ route('backend.payment.store')}}">
        @csrf
        <input type="hidden" name="id" value="{{ isset($payment) ? $payment->id : null }}">       
        <div class="form-group">
            <label class="form-label" for="user_id">{{ __('frontend.admin') }} <span class="text-danger">*</span></label>
            <select class="form-select select2" id="user_id" name="user_id">
                <option value="" disabled selected>{{ __('frontend.select_user') }}</option>
                @foreach ($users as $user)
                    <option value="{{ (isset($payment) ? $payment->user : $user->id ) }}" {{ (isset($payment) && $payment->user_id == $user->id) ? 'selected' : '' }}>{{ $user->getFullNameAttribute() }}</option>
                @endforeach
            </select>
            <span class="error text-danger"></span>
        </div>

        
        <div class="form-group">
            <label class="form-label" for="plan_id">{{ __('frontend.plans') }} <span class="text-danger">*</span></label>
            <select class="form-select select2" id="plan_id" name="plan_id">
                <option value="" disabled selected>{{ __('frontend.select_plan') }}</option>
                @foreach ($plans as $plan)
                    <option value="{{ $plan->id }}" 
                            data-base-price="{{ $plan->has_discount ? $plan->discounted_price : $plan->price }}"
                            data-tax="{{ $plan->tax }}"
                            {{ (isset($payment) && $payment->plan_id == $plan->id) ? 'selected' : '' }}>
                        {{ $plan->name }} 
                        ({{ $plan->duration . '-' . str_replace('ly', '', $plan->type) }})
                    </option>
                @endforeach
            </select>
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label class="form-label" for="amount">{{ __('frontend.amount') }}</label>
            <input type="text" id="amount_display" class="form-control" placeholder="{{ __('frontend.enter_amount') }}" value="{{ isset($payment) ? $payment->amount_display : '' }}" readonly>
            <input type="hidden" id="amount" name="amount" value="{{ isset($payment) ? $payment->amount : '' }}" />
            <span class="error text-danger"></span>
        </div>

 

        <div class="form-group">
            <label class="form-label" for="payment_date">{{ __('frontend.payment_date') }} <span class="text-danger">*</span></label>
            <input type="date" id="payment_date" name="payment_date" placeholder="{{ __('frontend.payment_date_placeholder') }}" value="{{ isset($payment) ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>

     
        <button type="submit" class="btn btn-primary mt-4">{{ __('frontend.submit') }}</button>
    </form>
</div>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script>
    // Initialize form validation
    $("#payment-form").validate({
        rules: {
            user_id: { required: true },
            plan_id: { required: true },
            payment_date: { required: true, date: true }
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
            $(form).trigger("submit");
        }
    });

    // Plan selection change handler
    $('#plan_id').change(function(){
        var selectedPlan = $('#plan_id option:selected');
        var basePrice = parseFloat(selectedPlan.data('base-price')) || 0;
        var tax = parseFloat(selectedPlan.data('tax')) || 0;
        var totalAmount = basePrice + tax;

        // Update price display with total amount (base price + tax)
        $('#amount_display').val(formatCurrency(totalAmount));
        $('#amount').val(totalAmount);
    });

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount) ;
    }
    
    // Initialize date picker if flatpickr is available
    document.addEventListener('DOMContentLoaded', function () {
        const paymentDateInput = document.getElementById('payment_date');

    if (typeof flatpickr !== typeof undefined) {
        flatpickr(paymentDateInput, {
            dateFormat: "Y-m-d", // Adjust the date format as needed
            maxDate: "today", 
            onReady: function(selectedDates, dateStr, instance) {
                // Check if the body has the 'dark' class
                    if (document.body.classList.contains('dark')) {
                        instance.calendarContainer.classList.add('flatpickr-dark'); // Add a custom class for dark mode
                    }
                }
            });
        }
    });

    </script>

@endpush
