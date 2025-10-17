// import { ref } from 'vue'
import { defineStore } from 'pinia'
import { fetchAllFromApi, initAxios, postWithApi } from '@/services/apiService';
import { saveInLocalStorage } from '@/services/localStorageService';



export const useAuthStore = defineStore('auth', {

  state: () => ({
    userToken: '',
    isSignedIn: false,
    userInfos: null,
    userId: null,
    allUsers: [],
    registrationInfos: {
      name: '',
      email: '',
      pasword: '',
      password_confirmation: ''
    },

    isRegistering: false,

    loginInfos: {
      email: '',
      pasword: ''
    },

    isLogin: false
  }),

  // const userToken = '');
  // const isSignedIn = false);
  // const userInfos = null);
  // const userId = null);
  // const allUsers = []);

  // const persistedData = {
  //   isSignedIn: isSignedIn,
  //   userId: userId,
  //   allUsers: allUsers,
  //   userInfos: userInfos
  // })


  // // ________ Registration
  // const registrationInfos = {
  //   name: '',
  //   email: '',
  //   pasword: '',
  //   password_confirmation: ''
  // });
  // const isRegistering = false);
  // // ________ END - Registration

  // // ________ Login
  // const loginInfos = {
  //   email: '',
  //   pasword: ''
  // });
  // const isLogin = false);
  // ________ END - Login




  actions: {


  async register(){

    if (this.isRegistering) return null;
    this.isRegistering = true;

    const result = await postWithApi('register', this.registrationInfos, 201);
    this.isRegistering = false;
    if (result[0]){
      this.userInfos = result[1][0];
      this.userToken = result[1][1];
      saveInLocalStorage('api_exercise_user_token', this.userToken);
      initAxios();
      saveInLocalStorage('api_exercise_user_token', '');
      this.isSignedIn = true;
      // this.PersistData();
      return true;
    }
    return false;
  },



  async login() {

    if (this.isLogin) return null;
    this.isRegistering = true;

    const result = await postWithApi('login', this.loginInfos);
    this.isLogin = false;
    if (result[0]){
      this.userToken = result[1].token;
      this.userId = result[1].user_id;

      saveInLocalStorage('api_exercise_user_token', this.userToken);
      initAxios();
      saveInLocalStorage('api_exercise_user_token', '');
      this.isSignedIn = true;
      // PersistData();
      return true;
    }
    return false;
  },


  async logout(){
    const result = await postWithApi('logout');
    if (result[0]){
      saveInLocalStorage('api_exercise_user_token', '');
      initAxios();
      this.isSignedIn = false;
      // this.clearPersistence();
      return true;
    }
    return false;
  },


  async getAllUsers(){
    const result = await fetchAllFromApi('users');
    if (result[0]){
      this.allUsers = result[1];
      return true;
    }
    return false;
  },


  // PersistData(){
  //   persistedData = {
  //     isSignedIn: isSignedIn,
  //     userId: userId,
  //     allUsers: allUsers,
  //     userInfos: userInfos
  //   }
  //   saveInLocalStorage('api_exercise_auth_persist', persistedData);
  // },


  //   clearPersistence(){
  //     saveInLocalStorage('api_exercise_auth_persist', '');
  //   }
  },

  persist: true,

  // return {
  //   userToken,
  //   isSignedIn,
  //   registrationInfos,
  //   loginInfos,
  //   isRegistering,
  //   userInfos,
  //   register,
  //   login,
  //   logout,
  //   getAllUsers
  // }
})

