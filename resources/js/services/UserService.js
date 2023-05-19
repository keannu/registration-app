import axios from 'axios';

const oUserServiceApiClient = axios.create({
    baseURL: '/api/user',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
});

export default {
    /**
     * fetchUserList
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @returns { object }
     */
    fetchUserList() {
        return oUserServiceApiClient.get('', { params: { username: '' } });
    },

    /**
     * login
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param objects oParameters
     * @returns { object }
     */
    login(oParameters) {
        return oUserServiceApiClient.post('/login', oParameters);
    },

    /**
     * storeUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.19
     * @param objects oUserInfo
     * @returns { object }
     */
    storeUser(oUserInfo) {
        return oUserServiceApiClient.post('', oUserInfo);
    }
}
