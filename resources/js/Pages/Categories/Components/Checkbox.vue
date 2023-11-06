<template>

    <div class="checkbox cursor-pointer">
        <template v-if="$attrs.checked">
            <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <rect
                    x="1"
                    y="1"
                    width="18"
                    height="18"
                    rx="3"
                    stroke="#7059E2"
                    stroke-width="2"
                />
                <path
                    d="M15.7072 7.70711L16.4143 7L15.0001 5.58579L14.293 6.29289L15.7072 7.70711ZM8.00004 14L7.29294 14.7071C7.68346 15.0977 8.31662 15.0976 8.70715 14.7071L8.00004 14ZM5.7071 10.2929L4.99999 9.58579L3.58579 11L4.2929 11.7071L5.7071 10.2929ZM14.293 6.29289L7.29293 13.2929L8.70715 14.7071L15.7072 7.70711L14.293 6.29289ZM4.2929 11.7071L7.29294 14.7071L8.70715 13.2929L5.7071 10.2929L4.2929 11.7071Z"
                    fill="#7059E2"
                />
            </svg>
        </template>
        <template v-else>
            <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <rect
                    x="1"
                    y="1"
                    width="18"
                    height="18"
                    rx="3"
                    stroke="#7059E2"
                    stroke-width="2"
                />
            </svg>
        </template>
    </div>

</template>

<script setup>

</script>
