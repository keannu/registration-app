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
     * @param objects oParameters
     * @returns { object }
     */
    fetchUserList(oParameters) {
        return oUserServiceApiClient.get('', { params: oParameters });
    },

     /**
     * fetchUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param { int } iUserNo
     * @returns { object }
     */
     fetchUser(iUserNo) {
        return oUserServiceApiClient.get('/' + iUserNo);
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
     * logout
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @returns { object }
     */
    logout() {
        return oUserServiceApiClient.get('/logout');
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
    },

    /**
     * updateUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param objects oUserInfo
     * @returns { object }
     */
    updateUser(oUserInfo) {
        return oUserServiceApiClient.put('/' + oUserInfo.user_no, oUserInfo);
    },

    /**
     * deleteUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @returns { object }
     */
    deleteUser(iUserNo) {
        return oUserServiceApiClient.delete('/' + iUserNo);
    }
}
