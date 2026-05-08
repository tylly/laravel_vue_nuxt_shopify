<script setup>
const { login } = useSanctumAuth();

const form = reactive({
  email: "",
  password: "",
});

const handleLogin = async () => {
  await login(form);
};
</script>

<template>
  <div>
    <input v-model="form.email" type="email" placeholder="Email" />
    <input v-model="form.password" type="password" placeholder="Password" />
    <button @click="handleLogin">Login</button>
  </div>
</template>
