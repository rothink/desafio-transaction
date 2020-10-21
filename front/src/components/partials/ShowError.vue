<template>
	<v-alert
		:value="true"
		type="error"
		outlined
		v-if="formName.errors && formName.errors.has(propName)"
	>
		{{ formName.errors.get(propName) }}
	</v-alert>
</template>

<script>
export default {
	props: ['formName', 'propName'],
};
</script>
