<template>
    <div>
        <div class="container-box">
            <Back
                :backPrevUrl="true"
                :show-modal="form.isDirty"
            />
            <div class="page-title">{{ $t('Add New Product Document') }}</div>
            <div class="flex mt-6 items-center">
                <div class="w-1/5 items-start flex flex-col">
                    <label class="form-label block mb-6 text-16 text-[#5D5D60] font-bold"
                        >{{ $t('Product ID') }}</label>
                    <div class="text-input mb-2" id="product-id">{{latest_id}}</div>
                </div>
                <div class="relative w-1/5 mt-2">
                    <TextInput
                        style="width:253px"
                        id="serial_number"
                        :label="`${$t('Serial Nr.')}*`"
                        placeholder="Serial Nr."
                        class="mr-6"
                        v-model="form.serial_number"
                        tabindex="1"
                        maxLength="16"
                        @keyup="checkLength($event,'serial_number',15)"
                    />
                    <p class="absolute" style="color:red" id="serial_number_error"></p>
                </div>
                <div class="relative w-1/5">
                    <label class="form-label block mb-4 text-16 text-[#5D5D60] font-bold">{{ $t("Warranty Start Date") }}</label>
                    <DateTimePicker
                        v-model="form.warranty_start_date"
                        mode="date"
                        icon="true"
                    />
                </div>
                <div class="relative w-1/5">
                    <label class="form-label block mb-4 text-16 text-[#5D5D60] font-bold">{{ $t("Warranty End Date") }}</label>
                    <DateTimePicker
                        v-model="form.warranty_end_date"
                        mode="date"
                        icon="true"
                    />
                </div>
            </div>
            <div class="flex mt-6 items-center">
                <div class="relative w-1/5 mt-2">
                    <TextInput
                        style="width:253px"
                        id="product_name"
                        :label="`${$t('Product Name')}*`"
                        placeholder="Product Name"
                        class="mr-6"
                        v-model="form.name"
                        maxLength="31"
                        @keyup="checkLength($event,'product_name',30)"
                    />
                    <p class="absolute" style="color:red" id="product_name_error"></p>
                </div>
                <div class="w-1/5 mr-6 mt-2">
                    <SelectOption
                        style="width:285px"
                        :label="`${$t('Supplier')}*`"
                        placeholder="Select Supplier"
                        :options="suppliers"
                        id="supplier_id"
                        v-model="form.supplier_id"
                        tabindex="2"
                        @click="form.isDirty=true"
                    />
                </div>
                <div class="w-1/5 mr-6 mt-2">
                    <SelectOption
                        style="width:285px"
                        :label="`${$t('Category')}*`"
                        placeholder="Select Category"
                        :options="categories"
                        id="category_id"
                        v-model="form.category_id"
                        tabindex="3"
                        @click="form.isDirty=true"
                    />
                </div>
                <div class="w-1/5">
                    <div class="form-label block mb-3 text-16 text-[#5D5D60] font-bold">{{ $t('PDF Access') }}</div>
                    <CheckBoxInput
                        label="Allow Public View"
                        id="public_access"
                        :isChecked="form.public_access"
                        @setValue="(e) => {form.public_access = e; form.isDirty=true}"
                        tabindex="4"
                    />
                </div>
            </div>
            <div class="mt-6">
                <div class="form-title">{{ $t('Technical documents') }}</div>
                <div class="mt-6">
                    <div id="technical">
                        <FormGenerateComponent
                            v-for="(file, i) in form.technical"
                            :key="i"
                            section="technical"
                            :index="i"
                            :file = "file.file"
                            @uploadFile="fileUpload"
                            @removeFile="fileRemove"
                            @updateDocType="setValue"
                            @updateDocName="setName"
                            @updateFileURL="setFileURL"
                        />
                    </div>
                    <div>
                        <Button class="mt-6 flex !justify-start p-4 text-black" style="width:253px"  @click="incrementFile('technical')"
                        id="technical-add-btn"
                            ><PlusIcon class="mr-12" /><span
                                >{{ $t('Add more') }}</span
                            ></Button
                        >
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <div class="form-title">{{ $t('Supplier documents') }}</div>
                <div class="mt-6">
                    <div id="supplier">
                        <FormGenerateComponent
                            v-for="(file, i) in form.supplier"
                            :key="i"
                            section="supplier"
                            :index="i"
                            :file = "file.file"
                            @uploadFile="fileUpload"
                            @removeFile="fileRemove"
                            @updateDocType="setValue"
                            @updateDocName="setName"
                            @updateFileURL="setFileURL"
                        />
                    </div>
                    <div>
                        <Button class="mt-6 flex !justify-start p-4 text-black" style="width:253px"  @click="incrementFile('supplier')"
                        id="supplier-add-btn">
                            <PlusIcon class="mr-12" />
                            <span>{{ $t('Add more') }}</span>
                        </Button>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <div class="form-title">{{ $t('Drawings') }}</div>
                <div class="mt-6">
                    <div id="drawing">
                        <FormGenerateComponent
                            v-for="(file, i) in form.drawing"
                            :key="i"
                            section="drawing"
                            :index="i"
                            :file = "file.file"
                            @uploadFile="fileUpload"
                            @removeFile="fileRemove"
                            @updateDocType="setValue"
                            @updateDocName="setName"
                            @updateFileURL="setFileURL"
                        />
                    </div>
                    <div>
                        <Button class="mt-6 flex !justify-start p-4 text-black" style="width:253px"  @click="incrementFile('drawing')" id="drawing-add-btn"
                            ><PlusIcon class="mr-12" /><span
                                >{{ $t('Add more') }}</span
                            ></Button
                        >
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <div class="form-title">{{ $t('Instructions') }}</div>
                <div class="mt-6">
                    <div id="instruction">
                        <FormGenerateComponent
                            v-for="(file, i) in form.instruction"
                            :key="i"
                            section="instruction"
                            :index="i"
                            :file = "file.file"
                            @uploadFile="fileUpload"
                            @removeFile="fileRemove"
                            @updateDocType="setValue"
                            @updateDocName="setName"
                            @updateFileURL="setFileURL"
                        />
                    </div>
                    <div>
                        <Button class="mt-6 flex !justify-start p-4 text-black" style="width:253px"  @click="incrementFile('instruction')"
                        id="instruction-add-btn"
                            ><PlusIcon class="mr-12" /><span
                                >{{ $t('Add more') }}</span
                            ></Button
                        >
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <div class="form-title">{{ $t('Modifications Guides') }}</div>
                <div class="mt-6">
                    <div id="modification_guide">
                        <FormGenerateComponent
                            v-for="(file, i) in form.modification_guide"
                            :key="i"
                            section="modification_guide"
                            :index="i"
                            :file = "file.file"
                            @uploadFile="fileUpload"
                            @removeFile="fileRemove"
                            @updateDocType="setValue"
                            @updateDocName="setName"
                            @updateFileURL="setFileURL"
                        />
                    </div>
                    <div>
                        <Button class="mt-6 flex !justify-start p-4 text-black" style="width:253px"  @click="incrementFile('modification_guide')" id="modification_guide-add-btn"
                            ><PlusIcon class="mr-12" /><span
                                >{{ $t('Add more') }}</span
                            ></Button
                        >
                    </div>
                </div>
            </div>
            <div class="footer mt-4 pb-4 grid grid-cols-5 gap-[30px]">
                <PrimaryButton
                    class="text-white font-bold text-18 px-[21px] py-[18px] bg-[#7059E2] text-center rounded-[8px]"
                    @click="submitForm"
                    :disabled="hasEmptyRequiredField"
                    :title="hasEmptyRequiredField==true ? $t('Please wait for the upload to be completed') : ''"
                >
                    {{ $t('Save') }}
                </PrimaryButton>
                <Cancel
                    target="#"
                    class="w-1/5"
                    :backPrevUrl="true"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import Back from "../../Components/Form/Back.vue";
import TextInput from "../../Components/Form/TextInput.vue";
import SelectOption from "../../Components/Form/SelectOption.vue";
import CheckBoxInput from "../../Components/Form/CheckBoxInput.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import Button from "../../Components/Button.vue";
import Cancel from "../../Components/Form/Cancel.vue"
import PlusIcon from "../../Components/Icons/PlusIcon.vue";
import FormGenerateComponent from "./FormGenerateComponent.vue";
import { reactive, ref } from "vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import { trans } from 'laravel-vue-i18n';
import DateTimePicker from "../../Components/Form/DatePickers/DateTimePicker.vue"

const props = defineProps(['suppliers', 'categories', 'latest_id'])
const form = reactive({
    prefix_id: props.latest_id,
    serial_number: "",
    warranty_start_date: "",
    warranty_end_date: "",
    name: "",
    supplier_id: "",
    category_id: "",
    public_access: 0,
    technical: [
        {
            name: "",
            doc_type: "",
            file: "",
        },
    ],
    supplier: [
        {
            name: "",
            doc_type: "",
            file: "",
        },
    ],
    drawing: [
        {
            name: "",
            doc_type: "",
            file: "",
        },
    ],
    instruction: [
        {
            name: "",
            doc_type: "",
            file: "",
        },
    ],
    modification_guide: [
        {
            name: "",
            doc_type: "",
            file: "",
        },
    ],
    technical_count: 1,
    supplier_count: 1,
    drawing_count: 1,
    instruction_count: 1,
    modification_guide_count: 1,
    isDirty: false
});
const hasEmptyRequiredField = ref(false)

const incrementFile = (type) => {
    form[type].push({
        name: "",
        doc_type: "",
        file: "",
    });
    form[type+"_count"]++
    if (form[type+"_count"] > 5) {
        document.getElementById(type + "-add-btn").style.display = "none";
    }
};

const checkLength = (e, fieldName, count) => {
    form.isDirty = true;
    if (e.target.value.length > count) {
        document.getElementById(fieldName).style.border =
            "2px solid red";
        document.getElementById(fieldName + "_error").innerHTML =
            trans("Maximum :length characters allowed",{length:count});
    } else {
        document.getElementById(fieldName).style.border = "";
        document.getElementById(fieldName + "_error").innerHTML = "";
    }
}

const fileUpload = (e) => {
    form.isDirty=true;
    var formData = new FormData();
    formData.append("file", e.event.target.files[0]);
    axios
        .post(route("products.fileUpload"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress: function (progressEvent) {
                hasEmptyRequiredField.value = true
                var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                document.getElementById('progress-'+e.type+'-'+e.index).style.width = percentCompleted+'%'
            },
        })
        .then((res) => {
            form[e.type][e.index].file = res.data;
            hasEmptyRequiredField.value = false
        })
        .catch((err) => console.log(err));
};

const fileRemove = (e) => {
    form.isDirty=true;
    document.getElementById(e.type+'-parent-div-'+e.index).remove();
    form[e.type][e.index]={name:"", doc_type: "", file:""};
    form[e.type+"_count"]--
    if (form[e.type+"_count"] < 6) {
        document.getElementById(e.type + "-add-btn").style.display = "";
    }
};

const setValue = (e) => {
    form.isDirty=true;
    document.getElementById(e.type+'-doctype-'+e.index).style.border = "";
    form[e.type][e.index].doc_type = e.event;
    form[e.type][e.index].file= e.file
};

const setName = (e) => {
    form.isDirty=true;
    form[e.type][e.index].name = e.event;
    if (e.event.length > 30) {
        document.getElementById(e.type+'-docname-'+e.index).style.border =
            "2px solid red";
        document.getElementById(e.type+'-docname-'+e.index + "_error").innerHTML =
            trans("Maximum :length characters allowed",{length: 30});
    } else {
        document.getElementById(e.type+'-docname-'+e.index).style.border = "";
        document.getElementById(e.type+'-docname-'+e.index + "_error").innerHTML = "";
    }
};

const setFileURL = (e) => {
    form.isDirty=true;
    form[e.type][e.index].file = e.event;
};

const isValid = () => {

    var flag = true;

    if(form.name == ""){
        document.getElementById('product_name').style.border="2px solid red"
        flag = false;
    }else if(form.name.length > 30){
        flag = false
    }
    if(form.serial_number == ""){
        document.getElementById('serial_number').style.border="2px solid red"
        flag = false;
    }else if(form.serial_number.length > 15){
        flag = false;
    }
    if(form.supplier_id == ""){
        document.getElementById('supplier_id').style.border="2px solid red"
        flag = false;
    }
    if(form.category_id == ""){
        document.getElementById('category_id').style.border="2px solid red"
        flag = false;
    }
    form.technical.forEach(function(item, index){
        if(item.file != ""){
            if(item.name == ""){
                document.getElementById('technical-docname-'+index).style.border="2px solid red"
                flag = false;
            }else if(item.name.length > 30){
                console.log(item.name.length)
                flag = false;
            }
            if(item.doc_type == ""){
                document.getElementById('technical-doctype-'+index).style.border="2px solid red"
                flag = false;
            }
        }
    })
    form.supplier.forEach(function(item, index){
        if(item.file != ""){
            if(item.name == ""){
                document.getElementById('supplier-docname-'+index).style.border="2px solid red"
                flag = false;
            }else if(item.name.length > 30){
                flag = false;
            }
            if(item.doc_type == ""){
                document.getElementById('supplier-doctype-'+index).style.border="2px solid red"
                flag = false;
            }
        }
    })
    form.drawing.forEach(function(item, index){
        if(item.file != ""){
            if(item.name == ""){
                document.getElementById('drawing-docname-'+index).style.border="2px solid red"
                flag = false;
            }else if(item.name.length > 30){
                flag = false;
            }
            if(item.doc_type == ""){
                document.getElementById('drawing-doctype-'+index).style.border="2px solid red"
                flag = false;
            }
        }
    })
    form.instruction.forEach(function(item, index){
        if(item.file != ""){
            if(item.name == ""){
                document.getElementById('instruction-docname-'+index).style.border="2px solid red"
                flag = false;
            }else if(item.name.length > 30){
                flag = false;
            }
            if(item.doc_type == ""){
                document.getElementById('instruction-doctype-'+index).style.border="2px solid red"
                flag = false;
            }
        }
    })
    form.modification_guide.forEach(function(item, index){
        if(item.file != ""){
            if(item.name == ""){
                document.getElementById('modification_guide-docname-'+index).style.border="2px solid red"
                flag = false;
            }else if(item.name.length > 30){
                flag = false;
            }
            if(item.doc_type == ""){
                document.getElementById('modification_guide-doctype-'+index).style.border="2px solid red"
                flag = false;
            }
        }
    })

    return flag;

}

const submitForm = () => {
    if(isValid() == false){
        return;
    }
    Inertia
        .post(route("products.store"), form, {
            onError: (err) => {
                if(err.serial_number){
                    document.getElementById("serial_number_error").innerHTML=err.serial_number
                }
            }
        })
};
</script>

<style lang="scss" scoped>
.form-group {
    display: block;
    margin-bottom: 15px;
}

.form-group input {
    padding: 0;
    height: initial;
    width: initial;
    margin-bottom: 0;
    display: none;
    cursor: pointer;
}

.form-group label {
    position: relative;
    cursor: pointer;
}

.form-group label:before {
    content: "";
    -webkit-appearance: none;
    //background-color: transparent;
    border: 2px solid #5d5d60;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05),
        inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
    padding: 10px;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    cursor: pointer;
    margin-right: 5px;
}

.form-group input:checked + label:after {
    content: "";
    display: block;
    position: absolute;
    top: 2px;
    left: 9px;
    width: 6px;
    height: 14px;
    border: solid #5d5d60;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
.form-group input:checked {
    background-color: aqua;
}
</style>
