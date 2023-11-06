<template>
    <div class="flex items-end" :id="section+'-parent-div-'+index">
        <div class="w-1/5 mt-4 relative">
            <TextInput
                style="width:253px"
                :id="section + '-docname-' + index"
                :label="`${$t('Document Name')}*`"
                :placeholder="$t('Document Name')"
                class="mr-6"
                :value="doc_name"
                @update="(e) => {
                    emit('updateDocName', {
                        type: section,
                        index: index,
                        event: e,
                    })
                }"
                maxLength="31"
                tabindex="1"
            />
            <p class="absolute" style="color:red" :id="section + '-docname-' + index + '_error'"></p>
        </div>
        <div class="w-1/5 mr-6 mt-2">
            <SelectOption
                style="width:285px"
                v-model="doc_type"
                :id="section + '-doctype-' + index"
                :label="`${$t('Document Type')}*`"
                placeholder="Select Type"
                :options="types"
                @update="changeDocType"
                tabindex="2"
            />
        </div>
        <div class="w-1/5 flex">
            <div v-if="doc_type=='url'" class="mt-5">
                <TextInput
                    style="width:253px"
                    label=""
                    placeholder="File URL"
                    :value="file"
                    @update="
                        emit('updateFileURL', {
                            type: section,
                            index: index,
                            event: $event,
                        })
                    "
                    tabindex="3"
                />
            </div>
            <div v-else class="">
              <div class="pt-5 relative">
                <input
                    type="file"
                    style="display: none"
                    :id="section + '-file-' + index"
                    :class="section + '-file'"
                    @change="fileUpload($event)"
                    accept=".pdf"
                />
                <PrimaryButton
                    style="width:253px"
                    :class="
                        'flex !justify-start p-4 text-white ' + section + '-btn'
                    "
                    @click="clickBtn(section + '-file-' + index)"
                    :id="section + '-btn-' + index" tabindex="3">
                    <FileUploadIcon class="mr-12" />
                    <span v-if="file==''">{{$t('Upload PDF')}}</span>
                    <span v-else>{{$t('Change PDF')}}</span>
                </PrimaryButton>
                <div class="absolute">
                    <p style="color:red;" v-if="file_ext_error">File should be pdf</p>
                    <p style="color:red;" v-if="file_size_error">Max file size allowed is 20 MB per pdf</p>
                </div>
                <div style="position:absolute; height: 10px; width:253px; background-color: #E1DDDD; margin-top: 3px; border-radius: 5px;" v-if="show_progress_bar">
                  <div style="position:absolute; height:10px; width: 0%; background-color: #60CA15; border-radius: 5px;" :id="`progress-${section}-${index}`"></div>
                </div>
              </div>
            </div>
            <DeleteIcon
                :class="
                    'ml-4 mt-8 hover:cursor-pointer ' + section + '-remove-btn'
                "
                :id="section + '-remove-btn-' + index"
                @click="emit('removeFile', { type: section, index: index })"
            />
        </div>
    </div>
</template>

<script setup>
import PrimaryButton from "../../Components/PrimaryButton.vue";
import FileUploadIcon from "../../Components/Icons/FileUploadIcon.vue";
import DeleteIcon from "../../Components/Icons/DeleteIcon.vue";
import TextInput from "../Products/components/TextInput.vue";
import SelectOption from "./components/SelectOption.vue";
import { reactive, ref } from "vue";


const types = [
    { label: "File", value: "file" },
    { label: "URL", value: "url" },
];
const props = defineProps({
    section: String,
    index: [String, Number],
    name: {
        type: String,
        default: ''
    },
    file_type:{
        type: String,
        default: ''
    },
    file:{
        type: String,
        default: ''
    }
});
const emit = defineEmits([
    "removeFile",
    "uploadFile",
    "updateDocType",
    "updateDocName",
]);

const doc_name = ref(props.name)
const doc_type = ref(props.file_type)
const pI = ref(props.index+1)
const file_ext_error = ref(false)
const file_size_error = ref(false)
const show_progress_bar = ref(false)

const clickBtn = (id) => {
    file_ext_error.value = false
    file_size_error.value = false
    show_progress_bar.value = false
    document.getElementById(id).click();
};

const changeDocType = (e) => {
    var filepath = ''
    show_progress_bar.value = false
    if(doc_type.value == '' && e == 'file' && props.file != ''){
        filepath = props.file
        show_progress_bar.value=true
    }
    doc_type.value = e
    emit('updateDocType', {
        type: props.section,
        index: props.index,
        file: filepath,
        event: e,
    })
}

const fileUpload = (e) => {
    var filenames = e.target.files[0].name.split('.');
    var ext = filenames[filenames.length - 1];
    var size = e.target.files[0].size / 1024 / 1024
    var sizeMB = size.toFixed(2);
    if(ext != 'pdf'){
        file_ext_error.value = true
    }
    if(sizeMB > 20){
        file_size_error.value = true
    }else{
        show_progress_bar.value=true
        emit('uploadFile', {
            type: props.section,
            index: props.index,
            event:e,
        })
    }
}

</script>
<style lang="scss">

</style>
