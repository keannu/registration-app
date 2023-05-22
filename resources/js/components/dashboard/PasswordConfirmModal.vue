<template>
	<div class="relative" aria-labelledby="modal-title" role="dialog" aria-modal="true">
		<div class="fixed inset-0 z-10 overflow-y-auto">
			<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
				<div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
					<div class="bg-indigo-700 px-4 py-3 sm:flex sm:px-6">
						<p class="text-xl font-medium leading-normal text-white">Confirm Password</p>
					</div>
					<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 mt-12 mb-9">
						<div class="sm:flex sm:items-start">
							<div class="w-full px-3 mb-5">
								<div class="flex">
									<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-lock-outline text-gray-400 text-lg"></em></div>
									<input v-model="sConfirmPassword" type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Password">
								</div>
								<p class="pl-2 text-gray-700 text-sm">Enter your password to continue.</p>
							</div>
						</div>
					</div>
					<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
						<button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto" @click="checkPasswordValidity">Update</button>
						<button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="closeModal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'PasswordConfirmModal',
		data() {
			return {
				sConfirmPassword: ''
			}
		},
		methods: {
			/**
			 * closeModal
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @return boolean
			 */
			closeModal() {
				this.sConfirmPassword = '';
				this.$emit('closeModal');
			},

			/**
			 * checkPasswordValidity
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @return boolean
			 */
			checkPasswordValidity() {
				if (this.sConfirmPassword.length > 0) {
					this.$emit('checkPasswordValidity', this.sConfirmPassword);
				} else {
					this.$notify({
						title: 'Error !!',
						text: 'Password should not be empty.',
						type: 'error'
					});
				}
			}
		}
	}
</script>

<style>

</style>