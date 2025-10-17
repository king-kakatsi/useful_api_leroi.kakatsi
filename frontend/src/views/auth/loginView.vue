<script setup>

import { useAuthStore } from '@/stores/authStore';
const authStore = useAuthStore();

async function login(){
  console.log('registration has started...');
  const isSuccessful = await authStore.register();
  if (isSuccessful){
    console.log('Registration succeeded');
  } else{
    console.log('Registration failed');
  }
}
</script>

<template>

<div class="flex justify-center my-20 md:my-30">


  <div class="shadow-lg rounded-lg w-100 px-4 py-10 bg-gray-100">

    <!-- // Title -->
     <h2 class="font-extrabold text-center text-xl md:text-3xl text-emerald-600 mb-5">Sign up here </h2>

     <!-- // Form -->
     <div class="flex flex-col gap-y-4">

      <div class="flex flex-col">
        <label for="email" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Email</label>
        <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4" type="email" id="email" placeholder="example@gmail.com" name="email">
      </div>

      <div class="flex flex-col">
        <label for="password" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Password</label>
        <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4" type="text" id="password" placeholder="********" name="password">
        <p class="text-pink-700 text-xs md:text-sm mt-2">Must be at least 8 characters</p>
      </div>

      <button @click="login"
          class="bg-emerald-600 rounded-lg py-3 px-4 text-white hover:bg-emerald-500 duration-300" > {{ authStore.isRegistering ? 'Please wait. Login in progress...' : 'login' }}</button>
    </div>
    <!-- // END- Form -->

    <div class="flex justify-center mt-5 ">
      <div class="flex text-sm gap-x-2">
        <p >Don't have an account?</p>
        <RouterLink to="/register" class="text-emerald-600 font-bold">Sign up</RouterLink>
      </div>
    </div>
  </div>
  </div>
</template>
