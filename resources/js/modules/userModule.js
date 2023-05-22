import oUserService from '../services/UserService';
import Vue from 'vue';

const oInitialStates = {
    bIsSavingSuccessful: false,
    aUserList: [],
    oCurrenUserInfo: {}
};

const mutations = {
    /**
     * SET_SAVING_STATUS
     * @param { object } state
     * @param { boolean } bIsSavingSuccessful
     */
    SET_SAVING_STATUS(state, bIsSavingSuccessful) {
        state.bIsSavingSuccessful = bIsSavingSuccessful;
    },
    
    /**
     * SET_USER_LIST
     * @param { object } state
     * @param { array } aUserList
     */
    SET_USER_LIST(state, aUserList) {
        state.aUserList = aUserList;
    },

    /**
     * SET_CURRENT_USER
     * @param { object } state
     * @param { boolean } oCurrenUserInfo
     */
    SET_CURRENT_USER(state, oCurrenUserInfo) {
        state.oCurrenUserInfo = oCurrenUserInfo;
    }
};

const actions = {
    /**
     * login
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param object dispatch
     * @param { object } oParameter
     */
    async login({ dispatch }, oParameter) {
        await oUserService.login(oParameter)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    Vue.notify({
                        title: 'Welcome !!',
                        text: 'User login successful',
                        type: 'success'
                    });

                    window.location.href = '/dashboard';
                 }
            })
            .catch(oError => {
                dispatch('alertErrors', oError);
            });
    },

    /**
     * alertErrors
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param { object } oErrorResponse
     */
    alertErrors({ }, oErrorResponse) {
        let aErrors = [oErrorResponse.response.data.message];
        if (!!oErrorResponse.response.data.errors === true) {
            aErrors = Object.values(oErrorResponse.response.data.errors);
            aErrors = aErrors.flat();
        }

        Vue.notify({
            title: 'Error !!',
            text: aErrors.join('<br>'),
            type: 'error'
        });
    },

    /**
     * logout
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     */
    async logout({ }) {
        await oUserService.logout()
            .then(() => {
                Vue.notify({
                    title: 'Thank you !!',
                    text: 'Please visit our page again.',
                    type: 'success'
                });

                window.location.href = '/login';
            });
    },

    /**
     * storeUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param object commit
     * @param object dispatch
     * @param { object } oUserInfo
     */
    async storeUser({ commit, dispatch }, oUserInfo) {
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
                dispatch('alertErrors', oError);
                commit('SET_SAVING_STATUS', false);
            });
    },

    /**
     * updateUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.18
     * @param object commit
     * @param object dispatch
     * @param { object } oUserInfo
     */
    async updateUser({ commit, dispatch }, oUserInfo) {
        console.log(oUserInfo);
        await oUserService.updateUser(oUserInfo)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    Vue.notify({
                        title: 'Success !!',
                        text: 'User updated successful',
                        type: 'success'
                    });

                    commit('SET_SAVING_STATUS', true);
                 }
            })
            .catch(oError => {
                dispatch('alertErrors', oError);
                commit('SET_SAVING_STATUS', false);
            });
    },

    /**
     * deleteUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param object dispatch
     * @param { int } iUserNo
     */
    async deleteUser({ dispatch }, iUserNo) {
        await oUserService.deleteUser(iUserNo)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    Vue.notify({
                        title: 'Success !!',
                        text: 'User deleted successful',
                        type: 'success'
                    });

                    window.location.href = '/login';
                 }
            })
            .catch(oError => {
                dispatch('alertErrors', oError);
            });
    },

    /**
     * fetchUserList
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param object commit
     * @param { object } oParameters
     */
    async fetchUserList({ commit }, oParameters) {
        commit('SET_USER_LIST', []);
        await oUserService.fetchUserList(oParameters)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    commit('SET_USER_LIST', oResponse.data);
                 }
            });
    },

    /**
     * fetchUser
     * @author Keannu Rim Kristoffer C. Regala <keannu>
     * @since 2023.05.20
     * @param object commit
     * @param object dispatch
     * @param { int } iUserNo
     */
    async fetchUser({ commit, dispatch }, iUserNo) {
        commit('SET_CURRENT_USER', {});
        await oUserService.fetchUser(iUserNo)
            .then(oResponse => {
                 if (oResponse.status === 200) {
                    commit('SET_CURRENT_USER', oResponse.data);
                 }
            })
            .catch(oError => {
                dispatch('alertErrors', oError);
            });
    }
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
    },

    /**
     * aUserList
     * @author Keannu Rim Kristoffer C. Regala <keannu@simplexi.com.ph>
     * @since 2023.05.20
     * @param { object } state
     * @returns array
     */
    aUserList(state) {
        return state.aUserList;
    },

    /**
     * oCurrenUserInfo
     * @author Keannu Rim Kristoffer C. Regala <keannu@simplexi.com.ph>
     * @since 2023.05.20
     * @param { object } state
     * @returns object
     */
    oCurrenUserInfo(state) {
        return state.oCurrenUserInfo;
    }
};

export default {
    state: oInitialStates,
    mutations,
    actions,
    getters,
    namespaced: true
}
