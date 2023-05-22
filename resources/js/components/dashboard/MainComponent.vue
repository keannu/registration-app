<template>
	<section class="relative">
		<PasswordConfirmModal v-if="(bIsModalDisplayed === true)" @closeModal="closePasswordConfirmModal" @checkPasswordValidity="checkPassword" />
		<div v-if="(bIsPageLoading === false)" class="max-w-6xl mx-auto px-4 sm:px-6">
			<div class="pt-32 pb-12 md:pt-40 md:pb-20">
				<div class="text-center pb-2 md:pb-16">
					<h1 class="text-5xl md:text-6xl font-extrabold leading-tighter tracking-tighter mb-4" data-aos="zoom-y-out">Welcome, {{ sUsername }}</h1>
					<div class="max-w-3xl mx-auto mt-3">
						<div class="max-w-xs mx-auto sm:max-w-none sm:flex sm:justify-center">
							<div v-if="(bIsAdmin === true)">
								<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded mb-4" @click="openUserListPage">
									View Records
								</button>
							</div>
							<div v-else>
								<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded mb-4" :class="{ 'opacity-50 cursor-not-allowed': bIsButtonDisabled }" @click="destroyUser">
									Unsubscribe
								</button>
							</div>
							<div>
								<button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow sm:ml-4" :class="{ 'opacity-50 cursor-not-allowed': bIsButtonDisabled }" @click="logoutUser">
									Logout
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="lg:w-[600px] md:w-[600px] sm:w-[400px] drop-shadow rounded-md justify-center mx-auto">
					<details class="bg-indigo-200 open:bg-indigo-900 open:text-white duration-300">
						<summary class="bg-inherit px-5 py-3 text-lg cursor-pointer">Update current user information?</summary>
						<div class="bg-white text-gray-900 px-5 py-3 border border-gray-300 text-sm font-light">
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-2">
									<label for="" class="text-xs font-semibold px-1">Username<span class="text-red-400"> *</span></label>
									<div class="flex">
										<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-account-outline text-gray-400 text-lg"></em></div>
										<input v-model="oUpdateInfo.username" type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Username">
									</div>
								</div>
							</div>
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-2">
									<label for="" class="text-xs font-semibold px-1">Email Address<span class="text-red-400"> *</span></label>
									<div class="flex">
										<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-email-outline text-gray-400 text-lg"></em></div>
										<input v-model="oUpdateInfo.email" type="email" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Email Address">
									</div>
								</div>
							</div>
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-2">
									<label for="" class="text-xs font-semibold px-1">Phone Number</label>
									<div class="flex">
										<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-phone text-gray-400 text-lg"></em></div>
										<input v-model="oUpdateInfo.phone_no" type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Phone Number" @input="limitInputToNumbers">
									</div>
								</div>
							</div>
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-2">
									<label for="" class="text-xs font-semibold px-1">Password<span class="text-red-400"> *</span></label>
									<div class="flex">
										<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-lock-outline text-gray-400 text-lg"></em></div>
										<input v-model="oUpdateInfo.password" type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Password">
									</div>
								</div>
							</div>
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-5">
									<label for="" class="text-xs font-semibold px-1">Confirm Password</label>
									<div class="flex">
										<div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><em class="mdi mdi-lock-outline text-gray-400 text-lg"></em></div>
										<input v-model="oUpdateInfo.confirm_password" type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Password">
									</div>
									<p class="pl-2 text-gray-700 text-sm">No need to input if you will not change the password.</p>
								</div>
							</div>
							<div class="flex -mx-3">
								<div class="w-full px-3 mb-5">
									<button class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold" :class="{ 'opacity-50 cursor-not-allowed': bIsButtonDisabled }" @click="checkUpdateUserInfo">
										<div v-if="(bIsButtonDisabled === true)" class="inline-block h-5 w-5 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
											<span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
										</div>
										<span v-else>Update</span>
									</button>
								</div>
							</div>
						</div>
					</details>
				</div>
			</div>
		</div>
		<div v-else class="max-w-6xl mx-auto px-4 sm:px-6">
			<div class="inline-block h-12 w-12 animate-spin my-12 rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
				<span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
			</div>
		</div>
	</section>
</template>

<script>
	import PasswordConfirmModal from './PasswordConfirmModal.vue';
	import { mapGetters, mapActions } from 'vuex';

	export default {
		name: 'MainComponent',
		components: {
			PasswordConfirmModal
		},
		data() {
			return {
				oUpdateInfo: {
					username: '',
					email: '',
					phone_no: '',
					password: '',
					is_password_change: 'F'
				},
				bIsPageLoading: false,
				bIsButtonDisabled: false,
				bIsModalDisplayed: false,
				aErrors: [],
				oEmailRegex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
			}
		},
		computed: {
			...mapGetters('oUser', [ 'oCurrenUserInfo', 'bIsSavingSuccessful' ]),

			/**
			 * iUserNumber
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 * @return int
			 */
			 iUserNumber() {
				let iUserNo = this.oCurrenUserInfo.user_no;
				return (!!iUserNo === true) ? iUserNo : 0;
			},
			
			/**
			 * sUsername
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 * @return string
			 */
			sUsername() {
				return this.oCurrenUserInfo.username;
			},

			/**
			 * bIsAdmin
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 * @return boolean
			 */
			 bIsAdmin() {
				return (this.oCurrenUserInfo.is_admin === 'T');
			}
		},
		created() {
			this.fetchCurrentUser();
		},
		methods: {
			...mapActions('oUser', [ 'logout', 'deleteUser', 'fetchUser', 'updateUser' ]),

			/**
			 * logoutUser
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 */
			async logoutUser() {
				this.bIsButtonDisabled = true;
				await this.logout();
				this.bIsButtonDisabled = false;
			},

			/**
			 * destroyUser
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 */
			async destroyUser() {
				this.bIsButtonDisabled = true;
				if (confirm('Are you sure you want to unsubscribe?') === true) {
					await this.deleteUser(this.iUserNumber);
					if (this.bIsSavingSuccessful === true) {
						window.location.href = '/login';
					}
				}

				this.bIsButtonDisabled = false;
			},

			/**
			 * fetchCurrentUser
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 */
			async fetchCurrentUser() {
				this.oUpdateInfo = {
					username: '',
					email: '',
					phone_no: '',
					password: '',
					confirm_password: '',
					is_password_change: 'F'
				};
				this.bIsPageLoading = true;
				this.bIsButtonDisabled = true;
				await this.fetchUser(this.iUserNumber);
				this.bIsPageLoading = false;
				this.bIsButtonDisabled = false;
				this.oUpdateInfo = { ...this.oCurrenUserInfo };
				this.oUpdateInfo.phone_no = this.oCurrenUserInfo.phone_no ?? '';
			},

			/**
			 * openUserListPage
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.20
			 */
			openUserListPage() {
				this.$router.push({ name: 'dashboard.list' });
			},

			/**
			 * limitInputToNumbers
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @param { object } oEvent
			 */
			 limitInputToNumbers(oEvent) {
				this.oUpdateInfo.phone_no = oEvent.target.value.replace(/\D/g, '');
			},

			/**
			 * closePasswordConfirmModal
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 */
			closePasswordConfirmModal() {
				this.bIsModalDisplayed = false;
			},

			/**
			 * checkPassword
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @param string sConfirmPassword
			 */
			async checkPassword(sConfirmPassword) {
				if (sConfirmPassword !== this.oCurrenUserInfo.password) {
					this.$notify({
						title: 'Error !!',
						text: 'Password incorrect. Please try again',
						type: 'error'
					});
				} else {
					this.bIsModalDisplayed = false;
					let oUserUpdateInfo = {
						user_no: this.iUserNumber,
						username: this.oUpdateInfo.username,
						email: this.oUpdateInfo.email,
						phone_no: this.oUpdateInfo.phone_no,
						is_password_change: 'F'
					};
					if (!!this.oUpdateInfo.confirm_password === true) {
						oUserUpdateInfo.is_password_change = 'T';
						oUserUpdateInfo.password = this.oUpdateInfo.password;
					}

					await this.updateUser(oUserUpdateInfo);
					if (this.bIsSavingSuccessful === true) {
						await this.fetchCurrentUser();
					}
				}
			},

			/**
			 * checkUpdateUserInfo
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @param string sConfirmPassword
			 */
			 checkUpdateUserInfo() {
				this.validateUserInfo();
				if (this.aErrors.length > 0) {
					this.$notify({
                        title: 'Error',
                        text: this.aErrors.join('<br>'),
                        type: 'error'
                    });
				} else {
					this.bIsModalDisplayed = true;
				}
			},

			/**
			 * validateUserInfo
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.18
			 */
			 validateUserInfo() {
				this.aErrors = [];
				this.checkRequireFields();
				this.checkPasswordValidity();
				if (this.oEmailRegex.test(this.oUpdateInfo.email) === false) {
					this.aErrors.push('Invalid email format.');
				}

				if (this.oUpdateInfo.phone_no.length > 0 && this.oUpdateInfo.phone_no.length < 11) {
					this.aErrors.push('Invalid phone number format.');
				}
			},

			/**
			 * checkRequireFields
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.18
			 */
			checkRequireFields() {
				let aRequiredFields = [ 'username', 'email', 'password' ];
				for (const sKey of aRequiredFields) {
					if (this.oUpdateInfo[sKey].length <= 0) {
						this.aErrors.push(sKey + ' is a required field.');
					}
				}
			},

			/**
			 * checkPasswordValidity
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.18
			 */
			checkPasswordValidity() {
				if (this.oUpdateInfo.password !== this.oCurrenUserInfo.password) {
					if (this.oUpdateInfo.password !== this.oUpdateInfo.confirm_password) {
						this.aErrors.push('Password do not match.');
					}
				}
			}
		}
	}
</script>

<style>

</style>