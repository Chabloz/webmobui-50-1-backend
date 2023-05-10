<script setup>
  import { ref } from 'vue';
  import TheFormLogin from './chat/components/TheFormLogin.vue';
  import TheChat from './chat/components/TheChat.vue';
  import BaseMessageWarning from './components/BaseMessageWarning.vue';

  const page = ref("login");
  const showConnectionError = ref(false);
</script>

<template>
  <div class="column items-center">
    <base-message-warning v-if="showConnectionError">
      Problems with the connection to the chat. Please try again later.
    </base-message-warning>

    <h1 class="row text-h2">Chat IM</h1>

    <the-form-login
      v-if="page=='login'"
      class="row"
      @login="page='chat'"
      @conn-error="showConnectionError=true"
      @conn-ok="showConnectionError=false"
    />

    <the-chat
      v-if="page=='chat'"
      class="row"
    />
  </div>
</template>