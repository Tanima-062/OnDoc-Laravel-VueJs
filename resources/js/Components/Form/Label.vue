<script setup>
const props = defineProps(["label", "for", "extClass"]);
</script>

<template>
  <label :for="props.for" :class="props.extClass" class="form-label block mb-3 text-16 text-[#5D5D60] font-bold hover:cursor-pointer">{{ $t(props.label) }}</label>
</template>


<style lang="scss" scoped>
label {
    // font-family: "Lato";
    // font-style: normal;
    // font-size: 1rem;
    // line-height: 24px;

    // font-weight: 700;
    // font-size: 16px;
    // line-height: 24px;
    // color: #003577;
    //  text-transform: capitalize;
}
</style>
