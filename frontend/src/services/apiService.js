import axios from "axios";

const baseURL = 'http://127.0.0.1:8000/api/'

/**
 * *Axios instance for using api endpoints*
 */

export function initAxios(){

  const api = axios.create({
    baseURL: baseURL, // the backend base api
    timeout: 15000, // 15s delay max
    headers: {
        "Content-Type": "application/json",
    }})

    api.interceptors.request.use((config) => {
      const token = localStorage.getItem('api_exercise_user_token');
      if (token) {
        config.headers.Authorization = `Bearer ${token}`
      }
      return config
    })
    return api;
}

let api = initAxios();
export default api;





/**
 * *Sends a get request to server and resturns a list of data or false based on response status*
 * @param {string} endPoint
 * @returns
 */
export async function fetchAllFromApi(endPoint) {
    const result = await api.get(endPoint);
    console.log(result)
    if (result.status === 200) {
        const data = result.data;
        if(data){
            return [true, data]
        }
    }
    return [false, result.data?.message];
}





/**
 * *Sends a post request to server and returns the data freshly stored id or false according to response status*
 * @param {string} endPoint
 * @param {object} data
 * @returns
 */
export async function storeWithApi(endPoint, data) {

    if (data) {
        try{
            const result = await api.post(endPoint, data);
            if (result.status === 201) return [true, result.data]
            return [false, result.data]
        }catch(error){
          console.log(error)
            return[false,error.response.data]
        }
    }
    return [false, null];
}


export async function postWithApi(endPoint, data, successStatus = 200) {
        try{
            const result = await api.post(endPoint, data);
            if (result.status === successStatus) return [true, result.data]
            return [false, result.data]
        }catch(error){
          console.log(error)
            return[false,error.response.data]
        }
}





/**
 * *Sends a put request to server and return true or false according to response status*
 * @param {string} endPoint
 * @param {string} id
 * @param {object} data
 * @returns
 */
export async function updateWithApi(endPoint, id, data) {

    if (data && id) {
         try {
           const result = await api.put(endPoint + id, data)
           if (result.status === 200) return [true, result.data]
           return [false, result.data]
         } catch (error) {
           return [false, error.response.data]
         }
    }
    return [false, null];
}





/**
 * *Sends a delete request to server and returns true or false*
 * @param {string} endPoint
 * @param {string} id
 * @returns
 */
export async function deleteWithApi(endPoint, id, successCode = 204) {
    if (id) {
        try {
          const result = await api.delete(endPoint + id);
          if (result.status === successCode) return [true, result.data]
          return [false, result.data]
        } catch (error) {
          return [false, error.response.data]
        }
    }
    return false;
}



/**
 * **Sends a delete all request to server and returns true or false**
 * @param {string} endPoint
 * @returns true or false
 */
export async function deleteAllWithApi(endPoint) {
  try {
    const result = await api.delete(endPoint)
    if (result.status === 204) return [true, result.data]
    return [false, result.data]
  } catch (error) {
    return [false, error.response.data]
  }
}
