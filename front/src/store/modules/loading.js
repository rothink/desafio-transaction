import axios from 'axios';
// initial state
const state = {
	loading: false,
};

//getters
const getters = {
	overlay: state => state.loading,
};

// mutations
const mutations = {
	setLoading(state, status) {
		state.loading = status;
	},
};

// actions
const actions = {
	change({ commit, state }) {
		let status = !state.loading;
		commit('setLoading', status);
	},
	enableInterceptor: function ({ commit }) {
		axios.interceptors.request.use(
			config => {
				commit('setLoading', true);
				return config;
			},
			error => {
				commit('setLoading', false);
				return Promise.reject(error);
			}
		);

		axios.interceptors.response.use(
			response => {
				commit('setLoading', false);
				return response;
			},
			function (error) {
				commit('setLoading', false);
				return Promise.reject(error);
			}
		);
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations,
};
