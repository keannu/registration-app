import oUserService from '../services/UserService';
import Vue from 'vue';

const oInitialStates = {
    bIsSavingSuccessful: false,
    aErrors: []
};

const mutations = {
    /**
     * SET_SAVING_STATUS
     * @param { object } state
     * @param { boolean } bIsSavingSuccessful 
     */
    SET_SAVING_STATUS(state, bIsSavingSuccessful) {
        state.bIsSavingSuccessful = bIsSavingSuccessful;
    }
};

const actions = {
    /**
     * login
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param { object } oParameter
     */
    async login({ }, oParameter) {
        await oUserService.login(oParameter)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    Vue.notify({
                        title: 'Welcome !!',
                        text: 'User login successful',
                        type: 'success'
                    });
                 }
            })
            .catch(oError => {
                let aErrors = [oError.response.data.message];
                if (!!oError.response.data.errors === true) {
                    aErrors = Object.values(oError.response.data.errors);
                    aErrors = aErrors.flat();
                }

                Vue.notify({
                    title: 'Error !!',
                    text: aErrors.join('<br>'),
                    type: 'error'
                });
            });
    },

    /**
     * fetchUserList
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param object commit
     * @param { string } sCity
     */
    async fetchUserList({ commit }, sCity) {
        await oUserService.fetchUserList()
            .then(oResponse => {
                console.log(oResponse);
            });
    },

    /**
     * storeUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param object commit
     * @param { object } oUserInfo
     */
    async storeUser({ commit }, oUserInfo) {
        await oUserService.storeUser(oUserInfo)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    Vue.notify({
                        title: 'Success !!',
                        text: 'User created successful',
                        type: 'success'
                    });

                    commit('SET_SAVING_STATUS', true);
                 }
            })
            .catch(oError => {
                let aErrors = [oError.response.data.message];
                if (!!oError.response.data.errors === true) {
                    aErrors = Object.values(oError.response.data.errors);
                    aErrors = aErrors.flat();
                }

                Vue.notify({
                    title: 'Error !!',
                    text: aErrors.join('<br>'),
                    type: 'error'
                });

                commit('SET_SAVING_STATUS', false);
            });
    },
};

const getters = {
    /**
     * bIsSavingSuccessful
     * @author Keannu Rim Kristoffer C. Regala <keannu@simplexi.com.ph>
     * @since 2023.05.19
     * @param { object } state
     * @returns boolean
     */
    bIsSavingSuccessful(state) {
        return state.bIsSavingSuccessful;
    }
};

export default {
    state: oInitialStates,
    mutations,
    actions,
    getters,
    namespaced: true
}
