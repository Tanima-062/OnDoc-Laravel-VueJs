<template>
    <div class="grid grid-cols-2">
        <div class="contnet min-h-screen bg-background">
            <slot />
        </div>
        <div class="image h-full w-full relative flex items-end justify-end">
            <img
                src="/images/left_background.png"
                class="h-full w-full absolute z-[-1]"
            >
            <div class="languages flex ] gap-[27px] z-1 mb-[50px] mr-[40px]">
                <slot name="lanuage"></slot>
            </div>
        </div>
    </div>
</template>
