<template>
	<button class="text-3xl" @click="getUserList">Test</button>
</template>

<script>
	import { mapActions } from 'vuex';

	export default {
		name: 'DashboardComponent',
		data() {
			return {
				
			}
		},
		created() {
		},
		methods: {
			...mapActions('oUser', ['fetchUserList']),

			getUserList() {
				this.fetchUserList('');
			}
		}
	}
</script>

<style>

</style>