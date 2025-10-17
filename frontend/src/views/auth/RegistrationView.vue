<script setup>
import { useToast } from 'vue-toastification';
import { useAuthStore } from '@/stores/authStore';
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';
const authStore = useAuthStore();
const toast = useToast();
const router = useRouter();



async function register(){
  console.log('registration has started...');
  const isSuccessful = await authStore.register();
  if (isSuccessful){
    console.log('Registration succeeded');
    toast.success('Registration succeeded');
    router.push('/');
  } else{
    console.log('Registration failed');
    toast.error('Registration failed');
  }
}


onMounted(()=>{
  if (authStore.isSignedIn){
    router.push('/');
  }
})

</script>

<template>

  <div class="flex justify-center my-20 md:my-30">


    <div class="shadow-lg rounded-lg w-100 px-4 py-10 bg-gray-100">

      <!-- // Title -->
      <h2 class="font-extrabold text-center text-xl md:text-3xl text-emerald-600 mb-5">Sign up here </h2>
      <!-- // Form -->
      <div class="flex flex-col gap-y-4">

        <div class="flex flex-col">
          <label for="username" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Name</label>
          <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4" type="text"
            id="username" placeholder="eg. John Doe" name="name" v-model="authStore.registrationInfos.name">
        </div>

        <div class="flex flex-col">
          <label for="email" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Email</label>
          <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4"
            type="email" id="email" placeholder="example@gmail.com" name="email" v-model="authStore.registrationInfos.email">
        </div>

        <div class="flex flex-col">
          <label for="password" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Password</label>
          <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4" type="password"
            id="password" placeholder="********" name="password" v-model="authStore.registrationInfos.password">
          <p class="text-pink-700 text-xs md:text-sm mt-2">Must be at least 8 characters</p>
        </div>

        <div class="flex flex-col">
          <label for="password_confirmation" class="font-semibold text-md md:text-lg text-gray-600 mx-1">Password confirmation</label>
          <input class="border-1 rounded-md border-gray-400 focus:border-emerald-600 duration-300 py-2 px-4" type="password"
            id="password_confirmation" name="password_confirmation" placeholder="********" v-model="authStore.registrationInfos.password_confirmation">
          <p class="text-pink-700 text-xs md:text-sm mt-2">Must be identic the one above</p>
        </div>


        <button @click="register"
          class="bg-emerald-600 rounded-lg py-3 px-4 text-white hover:bg-emerald-500 duration-300" > {{ authStore.isRegistering ? 'Please wait. Registration in progress...' : 'register' }}</button>
      </div>

      <!-- // END- Form -->

      <div class="flex justify-center mt-5 ">
        <div class="flex text-sm gap-x-2">
          <p>Don't have an account?</p>
          <RouterLink to="/login" class="text-emerald-600 font-bold">Sign in</RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>
