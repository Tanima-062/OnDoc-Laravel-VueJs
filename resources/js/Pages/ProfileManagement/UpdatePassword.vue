<template>
  <div class="card w-full bg-white p-8 rounded-[24px]">
    <Back :backPrevUrl="true" :showModal="form.isDirty" />
    <h1 class="page-title mb-[37px]">{{ $t("Change Password") }}</h1>

    <form @submit.prevent="submit">
      <div class="inputs-wrapper grid grid-cols-4 mb-[54px] gap-[33px]">
        <PasswordInput
          label="Enter Old Password"
          placeholder="Enter Old Password"
          v-model="form.current_password"
          :error="form.errors.current_password"
          @clearError="form.clearErrors('current_password')"
        />
      </div>

      <div class="inputs-wrapper grid grid-cols-4 mb-[54px] gap-x-[33px]">
        <PasswordInput
          label="Enter New Password"
          placeholder="Enter New Password"
          v-model="form.password"
          :showTooltip="true"
          :error="form.errors.password"
          @clearError="form.clearErrors('password', 'password_confirmation')"
        />
        <PasswordInput
          label="Repeat the New Password"
          placeholder="Repeat the New Password"
          v-model="form.password_confirmation"
          :showTooltip="true"
          :error="form.errors.password_confirmation"
          @clearError="form.clearErrors('password_confirmation')"
        />
      </div>

      <div class="inputs-wrapper grid grid-cols-4 mb-[54px] gap-[33px]">
        <PrimaryButton
          class="w-full text-white text-[18px] leading-[22px] font-montserrat font-bold"
          type="submit"
          >{{ $t("Submit") }}</PrimaryButton
        >
        <Cancel target="/" :backPrevUrl="true" />
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Back from "../../Components/Form/Back.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import PasswordInput from "../../Components/Form/PasswordInput.vue";
import Cancel from "../../Components/Form/Cancel.vue";

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
    form.clearErrors()
  form.put(route("profile-management.update-password"), {
    onSuccess: () => {},
  });
};
</script>
