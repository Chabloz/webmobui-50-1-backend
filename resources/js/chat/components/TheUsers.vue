<script setup>
  import { onUnmounted } from 'vue';
  import { useFetchJson } from '@/composables/useFetchJson.js';

  onUnmounted(() => clearInterval(getUsersInterval));

  const {data: users, fetchJson: getUsers } = useFetchJson('/api/user/online');

  const getUsersInterval = setInterval(getUsers, 5000);

</script>

<template>
  <div>
    <span>Online : </span>
    <q-chip
      v-for="user of users"
      color="primary"
      text-color="white"
      dense
    >
      {{ user.name }}
    </q-chip>
  </div>
</template>