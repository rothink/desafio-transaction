import axios from 'axios';

// initial state
const state = {
	user: {
		name: '',
	},
	access_token: null,
	refresh_token: null,
	check: false,
};

// getters
const getters = {
	user: state => {
		return state.user;
	},
	token: state => {
		return state.access_token;
	},
	check: state => {
		return state.check;
	},
};

// mutations
const mutations = {
	setUser(state, payload) {
		state.user = payload;
	},
	setToken(state, payload) {
		state.access_token = payload.access_token;
		state.refresh_token = payload.refresh_token;
	},
	setCheck(state, payload) {
		state.check = payload;
	},
	fetchUserFailure(state) {
		state.user = null;
		state.access_token = null;
		state.refresh_token = null;
		state.check = false;
		state.permissions = [];
		state.roles = [];
	},
	destroy(state) {
		state.user = null;
		state.access_token = null;
		state.refresh_token = null;
		state.check = false;
		state.permissions = [];
		state.roles = [];
	},
	logout(state) {
		state.user = null;
		state.access_token = null;
		state.refresh_token = null;
		state.check = false;
		state.permissions = [];
		state.roles = [];
	},
};

// actions
const actions = {
	setUser({ commit }, payload) {
		commit('setUser', payload);
	},
	setToken({ commit }, payload) {
		commit('setToken', payload);
	},
	setCheck({ commit }, payload) {
		commit('setCheck', payload);
	},
	destroy({ commit }) {
		commit('destroy');
	},
	logout({ commit }) {
		commit('logout');
	},
	async fetchUser({ commit }) {
		try {
			const { data } = await axios.get('/me');
			commit('setUser', data.user);
		} catch (e) {
			commit('fetchUserFailure');
		}
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations,
};
