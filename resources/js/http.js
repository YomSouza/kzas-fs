import axios from 'axios'

export const get = (route) => new Promise((resolve, reject) => {
  axios.get(route)
    .then(({ data }) => resolve(data))
    .catch(error => reject(error))
})

export const put = (route, payload) => new Promise((resolve, reject) => {
  axios.put(route, payload)
    .then(({ data }) => resolve(data))
    .catch(error => reject(error))
})

export default {
  get,
  put
}