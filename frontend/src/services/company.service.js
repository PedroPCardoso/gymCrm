import axios from 'axios';


const API_URL = process.env.VUE_APP_API_BASE_URL;
const headers = {
  Accept: "application/vnd.api+json",
  "Content-Type": "application/vnd.api+json",
};

export function getAll() {
   // eslint-disable-next-line
  return new Promise((resolve, reject) => {
    axios.get(`${API_URL}/company`, { headers })
      .then(res => {
        resolve(res.data);
      })
      .catch(res => {
        reject(res.response);
      });
  })
}
export default {
  getAll
};