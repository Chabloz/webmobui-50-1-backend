<script setup>
import { ref, watch} from 'vue';
import { useFetchJson } from '@/composables/useFetchJson.js';

const emits = defineEmits(['login', 'conn-error', 'conn-ok']);

const name = ref(null);
const url = ref('');
const {data: logged} = useFetchJson(url, true);

watch(logged, () => {
  if (logged.value?.status != 'success') {
    emits('conn-error');
    return;
  };
  emits('conn-ok');
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
    <q-form
      @submit="onSubmit"
      @reset="onReset"
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
</template>