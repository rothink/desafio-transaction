import Vue from 'vue';
import moment from 'moment';

Vue.filter('formatDateTime', function (value) {
	if (!value) return value;
	try {
		return moment(value, 'YYYY-MM-DDTHH:mm:ss').format('DD/MM/YYYY H:mm:ss');
	} catch (error) {
		return null;
	}
});
