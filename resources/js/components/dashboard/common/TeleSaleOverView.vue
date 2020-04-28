<template>
 <div>
     <v-row justify="center" >
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="purple darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">done_all</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">#{{dataList.dataTotalAppoinmentFixed}}</h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Appoinment Fixed </div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="deep-purple  darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">done_all</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">#{{dataList.monthlyDataDealFollow}} </h3>
								<h6 class="caption "> current month</h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Appoinment Fixed</div>
							</v-card-actions>
						</v-card>
					</v-flex>
                    <v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="blue darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">zoom_in</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2"># {{dataList.monthlydataDealFollow}}</h3>
								<h6 class="caption">current month</h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Appoinment Follow</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-8" color="indigo darken-4" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">clear</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 "># {{dataList.monthlyDataDealNotComplete}}</h3>
								<h6 class="caption ">current month</h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1">Appoinment Not Complete </div>
							</v-card-actions>
						</v-card>
					</v-flex>

			        </v-row >
                
         
			
    </div>
</template>
<script>
export default {
    props:{
            dataList:{},
    },
    	computed: {	
	
	},
	watch: {},
}
</script>