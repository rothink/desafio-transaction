<template>
	<v-content>
		<transition name="fade" mode="out-in">
			<router-view></router-view>
		</transition>
	</v-content>
</template>

<script>
export default {
	created() {
		this.$vuetify.theme.dark = false;
	},
};
</script>
