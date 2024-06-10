import axios from 'axios' 


const baseUrl = import.meta.env.VITE_APP_CIAPI_URL

console.log(import.meta.env)

class AxiosHelper{
    async get(endpoint, headers={}, body={}){
        return await axios({
            method: 'get',
            url: baseUrl+endpoint,
            headers:{
                'Content-Type': 'application/json',
                ...headers
            },
            data:body
        })
    }

    async post(endpoint, headers={}, body={}){
        return await axios({
            method: 'post',
            url: baseUrl+endpoint,
            headers:{
                'Content-Type': 'application/json',
                ...headers
            },
            data:body
        })
    }

    async put(endpoint, headers={}, body={}){
        return await axios({
            method: 'put',
            url: baseUrl+endpoint,
            headers:{
                'Content-Type': 'application/json',
                ...headers
            },
            data:body
        })
    }

    async del(endpoint, headers={}, body={}){
        return await axios({
            method: 'delete',
            url: baseUrl+endpoint,
            headers:{
                'Content-Type': 'application/json',
                ...headers
            },
            data:body
        })
    }
}


export default new AxiosHelper();