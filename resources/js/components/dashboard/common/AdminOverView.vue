<template>
 <div>
     <v-row justify="center" >
        
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="purple darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">attach_money</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.totalDataIncomeEarning}} <small class="body-1" >QAR</small></h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Earning</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="deep-purple  darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">attach_money</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{admincurrentMonthEarning}} <small class="body-1">QAR</small></h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Current Month Earning</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="indigo darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">zoom_in</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 "># {{dataList.todayDataDealFollow}}</h3>
								<h6 class="caption ">Today</h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1">Sales Follow </div>
							</v-card-actions>
						</v-card>
					</v-flex>

					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="blue darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">done_all</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2"># {{dataList.todayDataDealClosed}}</h3>
								<h6 class="caption">Today</h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Sale Closed</div>
							</v-card-actions>
						</v-card>
					</v-flex>
            
			        </v-row >
                    <v-row  justify="center" >
					<v-flex xs12 sm12 md6 lg6 pa-2>
						<v-card flat class="elevation-8">
							<v-card-title>
								<h3>Monthly Sales</h3>
							</v-card-title>
							<v-card-text>
								<v-list class="transparent">
								<v-list-item
								>
								<v-list-item-subtitle>Sales Follow </v-list-item-subtitle>
								<v-list-item-title class="text-right">
									{{dataList.monthlyDataDealFollow}} / {{dataList.monthlyDataDealFollow + dataList.monthlyDataDealNotIntrested + dataList.monthlyDataDealClosed}}
								</v-list-item-title>
								</v-list-item>
								</v-list>
								<v-progress-linear
									color="indigo accent-4"
									rounded
									height="8"
									:value="adminfollowPercentage"
								>
								</v-progress-linear>
								<br>
								<v-list class="transparent">
								<v-list-item
								>
								<v-list-item-subtitle>Sales Not Intrested </v-list-item-subtitle>
								<v-list-item-title class="text-right">
									{{dataList.monthlyDataDealNotIntrested}} / {{dataList.monthlyDataDealNotIntrested + dataList.monthlyDataDealFollow + dataList.monthlyDataDealClosed}}
								</v-list-item-title>
								</v-list-item>
								</v-list>
									<v-progress-linear
									color="indigo accent-4"
									rounded
									height="8"
									:value="adminsaleNotIntrestedPercentage"
									>
									
									</v-progress-linear>
									<br>
								<v-list class="transparent">
								<v-list-item
								>
								<v-list-item-subtitle>Sales Closed</v-list-item-subtitle>
								<v-list-item-title class="text-right">
									{{dataList.monthlyDataDealClosed}} / {{dataList.monthlyDataDealNotIntrested + dataList.monthlyDataDealFollow + dataList.monthlyDataDealClosed}}
								</v-list-item-title>
								</v-list-item>
								</v-list>
									<v-progress-linear
									color="indigo accent-4"
									rounded
									height="8"
									:value="adminsaleClosedPercentage"
									>
									</v-progress-linear>
									<br>
								</v-card-text>
							</v-card>
				</v-flex>
					<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
								<v-card-title>
									<h3>Monthly Earning</h3>
								</v-card-title>
								<v-card-text>
									<v-list class="transparent">
									<v-list-item
									>
									<v-list-item-subtitle> By Target (QAR)</v-list-item-subtitle>
									<v-list-item-title class="text-right">
										{{dataList.monthlyDataTargetCredit}} / {{dataList.monthlyDataTargetDebit }} 
									</v-list-item-title>
									</v-list-item>
									</v-list>
									<v-progress-linear
										color="deep-purple accent-4"
										rounded
										height="8"
										:value="adminsaleTargetCredit"
									>
									</v-progress-linear>
									<br>
									<v-list class="transparent">
									<v-list-item
									>
									<v-list-item-subtitle> By Number  </v-list-item-subtitle>
									<v-list-item-title class="text-right">
										{{dataList.monthlyDataTargetVolumeCredit}} / {{dataList.monthlyDataTargetVolumeDebit}} 
									</v-list-item-title>
									</v-list-item>
									</v-list>
										<v-progress-linear
										color="deep-purple accent-4"
										rounded
										height="8"
										:value="adminsaleNumberCredit"
										>
										</v-progress-linear>
										<br>
									<v-list class="transparent">
									<v-list-item
									>
									<v-list-item-subtitle>Income (other source)</v-list-item-subtitle>
									<v-list-item-title class="text-right">
										{{dataList.monthlyDataIncomeEarning}} / {{dataList.monthlyDataExpense}}
									</v-list-item-title>
									</v-list-item>
									</v-list>
										<v-progress-linear
										color="deep-purple accent-4"
										rounded
										height="8"
										:value="adminIncomeEarning"
										>
										</v-progress-linear>
										<br>
									</v-card-text>
								</v-card>
					</v-flex>
			</v-row>
            <v-row justify="center" >
				<v-flex xs12 sm12 md6 lg6 pa-2>
						<v-card flat class="elevation-8" >
								<v-card-title>
									<h4>Recent Accounts Created</h4>
								</v-card-title>
								<v-card-text>
									<v-simple-table  >
										<template v-slot:default>
										<thead color="purple darken-4" dark>
											<tr>
											<th class="text-left">Name</th>
											<th class="text-left">Email</th>
											<th class="text-left">Contact</th>
											<th class="text-left">Type</th>
											
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.dataNewUser" :key="index">
											<td>{{ item.name }}</td>
											<td>{{ item.email }}</td>
											<td>{{ item.contact }}</td>
											<td>{{ item.user_type.name }}</td>
											</tr>
										</tbody>
										</template>
									</v-simple-table>
									</v-card-text>
								</v-card>
					</v-flex>
					<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
								<v-card-title>
									<h4>Recent Appoinment Registered</h4>
								</v-card-title>
								<v-card-text>
									<v-simple-table color="accent" >
										<template v-slot:default>
										<thead>
											<tr>
											<th class="text-left">Attention Name</th>
											<th class="text-left">Company</th>
											<th class="text-left">Contact</th>
											<th class="text-left">TeleSale</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.dataNewAppoinment" :key="index">
											<td>{{ item.attention }}</td>
											<td>{{ item.company_name }}</td>
											<td>{{ item.mobile }}</td>
											<td>{{ item.telesale.name }}</td>
											</tr>
										</tbody>
										</template>
									</v-simple-table>
									</v-card-text>
							</v-card>
					</v-flex>
					</v-row>
 </div>
</template>
<script>
export default {
    props:{
            dataList:{},
    },
    	computed: {	
		adminfollowPercentage()
		{
			return  Math.round((this.dataList.monthlyDataDealFollow/(this.dataList.monthlyDataDealNotIntrested+this.dataList.monthlyDataDealFollow +this.dataList.monthlyDataDealClosed))*100)
		},
		adminsaleNotIntrestedPercentage()
		{
			return   Math.round((this.dataList.monthlyDataDealNotIntrested/(this.dataList.monthlyDataDealNotIntrested+this.dataList.monthlyDataDealFollow + this.dataList.monthlyDataDealClosed))*100)
		},
		adminsaleClosedPercentage()
		{
			return   Math.round((this.dataList.monthlyDataDealClosed/(this.dataList.monthlyDataDealNotIntrested+this.dataList.monthlyDataDealFollow + this.dataList.monthlyDataDealClosed))*100)
		},
		adminsaleTargetCredit()
		{
			return   Math.round((this.dataList.monthlyDataTargetCredit/(this.dataList.monthlyDataTargetDebit ))*100)
		},
		adminsaleNumberCredit()
		{
			return   Math.round((this.dataList.monthlyDataTargetVolumeCredit/(this.dataList.monthlyDataTargetVolumeDebit ))*100)
		},
		adminIncomeEarning()
		{
			return   Math.round((this.dataList.monthlyDataIncomeEarning/(this.dataList.monthlyDataExpense ))*100)
		},
		admintotalEarning()
		{
			return   parseInt(this.dataList.totalDataTargetCredit)+parseInt(this.dataList.totalDataIncomeEarning)
		},
		admincurrentMonthEarning()
		{
			return   parseInt(this.dataList.monthlyDataTargetCredit)+parseInt(this.dataList.monthlyDataIncomeEarning)
		},
	},
	watch: {},

	mounted()
	{
		Echo.channel(`user`)
                .listen('NewMessage', (e) => {

                    console.log(e);
                });
	},
	method:{
		
		
		
	}
}
</script>