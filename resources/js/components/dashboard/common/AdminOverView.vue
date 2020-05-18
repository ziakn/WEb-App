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
								</v-card>
						</v-flex>
						<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
									<BarChart2 :dataList="dataList" />				
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
    props:{
            dataList:{},
    },
    	computed: {	
	},
	watch: {},

	mounted()
	{
		
	},
	method:{
		
		
		
	}
}
</script>