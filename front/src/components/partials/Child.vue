<template>
	<v-container fluid grid-list-xl>
		<transition name="fade" mode="out-in">
			<router-view />
		</transition>
	</v-container>
</template>

<script>
export default {
	name: 'Child',
};
</script>

<style>
	.container {
		padding: 3px !important;
	}
</style>
