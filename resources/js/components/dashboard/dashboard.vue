<template>
	<div class="min-h-screen bg-gray-300 flex items-center justify-center px-5 py-5" :class="sMinimumWidthClass">
		<notifications />

		<router-view />
	</div>
</template>

<script>
	export default {
		name: 'DashboardComponent',
		computed: {
			/**
			 * sMinimumWidthClass
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 */
			sMinimumWidthClass() {
				return (this.$route.name === 'dashboard.list') ? 'min-w-screen' : 'min-w-fit';
			}
		}
	}
</script>