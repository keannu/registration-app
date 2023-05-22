<template>
	<section class="container px-4 mx-auto">
		<div class="flex flex-col mt-6">
			<div class="my-2 flex sm:flex-row flex-col">
				<div class="block relative mr-2 mb-2">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <em class="mdi mdi-account-outline text-gray-400 text-lg"></em>
                    </span>
                    <input v-model="oSearchFilter.username" placeholder="Username" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
				<div class="block relative mr-2 mb-2">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <em class="mdi mdi-email-outline text-gray-400 text-lg"></em>
                    </span>
                    <input v-model="oSearchFilter.email" placeholder="Email" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
                <div class="block relative mr-2 mb-2">
                    <div class="relative">
                        <select v-model="oSearchFilter.is_admin" class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                            <option v-for="oRole of aRoleOptions" :value="oRole.sValue">{{ oRole.sLabel }}</option>
                        </select>
						<div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
				<div class="block relative">
					<button class="flex w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600" :class="{ 'opacity-50 cursor-not-allowed': bPageIsLoading }" @click="getUserList">
						<em class="mdi mdi-magnify"></em>
						Search
					</button>
                </div>
            </div>

			<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
				<div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
					<div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
						<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
							<thead class="bg-indigo-800 text-white">
								<tr>
									<th v-for="sColumn of aColumns" scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right">
										{{ sColumn }}
									</th>
								</tr>
							</thead>
							<tbody v-if="(aUserList.length > 0)" class="bg-white divide-y divide-gray-400 text-center">
								<tr v-for="oUserInfo of aUserList">
									<td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
										<div class="text-sm font-normal">{{ oUserInfo.user_no }}</div>
									</td>
									<td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
										<div class="text-sm font-normal">{{ oUserInfo.username }}</div>
									</td>
									<td class="px-4 py-4 text-sm whitespace-nowrap">
										<div v-if="(oUserInfo.is_admin === 'T')" class="inline px-3 py-1 text-sm font-normal rounded-full text-blue-500 gap-x-2 bg-blue-100/60">
											Admin
										</div>
										<div v-else class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-500 gap-x-2 bg-emerald-100/60">
											Guest
										</div>
									</td>
									<td class="px-4 py-4 text-sm whitespace-nowrap">
										<div class="text-sm font-normal">{{ oUserInfo.email }}</div>
									</td>
									<td class="px-4 py-4 text-sm whitespace-nowrap">
										<div class="text-sm font-normal">{{ getDefaultValue(oUserInfo.phone_no) }}</div>
									</td>
									<td class="px-4 py-4 text-sm whitespace-nowrap">
										<div class="text-sm font-normal">{{ oUserInfo.created_at }}</div>
									</td>
									<td class="px-4 py-4 text-sm whitespace-nowrap">
										<div class="text-sm font-normal">{{ getDefaultValue(oUserInfo.updated_at) }}</div>
									</td>
								</tr>
							</tbody>
							<tbody v-else class="bg-white divide-y divide-gray-400 text-center">
								<tr>
									<td :colspan="aColumns.length">
										<div v-if="(bPageIsLoading === true)" class="inline-block h-12 w-12 animate-spin my-12 rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
											<span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
										</div>
										<div v-else class="my-12">No user found..</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="mt-6">
			<div class="flex items-center mt-4 gap-x-4 sm:mt-0">
				<button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-indigo-300 border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800" @click="returnToMainPage">
					<em class="mdi mdi-arrow-left text-lg"></em>
					Main page
				</button>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex';

	export default {
		name: 'UserListComponent',
		data() {
			return {
				aColumns: [
					'#',
					'Username',
					'Role',
					'Email Address',
					'Phone Number',
					'Created Date',
					'Last Modified Date'
				],
				aRoleOptions: [
					{ sLabel: 'All', sValue: 'A' },
					{ sLabel: 'Admin', sValue: 'T' },
					{ sLabel: 'Guest', sValue: 'F' }
				],
				oSearchFilter: {
					username: '',
					email: '',
					is_admin: 'A'
				},
				bPageIsLoading: false
			}
		},
		computed: {
			...mapGetters('oUser', [ 'aUserList' ]),
		},
		created() {
			this.oSearchFilter = {
				username: '',
				email: '',
				is_admin: 'A'
			}
			this.getUserList();
		},
		methods: {
			...mapActions('oUser', [ 'fetchUserList' ]),

			/**
			 * getUserList
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 */
			async getUserList() {
				this.bPageIsLoading = true;
				await this.fetchUserList(this.oSearchFilter);
				this.bPageIsLoading = false;
			},

			/**
			 * returnToMainPage
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 */
			returnToMainPage() {
				this.$router.push({ name: 'dashboard.main' });
			},

			/**
			 * getDefaultValue
			 * @author Keannu Rim Kristoffer C. Regala <keannu>
			 * @since 2023.05.21
			 * @param { mixed } mValue
			 */
			getDefaultValue(mValue) {
				return (!!mValue === false) ? '-' : mValue;
			}
		}
	}
</script>

<style>

</style>