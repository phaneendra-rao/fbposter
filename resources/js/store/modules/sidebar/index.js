/**
 * Sidebar Module
 */

import { menus } from './data.js';
import { othermenus } from './data-member.js';

const state = {
    menus,
    othermenus
}

const getters = {
    menus: state => {
        return state.menus;
    },
    othermenus: state => {
        return state.othermenus;
    }
}

const actions = {
    setActiveMenuGroup(context, payload) {
        context.commit('setActiveMenuGroupHandler', payload);
    }
}

const mutations = {
    setActiveMenuGroupHandler(state, router) {
        let fullPath = '';
        if(router.pathURL){
            fullPath = router.pathURL;
        }else{
            fullPath = router.history.current.fullPath;
        }
        let path = fullPath.split('/');
        let matchedPath = '/' + path[2] + '/' + path[3];

        for (const category in state.menus) {
            for(const menuGroup in state.menus[category]) {
                if(state.menus[category][menuGroup].items !== null) {
                    for(const matched in state.menus[category][menuGroup].items){
                        if(state.menus[category][menuGroup].items[matched].path == matchedPath || state.menus[category][menuGroup].items[matched].path == fullPath ){
                           state.menus[category][menuGroup].active = true;
                        }
                    }
                }
            }
        }

        for (const category in state.othermenus) {
            for(const menuGroup in state.othermenus[category]) {
                if(state.othermenus[category][menuGroup].items !== null) {
                    for(const matched in state.othermenus[category][menuGroup].items){
                        if(state.othermenus[category][menuGroup].items[matched].path == matchedPath || state.othermenus[category][menuGroup].items[matched].path == fullPath ){
                           state.othermenus[category][menuGroup].active = true;
                        }
                    }
                }
            }
        }
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}