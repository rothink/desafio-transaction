<template>
	<v-flex>
		<v-tooltip bottom>
			<template v-slot:activator="{ on, attrs }">
				<v-btn
					class="d-inline-block"
					fab
					dark
					color="primary"
					v-on="on"
					@click="novo"
				>
					<v-icon dark>add</v-icon>
				</v-btn>
			</template>
			<span>Adicionar {{ title }}</span>
		</v-tooltip>
		<h2 class="ml-5 d-inline-block">{{ title }}</h2>
		<v-spacer></v-spacer>
	</v-flex>
</template>

<script>
export default {
	name: 'new-button',
	props: ['title', 'toRoute'],
	methods: {
		novo() {
			this.$router.push({ name: this.toRoute });
		},
	},
};
</script>
