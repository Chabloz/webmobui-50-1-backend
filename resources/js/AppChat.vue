<script setup>
  import { ref } from 'vue';
  import TheFormLogin from './chat/components/TheFormLogin.vue';
  import TheFormMessage from './chat/components/TheFormMessage.vue';
  import TheChat from './chat/components/TheChat.vue';
  import TheUsers from './chat/components/TheUsers.vue';
  import BaseMessageWarning from './components/BaseMessageWarning.vue';


  const page = ref('login');
  const showConnectionError = ref(false);

  function logout() {
    fetch('/api/user/logout');
    page.value = 'login';
  }
</script>

<template>
  <div class="column items-center">
    <base-message-warning v-if="showConnectionError">
      Problems with the connection to the chat. Please try again later.
    </base-message-warning>

    <h1 class="row text-h2">Chat IM</h1>

    <div v-if="page=='login'" class="row full-width justify-center">
        <the-form-login
          class="col-6 col-md-4"
          @login="page='chat'"
          @conn-error="showConnectionError=true"
          @conn-ok="showConnectionError=false"
        />
    </div>

    <template v-if="page=='chat'">

      <div class="row full-width justify-center">
        <the-chat class="col-6 col-md-4"/>
      </div>

      <div class="row full-width justify-center q-mb-sm">
        <the-users class="col-6 col-md-4"/>
      </div>

      <div class="row full-width justify-center">
        <the-form-message
          class="col-6 col-md-4"
          @conn-error="showConnectionError=true"
          @conn-ok="showConnectionError=false"
        />
      </div>

      <q-btn @click="logout()" label="Logout" dense flat icon="logout" color="secondary"/>

    </template>
  </div>
</template>