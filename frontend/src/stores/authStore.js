import { ref } from 'vue'
import { defineStore } from 'pinia'
import { fetchAllFromApi, initAxios, storeWithApi } from '@/services/apiService';
import { saveInLocalStorage } from '@/services/localStorageService';



export const useAuthStore = defineStore('auth', () => {
  const userToken = ref('');
  const isSignedIn = ref(false);
  const userInfos = ref(null);
  const userId = ref(null);
  const allUsers = ref([]);


  // ________ Registration
  const registrationInfos = ref({
    name: '',
    email: '',
    pasword: '',
    password_confirmation: ''
  });
  const isRegistering = ref(false);
  // ________ END - Registration

  // ________ Login
  const loginInfos = ref({
    email: '',
    pasword: ''
  });
  const isLogin = ref(false);
  // ________ END - Login



  async function register(){

    if (isRegistering.value) return null;
    isRegistering.value = true;

    const result = await storeWithApi('register', registrationInfos.value);
    isRegistering.value = false;
    if (result[0]){
      userInfos.value = result[1][0];
      userToken.value = result[1][1];
      saveInLocalStorage('api_exercise_user_token', userToken.value);
      initAxios();
      saveInLocalStorage('api_exercise_user_token', '');
      isSignedIn.value = true;
      return true;
    }
    return false;
  }



  async function login() {

    if (isLogin.value) return null;
    isRegistering.value = true;

    const result = await storeWithApi('login', loginInfos.value);
    isLogin.value = false;
    if (result[0]){
      userToken.value = result[1].token;
      userId.value = result[1].user_id;

      saveInLocalStorage('api_exercise_user_token', userToken.value);
      initAxios();
      saveInLocalStorage('api_exercise_user_token', '');
      isSignedIn.value = true;
      return true;
    }
    return false;
  }



  async function getAllUsers(){
    const result = await fetchAllFromApi('users');
    if (result[0]){
      allUsers.value = result[1];
      return true;
    }
    return false;
  }



  return {
    userToken,
    isSignedIn,
    registrationInfos,
    isRegistering,
    userInfos,
    register,
    login,
    getAllUsers
  }
})

