import Vue from 'vue';
import Loading from '$components/partials/Loading';
import SideBarMenu from '$components/partials/SideBarMenu';
import Footer from '$components/partials/Footer';
import Navbar from '$components/partials/Navbar';
import Child from '$components/partials/Child';
import NewButton from '$components/partials/NewButton';
import BackButton from '$components/partials/BackButton';
import ShowError from '$components/partials/ShowError';

Vue.component('Loading', Loading);
Vue.component('Navbar', Navbar);
Vue.component('SideBarMenu', SideBarMenu);
Vue.component('Footer', Footer);
Vue.component('Child', Child);
Vue.component('ShowError', ShowError);
Vue.component('NewButton', NewButton);
Vue.component('BackButton', BackButton);
