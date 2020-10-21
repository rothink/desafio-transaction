const passport = {};
import cookies from 'vue-cookies';
import axios from 'axios';

passport.install = function (Vue) {
	const $passport = {};

	$passport.getAccessToken = () => {
		return cookies.get('access_token');
	};

	$passport.accessToken = (user, router) => {
		const requestData = {
			grant_type: process.env.VUE_APP_GRANT_TYPE,
			client_id: process.env.VUE_APP_CLIENT_ID,
			client_secret: process.env.VUE_APP_CLIENT_SECRET,
			scope: '',
		};

		const data = Object.assign(requestData, user);

		axios.post('/oauth/token', data).then(response => {
			store.dispatch('auth/setToken', response.data);
			cookies.set(
				'access_token',
				response.data.access_token,
				response.data.expires_in + 's'
			);
			cookies.set('refresh_token', response.data.refresh_token);
			axios.defaults.headers.common['Authorization'] =
				'Bearer ' + response.data.access_token;
			router.push({ name: 'home' });
		});
	};

	Vue.prototype.$passport = $passport;
};

export default passport;
