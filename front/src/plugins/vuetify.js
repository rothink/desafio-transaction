import 'sweetalert2/dist/sweetalert2.min.css';
import Vue from 'vue';
import 'material-design-icons-iconfont/dist/material-design-icons.css'; // Ensure you are using css-loader
import Vuetify, {
	VSnackbar,
	VIcon,
	VBtn,
	VAvatar,
	VProgressCircular,
} from 'vuetify/lib';
import VuetifyMoney from "vuetify-money";
import VueSweetalert2 from 'vue-sweetalert2';
import VuetifyToast from 'vuetify-toast-snackbar-ng'
import VueTheMask from 'vue-the-mask';

Vue.use(VueSweetalert2);
Vue.use(VueTheMask);
Vue.use(VuetifyMoney);

Vue.use(Vuetify, {
	components: { VSnackbar, VIcon, VBtn, VAvatar, VProgressCircular },
});

Vue.use(VuetifyToast, {
	x: 'right', // default
	y: 'top', // default
	color: 'info', // default
	icon: 'info',
	iconColor: '', // default
	classes: [
		'body-2'
	],
	timeout: 3000, // default
	dismissable: true, // default
	multiLine: false, // default
	vertical: false, // default
	queueable: false, // default
	showClose: false, // default
	closeText: '', // default
	closeIcon: 'close', // default
	closeColor: '', // default
	slot: [], //default
	shorts: {
		custom: {
			color: 'purple'
		}
	},
	property: '$toast' // default
})

export default new Vuetify({
	icons: {
		iconfont: 'mdi',
	},
});
