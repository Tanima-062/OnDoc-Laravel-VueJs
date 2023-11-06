    <template>
        <div class="table rounded-[24px] shadow-form bg-white w-100 px-4">
            <div class="head border-b-[1px] border-black-1 flex">
                <slot name="head"></slot>
            </div>
            <div class="body divide-y divide-black-1">
                <slot name="body"></slot>
            </div>
        </div>
    </template>
