<script setup>

import { useAuthStore } from '@/stores/authStore';
import { useRouter } from 'vue-router';
const authStore = useAuthStore();
const router = useRouter();

if (!authStore.isSignedIn){
  router.push('/login');
}
</script>

<template>
  <main>
    <ul>
      <li v-for="user in authStore.allUsers" :key="user?.id">{{ user?.name }}</li>
    </ul>
  </main>
</template>
