<template>
    <h1 class="field-title text-primary-1-1 text-18 font-[700] col-span-5 mt-[72px] mb-8">
        {{ $t(sectionTitle) }}
    </h1>

    <template v-for="document in documents">
        <div class="documents col-span-5 grid grid-cols-5 mb-[52px] gap-x-[30px]">
            <div class="field">
                <h3 class="title mb-4 text-base font-bold text-16">{{ $t('Document Name') }}</h3>
                <p class="value text-base text-16">{{ document.name }}</p>
            </div>
            <div class="field">
                <h3 class="title  mb-4 text-base font-bold text-16">{{ $t('Document Type') }}</h3>
                <p class="value text-base text-16 capitalize">{{ $t(document.type) }}</p>
            </div>
            <div class="field">
                <a
                    class="relative flex items-center !justify-start px-4 bg-violet-1 text-[#2929CC] block h-[48px] rounded-[8px] w-full"
                    :href="document.file_url"
                    target="_blank"
                >
                    <ViewPdfIcon class="absolute" />
                    <span class="m-auto">{{$t('View PDF')}}</span>
                </a>
            </div>
            <div class="field">
                <a
                    class="relative flex items-center !justify-start px-4 bg-violet-1 text-[#2929CC] block h-[48px] rounded-[8px] w-full cursor-pointer"
                    @click.prevent="viewQrcode(document.id)"
                    target="_blank"
                >
                    <ViewQrCOdeIcon class="absolute" />
                    <span class="m-auto">{{$t('View QR Code')}}</span>
                </a>
            </div>
            <div class="spacer"></div>
        </div>
    </template>
</template>

<script setup>
import ViewPdfIcon from "../../../Components/Icons/ViewPdfIcon.vue"
import ViewQrCOdeIcon from "../../../Components/Icons/ViewQrCodeIcon.vue"
import { inject } from 'vue';
import ViewQrCode from "../../../Components/Modal/Content/ViewQrCode.vue";


const props = defineProps({
    documents: {
        type: Array,
        required: true,
    },
    sectionTitle: {
        type: String,
        required: true,
    }
})
const modal = inject('modal')
const viewQrcode = (id) => {
    modal.show(ViewQrCode, {
        props: {
            value: JSON.stringify({ id, type: 'document' })
        }
    })
}

</script>
