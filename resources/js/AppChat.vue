<script setup>
  import { ref } from 'vue';
  import TheFormLogin from './chat/components/TheFormLogin.vue';
  import TheChat from './chat/components/TheChat.vue';
  const page = ref("login")
</script>

<template>
  <the-form-login v-if="page=='login'" @login="page='chat'"/>
  <the-chat v-if="page=='chat'"/>
</template>