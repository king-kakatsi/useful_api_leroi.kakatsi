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
    <h1>Hey let's gooo</h1>
  </main>
</template>
