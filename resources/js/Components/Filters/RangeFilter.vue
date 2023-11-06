<template>
    <h2 class="label text-base font-bold text-18 mb-2">{{ $t(title) }}</h2>
    <div class="filter-price-range flex-col">
        <div class="flex items-center justify-between w-full">
            <input
                id="value_start"
                class="challo__input"
                v-model="valueForm.value.start"
            />
            <span class="">
                <svg viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"
                    />
                </svg>
            </span>
            <input
                id="value_end"
                class="challo__input"
                v-model="valueForm.value.end"
            />
        </div>

        <div class="price-field">
            <input type="range" class="min-thumb" step="1" :min="minValue" :max="maxValue"  v-model="valueForm.value.start">
            <input type="range" class="max-thumb" step="1" :min="minValue" :max="maxValue"  v-model="valueForm.value.end">
        </div>
    </div>
</template>
<script>
    import { reactive, ref } from "@vue/reactivity";
    import { computed, watch } from "@vue/runtime-core";
    import { debounce as _debounce } from "lodash";
    import { Inertia } from "@inertiajs/inertia";
    export default {
        props: {
            columnKey: {
                type: String,
                required: true,
            },
            keyPrefix: {
                type: String,
                default: null,
            },
            routeName: {
                type: String,
                required: true,
            },
            options: {
                type: [Array, Object],
                default: [],
            },
            valueKey: {
                type: [String, Number],
                default: "id",
            },
            name: {
                type: [String, Number],
                default: "",
            },
            minValue: {
                type: [String, Number],
                default: 0,
            },
            maxValue: {
                type: [String, Number],
                default: 0,
            },
            title:{
                type: String,
                default: "",
            },
            variable:{
                type: String,
                default: "",
            },
        },
        setup(props, ctx) {

            const valueForm = reactive({
                value: {
                    start: props.minValue,
                    end: props.maxValue,
                },
                is_default: true,
            });

            const start_value_key = computed(()=>props.keyPrefix ? `${props.keyPrefix}_start_value` : 'start_value')
            const end_value_key = computed(()=>props.keyPrefix ? `${props.keyPrefix}_end_value` : 'end_value')

            const setValueFromUrl = () => {
                let searchParams = Object.fromEntries(
                    new URLSearchParams(location.search)
                );

                let start = null;
                let end = null;


                if (searchParams.hasOwnProperty(start_value_key.value)) {
                    start = searchParams[start_value_key.value];
                }
                if (searchParams.hasOwnProperty(end_value_key.value)) {
                    end = searchParams[end_value_key.value];
                }

                if (start && end) {
                    valueForm.value.start = start;
                    valueForm.value.end = end;
                }
            };

            setValueFromUrl();

            watch(
                () => valueForm.value,
                _debounce(function () {
                    if(valueForm.value.start == null || valueForm.value.end == null) return

                    valueForm.is_default = false;
                    Inertia.visit(
                        route(props.routeName, {
                            ...buildQueryParams(),
                        }),
                        {
                            preserveScroll: true,
                            preserveState: true,
                        }
                    );
                }, 500),
                { deep: true }
            );

            const buildQueryParams = () => {
                let searchParams = Object.fromEntries(
                    new URLSearchParams(location.search)
                );

                if (!valueForm.is_default) {
                    searchParams[start_value_key.value] = valueForm.value.start;
                    searchParams[end_value_key.value] = valueForm.value.end;
                }else {
                    if(searchParams.hasOwnProperty(start_value_key.value)) {
                        delete searchParams[start_value_key.value];
                    }
                    if(searchParams.hasOwnProperty(end_value_key.value)) {
                        delete searchParams[end_value_key.value];
                    }
                }

                if (searchParams.hasOwnProperty("page")) {
                    delete searchParams["page"];
                }

                return searchParams;
            };


            return {
                valueForm,

            };
        }
    }

</script>

<style lang="scss" scoped>
.price-field {
  position: relative;
  width: 100%;
  height: 36px;
  box-sizing: border-box;
  padding-top: 15px;
  padding-left: 0px;
  margin-bottom: 15px ;
    z-index: 9;
}

/* Reset style for input range */

.price-field input[type=range] {
    position: absolute;
    appearance: none;
    background: whitesmoke;
    width: 100%;
    height: 28px;
    outline: 0;
    box-sizing: border-box;
    border-radius: 50px;
    border:3px solid #C0C0C0 ;
    pointer-events: none;
    -webkit-appearance: none;
    padding: 2px;
}


.price-field input[type=range]:active,
.price-field input[type=range]:focus {
  outline: 0;
}

.price-field input[type=range]::-ms-track {
  width: 188px;
  height: 2px;
  border: 0;
  outline: 0;
  box-sizing: border-box;
  border-radius: 5px;
  pointer-events: none;
  background: transparent;
  color: red;
  border-radius: 5px;
}

/* Style toddler input range */

.max-thumb::-webkit-slider-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    margin-top: -6px;
    // margin-left: 15px;
}
.min-thumb::-webkit-slider-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    margin-top: -6px;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    // margin-left: 2px;
}

.max-thumb::-moz-range-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    margin-top: -6px;
    // margin-left: 15px;
}
.min-thumb::-moz-range-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    margin-top: -6px;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    // margin-left: 2px;
}

.max-thumb::-ms-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    margin-top: -6px;
    // margin-left: 15px;
}
.min-thumb::-ms-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    margin-top: -6px;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 14px;
    width: 14px;
    background-color: #569FE8;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
    // margin-left: 2px;
}

/* Style track input range */

.price-field input[type=range]::-webkit-slider-runnable-track {
  /* WebKit/Blink */
  width: 188px;
  height: 2px;
  cursor: pointer;
  border-radius: 5px;
  background: transparent;
  border: none;
}

.price-field input[type=range]::-moz-range-track {
  /* Firefox */
  width: 188px;
  height: 2px;
  cursor: pointer;
  background: #242424;
  border-radius: 5px;
}

.price-field input[type=range]::-ms-track {
  /* IE */
  width: 188px;
  height: 2px;
  cursor: pointer;
  background: #242424;
  border-radius: 5px;
}


.filter-price-range{
    display: flex;
    justify-content: space-between;
    padding-top: 10px;
    align-items: center;

    span {
        // width: 50px;
        margin-left: 5px;
        margin-right: 10px;
        color: currentColor;
        font-size: 36px;
        display: flex;
        align-items: center;
        svg {
            fill: currentColor;
            width: 18px;
            height: 18px;;
            stroke: #787878;;
        }

    }

    .clear-btn {
        outline: none;
        border: none;
        text-align: center;
        // background-color: rgb(167, 2, 2);

        font-weight: 700;

        padding: 7px 25px;
        // margin-left: 5px;;
        // border-radius: 5px;
        margin-left: 10px;
        font-family: 'Ropa Sans';


        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        cursor: pointer;
    }

}
</style>
