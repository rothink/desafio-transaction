<template>
	<v-app id="inspire">
		<v-navigation-drawer
			v-model="drawer"
			:clipped="$vuetify.breakpoint.lgAndUp"
			app
			elevation="20"
			absolute
			temporary
		>
			<side-bar-menu />
			<template v-slot:append>
				<div class="pa-2">
					<v-btn small block outlined @click="logout()">Sair</v-btn>
				</div>
			</template>
		</v-navigation-drawer>
		<navbar @toggleNavigation="drawer = !drawer" />
		<v-content>
			<v-container>
				<child />
			</v-container>
		</v-content>
		<Footer />
	</v-app>
</template>

<script>
import SideBarMenu from '$components/partials/SideBarMenu';
import Footer from '$components/partials/Footer';
import Navbar from '$components/partials/Navbar';
import Child from '$components/partials/Child';
import { mapGetters, mapActions } from 'vuex';

export default {
	components: {
		SideBarMenu,
		Footer,
		Navbar,
		Child,
	},
	data: () => ({
		dialog: false,
		drawer: false,
	}),
	computed: {
		...mapGetters({
			user: 'auth/user',
		}),
	},
	methods: {
		async logout() {
			const { name } = this.user;
			await this.$store.dispatch('auth/logout');
			notification.showInfoMsg(`Volte sempre, ${name}`);
			this.$router.push({ name: 'login' });
		},
	},
};
</script>
