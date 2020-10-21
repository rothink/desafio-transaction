<template>
	<v-btn @click="back()">voltar</v-btn>
</template>

<script>
export default {
	data: () => ({}),
	methods: {
		back() {
			this.$router.go(-1);
		},
	},
};
</script>
