import axios from 'axios';

const oUserServiceApiClient = axios.create({
    baseURL: '/api/user',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
});

export default {
    
}
