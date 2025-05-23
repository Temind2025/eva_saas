<template>
  <div class="offcanvas-body">
    <div class="form-group d-flex align-items-center justify-content-between">
      <label for=""> {{ $t('messages.Subtotal') }}: </label>
      <strong>{{ formatCurrencyVue(subtotal || 0) }}</strong>
    </div>
    <div class="form-group d-flex align-items-center justify-content-between" v-for="(tax, index) in taxes" :key="index">
      <template v-if="tax.type == 'percent'">
        <label for="">{{ tax.title }}: {{ tax.value + '%' }}</label>
        <strong>+  {{ formatCurrencyVue(calculatePercentAmount(tax.value) )}}</strong>
      </template>
      <template v-else>
        <label for="">{{ tax.title }}: </label>
        <strong>+ {{ formatCurrencyVue(tax.value) }}</strong>
      </template>
    </div>
    <div class="form-group row">
      <div class="col-8">
        <label for="">{{ $t('messages.Tips') }}: <span class="gap-1" @click="addTip(18)">18%</span> <span class="gap-1" @click="addTip(20)">20%</span> <span class="gap-1" @click="addTip(22)">22%</span></label>
      </div>
      <div class="col-4">
        <div class="row">
          <div class="col-md-9 p-0"><input type="number" min="0" @input="checkTip" class="form-control" pattern="[0-9]+" v-model="data.tip" max="999999" step="any" /></div>
          <div class="col-md-1 p-2">
            <strong>{{ currency_symbol }}</strong>
          </div>
        </div>
      </div>
    </div>
    <hr />

    <div class="form-group d-flex align-items-center justify-content-between">
      <label for=""> {{ $t('messages.Total') }}: </label>
      <strong>{{ formatCurrencyVue(finalAmount) }}</strong>
    </div>
    <div v-if="check_coupon || coupondiscount > 0" class="form-group d-flex align-items-center justify-content-between">
      <label for="">  {{ $t('messages.Coupon_discount') }}: </label>
      <strong class="text-danger"> -{{ formatCurrencyVue(check_coupon ? check_coupon.discount : coupondiscount) }} </strong>
    </div>

    <div v-if="check_coupon || coupondiscount > 0" class="form-group d-flex align-items-center justify-content-between border-top">
      <label for=""> {{ $t('messages.Final_total') }}: </label>
      <strong class="text-success">{{ formatCurrencyVue(check_coupon ? finalAmount - check_coupon.discount : finalAmount - coupondiscount) }}</strong>
    </div>

    <div class="d-grid gap-3 grid-cols-2">
      <template v-for="(item, index) in PAYMENT_METHODS_OPTIONS" :key="index">
        <input type="radio" class="form-check-input btn-check" :id="`${item.id}-payment-method`" autocomplete="off" :value="item.id" v-model="data.payment_method" :checked="data.payment_method == item.id" />
        <label class="btn btn-border mb-0" :for="`${item.id}-payment-method`">{{ item.text }}</label>
      </template>
    </div>
    <div v-if="!subtotal==0">
      <div v-if="!check_coupon " class="">
        <div class="d-flex align-items-center justify-content-between">
          <div class="row mt-4">
            <div class="col-md-8">
              <InputField class="col-md-12" type="text" :label="$t('Have a discount coupon')" placeholder="" v-model="data.coupon_code" :is-read-only="isCouponApplied"></InputField>
            </div>
            <div class="col-md-4">
              <button v-if="!isCouponApplied" type="button" class="btn btn-primary btn-apply mt-5" @click="couponValidate">{{ $t('messages.Apply') }}</button>
              <button v-if="isCouponApplied" type="button" class="btn btn-danger btn-remove mt-5" @click="removeCoupon">{{ $t('messages.Remove') }}</button>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { PAYMENT_CREATE_URL, coupon_validate } from '../../constant/booking'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import InputField from '@/vue/components/form-elements/InputField.vue'
const { listingRequest, updateRequest } = useRequest()

const props = defineProps({
  bookingId: { tyepe: [String, Number], required: true },
  bookingStatus: { tyepe: [String, Number], required: true },
  packageService:{ tyepe :[Object], required: false}

})

const emit = defineEmits(['updatePaymentData'])
const taxes = ref([])
const data = reactive({
  booking_amount: 0,
  payment_method: 'cash',
  final_amount: 0,
  tip: 0,
  coupon_code: '',
  coupon_discount_type: '',
  coupon_discount_value: 0,
  coupon_discount_percentage: 0,
  coupondiscount: 0,
  taxes: [],
  userpackageRedeem:[],
  packageService:props.packageService
})
const PAYMENT_METHODS_OPTIONS = ref([])
const addTip = (tipPercentage) => {
  data.tip = calculatePercentAmount(tipPercentage)
}
const checkTip = (value) => {
  if (Number(value.target.value) < 0) {
    return (data.tip = 0)
  }
}

const formatCurrencyVue = (value) => {
  if (window.currencyFormat !== undefined) {
    return window.currencyFormat(value)
  }
  return value
}
const check_coupon = ref(null)

onMounted(() => {
  const userPackageserviceIds = props.packageService.map(service => service.id);

  listingRequest({ url: PAYMENT_CREATE_URL, data: { booking_id: props.bookingId ,userPackageserviceIds:userPackageserviceIds} }).then((res) => {
    if (res.status) {
      data.booking_amount = res.data.booking_amounts.amount
      data.product_amount = res.data.booking_amounts.product_amount
      data.package_amount = res.data.booking_amounts.package_amount
      data.currency = res.data.booking_amounts.currency
      data.userpackageRedeem=res.data.userpackageRedeem
      taxes.value = res.data.tax
      PAYMENT_METHODS_OPTIONS.value = res.data.PAYMENT_METHODS
      data.taxes = taxes.value.map((tx) => {
        return {
          name: tx.title,
          type: tx.type,
          percent: tx.type == 'percent' ? tx.value : 0,
          tax_amount: tx.type != 'percent' ? tx.value : 0
        }
      })
      if (res.data.coupon) {
        check_coupon.value = res.data.coupon
      }
    }
  })
})

const calculatePercentAmount = (percent) => {
  const percentAmount = ((data.booking_amount + data.product_amount +data.package_amount) * percent) / 100

  return percentAmount
}
const subtotal = computed(() => {
  return data.booking_amount + data.product_amount + data.package_amount;
})
const currency_symbol = computed(() => {
  return data.currency
})

const taxAmount = computed(() => {
  let totalTaxAmount = 0
  for (const tax of data.taxes) {
    if (tax.type === 'percent') {
      totalTaxAmount += ((data.booking_amount + data.product_amount+ data.package_amount) * tax.percent) / 100
    } else {
      totalTaxAmount += tax.tax_amount
    }
  }

  return totalTaxAmount.toFixed(2)
})
const finalAmount = computed(() => {
  const tip_amount = String(data.tip).replace('$', '')
  submitPayment()
  const val = Number(subtotal.value) + Number(taxAmount.value) + Number(tip_amount) || 0
  return val
})
const submitPayment = () => {
  emit('updatePaymentData', data)
}

//coupon validation

const isCouponApplied = ref(false)

const couponValidate = () => {
  const coupon = { coupon_code: data.coupon_code,service_price:data.booking_amount }
  updateRequest({ url: coupon_validate, body: coupon }).then((res) => {
    if (res.status) {
      data.coupon_code = res.data.coupon_code
      data.coupon_discount_type = res.data.discount_type
      data.coupon_discount_value = res.data.discount_value
      data.coupon_discount_percentage = res.data.discount_percentage
      data.valid = res.valid
      isCouponApplied.value = true
      data.message = ''
      data.coupondiscount = coupondiscount.value

      Swal.fire({
        title: $t('messages.title_saved') + '<br>' + formatCurrencyVue(coupondiscount.value),
        icon: 'success',
        width: 300,
        //showConfirmButton:false,
        confirmButtonText: $t('messages.go_to_payment'),
        padding: '3em',
        timer: 3000,

        footer: $t('messages.coupon_applied_to_your_order'),
        background: '#fff url(https://media.giphy.com/media/xT9IgMgdur6larNA1a/giphy.gif) no-repeat',
        backdrop: `
                  url("https://media.giphy.com/media/xT9IgMgdur6larNA1a/giphy.gif")
                  center top
                  no-repeat
                `,
        showClass: {
          popup: 'animate__animated animate__zoomIn'
        },
        hideClass: {
          popup: 'animate__animated animate__zoomOut'
        }
      })
    } else {
      data.message = res.message
      data.coupon_code = ''
      Swal.fire({
        title: 'invalid coupon !',
        text: data.message,
        icon: 'warning',
        showClass: {
          popup: 'animate__animated animate__zoomIn'
        },
        hideClass: {
          popup: 'animate__animated animate__zoomOut'
        }
      })
    }
  })
}

const coupondiscount = computed(() => {
  if (isCouponApplied.value == true && data.valid == true) {
    if (data.coupon_discount_type === 'percent') {
      return (Number(subtotal.value) + Number(taxAmount.value) + data.tip) * (data.coupon_discount_percentage / 100)
    } else {
      return data.coupon_discount_value
    }
  } else {
    data.coupon_code = ''
    return 0
  }
})

const removeCoupon = () => {
  data.coupon_code = ''
  isCouponApplied.value = false
  coupondiscount.value = 0
}

// ---------------end coupon
</script>
