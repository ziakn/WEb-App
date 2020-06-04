<template>
 <div>
     <v-row justify="center" >
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
		<v-flex xs12 sm12 md12 lg12 pa-2>
									 <v-tabs grow v-model="tab"  background-color="deep-purple accent-4"
										center-active
										dark>
                                <v-tab  v-for="(data,index) in dataDay" :key="index" @change="getDaily(data)">
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
	methods: {
		async initialize() {
			
			
			
		},
		async getDaily(item)
                {
					try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/subadmingetmachinedaily/"+item.id,
					});
					this.dataMachine = data;
					} catch (e) {               
					}

						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/subadmingetmachineweekly/"+item.id,
					});
					this.dataMachineWeekly = data;
					} catch (e) {               
					}


						try 
					{
					let { data } = await axios({
					method: "get",
					url: "/app/subadmingetmachinemonthly/"+item.id,
					});
					this.dataMachineMonthly = data;
					} catch (e) {               
					}





				},
	
	}
}
</script>
