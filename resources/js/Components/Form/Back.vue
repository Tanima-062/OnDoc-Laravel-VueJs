<template>
    <div class="back-link text-base mb-9 text-16 font-montserrat font-bold w-fit">
        <a
            @click.prevent="goBack"
            :href="target"
            class="flex items-center cursor-pointer"
        >
            <back-arrow
                style=""
                class="mr-3"
            />{{ $t('Go Back') }}
        </a>
    </div>
</template>

<script>
import { inject } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Confirmation from "../Modal/Content/Confirmation.vue";
import BackArrow from "../Icons/BackArrow.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { trans } from "laravel-vue-i18n"

export default {
    props: {
        backPrevUrl: {
            type: Boolean,
            default: false,
        },

        target: {
            type: String,
            required: false,
            default: '/'
        },

        showModal: {
            type: Boolean,
            requried: false,
            default: true,
        },

        staticBackdrop: {
            type: Boolean,
            default: false,
        },

        message: {
            type: String,
            required: false,
            default: "Discard changes?",
        },

        text: {
            type: String,
            requried: false,
            default:
                "If you go back or cancel without saving, all changes will be discarded. Are you sure you really want to discard the changes?",
        },
    },

    components: {
        BackArrow,
    },

    setup(props) {
        const modal = inject("modal");
        let prev_url = usePage().props.value.prev_url;
        const goBack = (e) => {
            e.preventDefault();
            if (!props.showModal) {
                if (props.backPrevUrl && prev_url != null) {
                    Inertia.visit(prev_url);
                    return;
                }
                Inertia.visit(props.target);
                return;
            }
            modal.show(Confirmation, {
                config: {
                    staticBackdrop: props.staticBackdrop,
                },
                props: {
                    title: trans(props.message),
                    description: trans(props.text),
                },
                events: {
                    yesClick: () => {
                        modal.hide();

                        if (props.backPrevUrl && prev_url != null) {
                            Inertia.visit(prev_url);
                            return;
                        }
                        Inertia.visit(props.target);
                        return;
                    },
                    noClick: () => modal.hide(),
                },
            });
        };

        return {
            goBack,
        };
    },
};
</script>
