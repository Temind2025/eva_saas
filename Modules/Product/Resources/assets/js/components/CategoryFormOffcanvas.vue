<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="form-offcanvasLabel">
          <template v-if="currentId != 0">
            <span v-if="parent_id !== null">{{ editNestedTitle }}</span> <span v-else>{{ editTitle }}</span>
          </template>
          <template v-else>
            <span v-if="parent_id !== null">{{ createNestedTitle }}</span> <span v-else>{{ createTitle }}</span>
          </template>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <div class="col-md-12 text-center upload-image-box">
                <img :src="ImageViewer || defaultImage" alt="feature-image" class="img-fluid mb-2 avatar-140 rounded" />
                <div v-if="validationMessage" class="text-danger mb-2">{{ validationMessage }}</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                  <input type="file" ref="profileInputRef" class="form-control d-none" id="feature_image" name="feature_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
                  <label class="btn btn-sm btn-primary" for="feature_image">{{ $t('messages.upload') }}</label>
                  <input type="button" class="btn btn-sm btn-secondary" name="remove" :value="$t('messages.remove')" @click="removeLogo()" v-if="ImageViewer" />
                </div>
              </div>
            </div>
            <InputField :is-required="true" :label="$t('category.lbl_name')" :placeholder="$t('category.placeholder_name')" v-model="name" :error-message="errors.name" :error-messages="errorMessages['name']"></InputField>
            <div class="form-group" v-if="parent_id !== null">
              <label for="category" class="form-label">{{ $t('category.lbl_parent_category') }}</label>
              <Multiselect v-bind="singleSelectOption" v-model="parent_id" :placeholder="$t('category.placeholder_parent_category')" :value="parent_id" :options="categories"></Multiselect>
            </div>
            <div class="form-group">
              <label for="brand" class="form-label">{{ $t('category.lbl_parent_brand') }} <span class="text-danger"> *</span> </label>
              <Multiselect v-bind="multipleSelectOption" v-model="brand_id" :placeholder="$t('category.placeholder_parent_brand')" :options="brands"></Multiselect>
              <span v-if="errorMessages['brand_id']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['brand_id']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.brand_id }}</span>
            </div>
            <div v-for="field in customefield" :key="field.id">
              <FormElement v-model="custom_fields_data" :name="field.name" :label="field.label" :type="field.type" :required="field.required" :options="field.value" :field_id="field.id"></FormElement>
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center form-control">
                <label class="form-label mb-0" for="category-status">{{ $t('category.lbl_status') }}</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" :value="1" name="status" id="category-status" type="checkbox" v-model="status" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <FormFooter :IS_SUBMITED="IS_SUBMITED"></FormFooter>
    </div>
  </form>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue'
import { INDEX_LIST_URL, EDIT_URL, STORE_URL, UPDATE_URL, BRAND_LIST_URL } from '../constant/category'
import { useField, useForm } from 'vee-validate'

import * as yup from 'yup'
import { readFile } from '@/helpers/utilities'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { buildMultiSelectObject } from '@/helpers/utilities'

import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  createNestedTitle: { type: String, default: '' },
  editNestedTitle: { type: String, default: '' },
  defaultImage: { type: String, default: '' },
  customefield: { type: Array, default: () => [] },
  categoryId: { type: Number, default: 0 },
  currentId: { type: Number, default: 0 },
  isSubCategory: { type: Boolean, default: false }
})

const { getRequest, storeRequest, updateRequest } = useRequest()

const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})
const multipleSelectOption = ref({
  mode: 'tags',
  searchable: true
})
const categories = ref([])
const brands = ref([])
const category_name = ref(null)
const validationMessage = ref('');

const getCategories = () => {
  getRequest({ url: INDEX_LIST_URL }).then((res) => (categories.value = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}
const getBrands = () => {
  getRequest({ url: BRAND_LIST_URL }).then((res) => (brands.value = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

// Edit Form Or Create Form
const currentId = ref(0)
const updatecurrentId = (e) => {
  setFormData(defaultData())
  currentId.value = Number(e.detail.form_id)
  parent_id.value = e.detail.parent_id || null
  category_name.value = null
  getCategories()
  getBrands()
  if (props.isSubCategory) {
    parent_id.value = -1
  }
}
watch(
  currentId,
  () => {
    if (currentId.value > 0) {
      getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
        if (res.status) {
          setFormData(res.data)
        }
      })
    } else {
      setFormData(defaultData())
    }
  },
  { deep: true }
)

onMounted(() => document.addEventListener('crud_change_id', updatecurrentId))
onUnmounted(() => document.removeEventListener('crud_change_id', updatecurrentId))

/*
 * Form Data & Validation & Handeling
 */

// File Upload Function
const ImageViewer = ref(null)
const profileInputRef = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0];
  const maxSizeInMB = 2;
  const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

  if (file) {
    if (file.size > maxSizeInBytes) {
      // File is too large
      validationMessage.value = `File size exceeds ${maxSizeInMB} MB. Please upload a smaller file.`;
      // Clear the file input
      profileInputRef.value.value = '';
      return;
    }

    await readFile(file, (fileB64) => {
      ImageViewer.value = fileB64;
      profileInputRef.value.value = '';
      validationMessage.value = ''; 
    });
    feature_image.value = file;
  } else {
    validationMessage.value = '';
  }
};

// Function to delete Images
const removeImage = ({ imageViewerBS64, changeFile }) => {
  imageViewerBS64.value = null
  changeFile.value = null
}

const removeLogo = () => removeImage({ imageViewerBS64: ImageViewer, changeFile: feature_image })

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    parent_id: props.categoryId ?? null,
    brand_id: [],
    status: true,
    feature_image: null,
    custom_fields_data: {}
  }
}

//  Reset Form
const setFormData = (data) => {
  if (data.feature_image === props.defaultImage) {
    ImageViewer.value = null
  } else {
    ImageViewer.value = data.feature_image
  }
  category_name.value = data.category_name
  resetForm({
    values: {
      name: data.name,
      parent_id: data.parent_id,
      brand_id: data.brand_id,
      status: data.status ? true : false,
      feature_image: data.feature_image !== props.defaultImage ? data.feature_image : undefined,
      custom_fields_data: data.custom_field_data
    }
  })
}

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const errorMessages = ref({})

const reset_datatable_close_offcanvas = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#form-offcanvas').hide()
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

const numberRegex = /^\d+$/
// Validations
const validationSchema = yup.object({
  name: yup
    .string()
    .required('Sub Category name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => {
      // Regular expressions to disallow special characters and numbers
      const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
      return !specialCharsRegex.test(value) && !numberRegex.test(value)
    }),
  brand_id: yup.array().of(yup.number().required('Brand ID is required')).required('Brand name is a required field').min(1, 'At least one brand must be selected')
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })

const { value: name } = useField('name')
const { value: parent_id } = useField('parent_id')
const { value: brand_id } = useField('brand_id')
const { value: status } = useField('status')
const { value: feature_image } = useField('feature_image')
const { value: custom_fields_data } = useField('custom_fields_data')

// Form Submit
const IS_SUBMITED = ref(false)
const formSubmit = handleSubmit((values) => {
  if (IS_SUBMITED.value) return false
  IS_SUBMITED.value = true
  values.custom_fields_data = JSON.stringify(values.custom_fields_data)

  if (currentId.value > 0) {
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  }
})
</script>
