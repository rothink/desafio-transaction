import axios from 'axios';
import store from '~/store/index';
import router from '../router';

axios.interceptors.request.use(
	config => {
		config.headers['X-Requested-With'] = 'XMLHttpRequest';
		config.baseURL = process.env.VUE_APP_API;

		const token = store.getters['auth/token'];
		if (token) {
			config.headers['Authorization'] = 'Bearer ' + token;
		}
		return Promise.resolve(config);
	},
	error => {
		return Promise.reject(error);
	}
);

axios.interceptors.response.use(
	response => {
		return response;
	},
	async error => {
		if (store.getters['auth/token']) {
			// TODO: Find more reliable way to determine when Token state
			if (
				error.response.status === 401 &&
				(error.response.data.message === 'Token has expired' ||
					error.response.data.message === 'Unauthenticated.')
			) {
				store.dispatch('auth/destroy');
				router.push({ name: 'login' });
			}

			if (
				error.response.status === 401 ||
				(error.response.status === 500 &&
					(error.response.data.message ===
						'Token has expired and can no longer be refreshed' ||
						error.response.data.message === 'The token has been blacklisted'))
			) {
				store.dispatch('auth/destroy');
				router.push({ name: 'login' });
			}
		}

		return Promise.reject(error.response);
	}
);
