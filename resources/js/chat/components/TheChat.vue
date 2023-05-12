<script setup>
  import { ref, watch, onUnmounted, nextTick } from 'vue';
  import { useFetchJson } from '@/composables/useFetchJson.js';

  onUnmounted(() => clearInterval(getMsgInterval));

  const {data: messages, fetchJson: getMsg } = useFetchJson('/api/msg/get');

  // This will generate a lot of useless traffic, we need to use another
  // protocol here: WebSocket. The setInterval method will only be ok for a
  // very small number of connected users. If you really want to make a chat
  // with the HTTP protocol, You can maybe loot at SSE (Server Side Events)
  const getMsgInterval = setInterval(getMsg, 1000);

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
  <div>
    <q-chat-message v-for="msg of allMsg"
      :name="msg.user.name"
      :text="[msg.msg]"
      :sent="msg.sentByMe"
      :stamp="date.format(new Date(msg.created_at))"
    />
  </div>
</template>