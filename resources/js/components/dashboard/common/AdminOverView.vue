<template>
 <div>
     <v-row justify="center" >
						<v-flex xs12 sm6 md6 lg6 pa-2>
						<v-card class="elevation-8" color="purple darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">fastfood</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.admin}} <small class="body-1" ></small></h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Admin</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md6 lg6 pa-2>
						<v-card class="elevation-8" color="deep-purple  darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">account_tree</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.machine}} <small class="body-1"></small></h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Machine</div>
							</v-card-actions>
						</v-card>
					</v-flex>
     </v-row>






	<v-row  justify="center" >
		<v-flex xs12 sm12 md12 lg12 pa-2>
									 <v-tabs grow v-model="tab"  background-color="deep-purple accent-4"
										center-active
										dark>
                                <v-tab  v-for="(data,index) in dataDay" :key="index" @change="getDaily(data)" >
                                  {{data.name}}
                                </v-tab>
                                <v-tab-item  v-model="tab">
									<v-row  justify="center" >
									<v-col xs12 sm12 md="6" lg="6" pa-2>
									<v-card class="elevation-8">
                                                <v-card-text>
													Daily
												<BarChart3 :dataMachine="dataMachine" />	
											</v-card-text>
									</v-card>
										</v-col>
										<v-col xs12 sm12 md="6" lg="6" pa-2>
									<v-card  class="elevation-8">
                                                <v-card-text>
													Weekly
												<BarChart2 :dataMachineWeekly="dataMachineWeekly" />	
											</v-card-text>
									</v-card>
								</v-col>
							   </v-row>
							   	<v-row  justify="center" >
									<v-col xs12 sm12 md="6" lg="6" pa-2>
									<v-card class="elevation-8">
                                                <v-card-text>
													Monthly
												<BarChart :dataMachineMonthly="dataMachineMonthly" />	
											</v-card-text>
									</v-card>
										</v-col>
										<v-col xs12 sm12 md="6" lg="6" pa-2>
									<v-card class="elevation-8" height="430" >
										<v-card-title>
										<v-flex>
											<v-icon  size="200">signal_cellular_alt</v-icon>
										</v-flex>
										<v-flex  class="text-xs-right">
											<h3 class="display-2 ">98 %<small class="body-1" ></small></h3>
											<h6 class="caption "></h6>
										</v-flex>
										</v-card-title>
										<v-card-actions>
										<div class="body-1"> Efficiency</div>
										</v-card-actions>
									</v-card>
								</v-col>
							   </v-row>
                            </v-tab-item>
                            </v-tabs>
							</v-flex>
					</v-row> 



















	 
















					  <v-row justify="center" >
				<v-flex xs12 sm12 md6 lg6 pa-2>
						<v-card flat class="elevation-8" >
								<v-card-title>
									<h4>Recent Admin Created</h4>
								</v-card-title>
								<v-card-text>
									<v-simple-table  >
										<template v-slot:default>
										<thead color="purple darken-4" dark>
											<tr>
											<th class="text-left">Name</th>
											<th class="text-left">Email</th>
											<th class="text-left">Type</th>
											<th class="text-left">Date</th>
											
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.newAdmin" :key="index">
											<td>{{ item.name }}</td>
											<td>{{ item.email }}</td>
											<td>Admin</td>
											<td>{{ item.created_at }}</td>
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
									<h4>Recent Machine Created</h4>
								</v-card-title>
								<v-card-text>
									<v-simple-table color="accent" >
										<template v-slot:default>
										<thead>
											<tr>
											<th class="text-left"> Name</th>
											<th class="text-left">Email</th>
											<th class="text-left">Type</th>
											<th class="text-left">Date</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.newMachine" :key="index">
											<td>{{ item.name }}</td>
											<td>{{ item.email }}</td>
											<td>Machine</td>
											<td>{{ item.created_at }}</td>
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
import BarChart from "./BarChart.vue";
import BarChart2 from "./BarChart2.vue";
import BarChart3 from "./BarChart3.vue";
export default {
	components: 
	{
		BarChart2,
		BarChart,
		BarChart3
	},
	data: () => ({
	tab:null,
	tab1:null,
	tab2:null,
	dataMachine:[],
	dataMachineWeekly:[],
	dataMachineMonthly:[]
		
	}),
    props:{
			dataList:{},
			dataDay:Array,
		
    },
    	computed: {	
	},
	watch: {
		dataDay()
		{
			if(this.dataDay)
			{
this.getDaily(this.dataDay[0]);
			}
		}
	},

	mounted()
	{
		
	},
		created() {
		this.user_type_id = this.$store.state.authUser.userType
		

	},
	methods: {
		async initialize() {
			
			
			
		},
		async getDaily(item)
                {
					try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/superadmingetmachinedaily/"+item.id,
					});
					this.dataMachine = data;
					} catch (e) {               
					}

						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/superadmingetmachineweekly/"+item.id,
					});
					this.dataMachineWeekly = data;
					} catch (e) {               
					}


						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/superadmingetmachinemonthly/"+item.id,
					});
					this.dataMachineMonthly = data;
					} catch (e) {               
					}





				},
	
	}
}
</script>