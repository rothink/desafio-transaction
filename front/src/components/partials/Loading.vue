<template>
	<div class="text-center">
		<v-overlay :value="overlay">
			<v-progress-circular indeterminate size="64"></v-progress-circular>
		</v-overlay>
	</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
	data() {
		return {
			isLoading: false,
			axiosInterceptor: null,
		};
	},
	computed: mapState({
		...mapGetters('loading', ['overlay']),
	}),

	methods: {
		...mapActions('loading', ['enableInterceptor']),
	},

	mounted() {
		this.enableInterceptor();
	},
};
</script>
