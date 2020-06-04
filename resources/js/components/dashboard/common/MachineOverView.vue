<template>
 <div>
 
	
	<v-row  justify="center" >
		<v-flex xs12 sm12 md12 lg12 pa-2>
								
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
			dataDay:{},
		
    },
    	computed: {	
	},
	watch: {},

	mounted()
	{
		
	},
		created() {
		this.user_type_id = this.$store.state.authUser.userType
		this.getDaily();
	},
	methods: {
		async initialize() {
			
			
			
		},
		async getDaily()
                {
					try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/machineadmingetmachinedaily/"+this.user_type_id,
					});
					this.dataMachine = data;
					} catch (e) {               
					}

						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/machineadmingetmachineweekly/"+this.user_type_id,
					});
					this.dataMachineWeekly = data;
					} catch (e) {               
					}


						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/machineadmingetmachinemonthly/"+this.user_type_id,
					});
					this.dataMachineMonthly = data;
					} catch (e) {               
					}





				},
	
	}
}
</script>