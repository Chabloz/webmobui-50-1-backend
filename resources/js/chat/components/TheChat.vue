<script setup>
  import { ref, watch, onUnmounted, nextTick } from 'vue';
  import { useFetchJson } from '@/composables/useFetchJson.js';

  onUnmounted(() => clearInterval(getMsgInterval));

  const {data: messages, fecthJson: getMsg } = useFetchJson('/api/msg/get');

  const getMsgInterval = setInterval(getMsg, 5000);

  const allMsg = ref([]);

  watch(messages, async () => {
    if (messages.value?.length > 0) {
      allMsg.value.push(...messages.value)
      await nextTick();
      window.scrollTo(0, document.body.scrollHeight);
    }
  });

  const date = new Intl.DateTimeFormat('fr-CH', {dateStyle: 'short', timeStyle: 'short'});;
</script>

<template>
  <div class="full-width justify-center">
    <div class="col-6 col-md-4">
      <q-chat-message v-for="msg of allMsg"
        name="u2"
        :text="[msg.msg]"
        :stamp="date.format(new Date(msg.created_at))"
      />
    </div>
  </div>
</template>