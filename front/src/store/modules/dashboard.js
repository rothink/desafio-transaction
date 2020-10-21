// initial state
const state = {
	dateFormatted: '',
	showDetails: false,
	loading: 0,
};

// getters
const getters = {
	showDetails: state => {
		return state.showDetails;
	},
};

// mutations
const mutations = {
	setFormatDate(state, date) {
		state.dateFormatted = date;
	},

	setShowDetails(state, status) {
		state.showDetails = status;
	},

	setLoading(state) {
		state.loading = 1;
	},
};

// actions
const actions = {
	formatDate({ commit }, date) {
		const [year, day, month] = date.split('-');
		let dateFormatted = `${month}/${day}/${year}`;
		commit('setFormatDate', dateFormatted);
	},

	setShowDetails({ commit }, status) {
		commit('setShowDetails', status);
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations,
};
