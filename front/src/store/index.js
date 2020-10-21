import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import dashboard from './modules/dashboard';
import loading from './modules/loading';
import auth from './modules/auth';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		auth,
		loading,
		dashboard,
	},
	plugins: [
		createPersistedState({
			key: 'maria_amelia_doces',
		}),
	],
});
