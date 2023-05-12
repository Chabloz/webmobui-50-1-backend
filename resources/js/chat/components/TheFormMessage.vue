<script setup>
import { ref, watch, onMounted} from 'vue';
import { useFetchJson } from '@/composables/useFetchJson.js';

const emits = defineEmits(['logout', 'conn-error', 'conn-ok']);

const message = ref(null);
const form = ref(null);
const inputMessage = ref(null);
const url = ref('');
const {data: added, fetchJson: fetchAdd} = useFetchJson(url, true, false);

onMounted(() => inputMessage.value.focus());

watch(added, () => {
  if (added.value?.status != 'success') {
    emits('conn-error');
    return;
  };
  emits('conn-ok');
});

function onSubmit () {
  url.value = `/api/msg/add?msg=${message.value}`;
  fetchAdd();
  message.value = '';
  inputMessage.value.resetValidation();
}

</script>

<template>
    <q-form
      ref="form"
      @submit="onSubmit"
    >
      <q-input
        filled
        v-model="message"
        ref="inputMessage"
        label="Message"
        lazy-rules
        :rules="[ val => val && val.trim().length > 0 || 'At least 1 character']"
      >
        <template v-slot:after>
          <q-btn @click="form.submit()" color="primary" dense flat icon="send" />
        </template>
      </q-input>
    </q-form>
</template>