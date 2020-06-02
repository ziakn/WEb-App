<template>
 <div>
     <v-row justify="center" >
        
					<v-flex xs12 sm6 md4 lg3 pa-2>
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
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="deep-purple  darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">attach_money</v-icon>
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
						<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
									<BarChart :dataList="dataList" />	
									 <!-- <v-tabs vertical v-model="tab">
                                <v-tab v-for="(data,index) in dataDay" :key="index" >
                                  {{data.name}}
                                </v-tab>
                                <v-tab-item  v-model="tab">
									<v-card flat max-width="1050">
                                  
                                                <v-card-text>
                                                    {{data.name}} /
													{{item.name}}
											</v-card-text>
									</v-card>
                                </v-tab-item>
                            </v-tabs>			 -->
							</v-card>
						</v-flex>
						<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
									<BarChart2 :dataList="dataList" />				
							</v-card>
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
export default {
	components: 
	{
		BarChart2,
		BarChart,
	},
	data: () => ({
	tab:null,
		dataDay:[],
		
	}),
    props:{
            dataList:{},
    },
    	computed: {	
	},
	watch: {},

	mounted()
	{
		
	},
		created() {
		this.user_type_id = this.$store.state.authUser.userType
		this.initialize();

	},
	methods: {
		// async initialize() {
			
		// 	try {
		// 		let { data } = await axios({
		// 			method: "get",
		// 			url: "/app/dashboardoverview"
		// 		});
		// 		this.dataDay = data;
				
		// 	} catch (e) {
		// 					this.loading=false;                
		// 	}
			
		// },
	}
}
</script>