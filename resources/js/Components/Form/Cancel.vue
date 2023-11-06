<template>
    <button
        class="w-full h-[48px] flex justify-center items-center text-white text-18 font-bold bg-black-3 rounded-[8px]"
        @click.prevent="cancel"
    >
        {{ $t('Cancel') }}
    </button>
</template>

<script>
import { inject } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Confirmation from "../Modal/Content/Confirmation.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { trans } from "laravel-vue-i18n"
export default {
    props: {
        target: {
            type: String,
            required: true,
        },

        class: {
            type: String,
            required: false,
            default: "top",
        },

        message: {
            type: String,
            default: "Discard changes?",
        },

        backPrevUrl: {
            type: Boolean,
            default: false,
        },

        showModal: {
            type: Boolean,
            default: true,
        },

        staticBackdrop: {
            type: Boolean,
            default: true,
        },

        text: {
            type: String,
            default:
                "If you go back or cancel without saving, all changes will be discarded. Are you sure you really want to discard the changes?",
        },
    },
    components: {
        Confirmation,
    },

    setup(props) {
        const modal = inject("modal");
        let prev_url = usePage().props.value.prev_url;

        const cancel = (e) => {
            e.preventDefault();

            if (!props.showModal) {
                if (props.backPrevUrl && prev_url !== null) {
                    Inertia.visit(prev_url);
                } else {
                    Inertia.visit(props.target);
                }
                return;
            }

            modal.show(Confirmation, {
                config: {
                    staticBackdrop: props.staticBackdrop,
                },
                props: {
                    class: "top",
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
                    },
                    noClick: () => {
                        modal.hide();
                    },
                },
            });
        };
        return {
            cancel,
        };
    },
};
</script>
