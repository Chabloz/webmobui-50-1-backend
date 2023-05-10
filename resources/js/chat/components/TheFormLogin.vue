<script setup>
import { ref, watch} from 'vue';
import { useFetchJson } from '@/composables/useFetchJson.js';
import BaseMessageWarning from '../../components/BaseMessageWarning.vue';

const emits = defineEmits(['login']);

const name = ref(null);
const url = ref('');
const showConnectionError = ref(false);
const {data: logged} = useFetchJson(url, true);

watch(logged, () => {
  if (logged.value?.status != 'success') {
    showConnectionError.value = true;
    return;
  };
  emits('login');
});

function onSubmit () {
  url.value = `/api/user/login?name=${name.value}`;
}

function onReset () {
  name.value = null;
}
</script>

<template>
  <div class="column items-center">
    <base-message-warning v-if="showConnectionError">
      Problems with the connection to the chat. Please try again later.
    </base-message-warning>
    <h1 class="row text-h2">Chat IM</h1>
    <div class="row full-width justify-center">
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="col-6 col-md-4 q-gutter-md"
      >
        <q-input
          filled
          v-model="name"
          label="Username *"
          hint="Your username for the chat"
          lazy-rules
          :rules="[ val => val && val.match(/^[a-z]+$/i) && val.length > 1 || 'Alphabetic characters only, at least 2 characters']"
        />

        <div>
          <q-btn label="Login" type="submit" color="primary"/>
          <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
      </q-form>
    </div>
  </div>
</template>