import axios from 'axios';

import Auth from '../store/auth';

const BASE_URL = window.location.origin;

export function get(url) {
    return axios({
    	method: 'GET',
    	url: BASE_URL + url,
    	headers: {
    		'Authorization': `Bearer ${Auth.state.api_token}`
    	}
    })
}

export function post(url, payload) {
    return axios({
    	method: 'POST',
    	url: BASE_URL + url,
    	data: payload,
    	headers: {
    		'Authorization': `Bearer ${Auth.state.api_token}`
    	}
    })
}
// delete is reserved keyword
export function del(url) {
    return axios({
        method: 'DELETE',
        url: BASE_URL + url,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function interceptors(cb) {
    axios.interceptors.response.use((res) => {
        return res;
    }, (err) => {
        cb(err)
        return Promise.reject(err)
    })
}
