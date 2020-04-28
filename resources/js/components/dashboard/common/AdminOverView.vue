<template>
 <div>
     <v-row justify="center" >
        
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color=" cyan darken-3 " dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">people</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.totalCustomer}} </h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Registered Customer</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color="teal lighten-1" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">people</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.totalDriver}} </h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Total Registered Driver</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color="cyan darken-1" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">note</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 " v-for="(i,index) in this.dataList.totalCouponPurchase" :key="index"> {{i.coupon}}</h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1">Total Coupon Purchase </div>
							</v-card-actions>
						</v-card>
					</v-flex>

					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color=" teal lighten-3 " dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">local_shipping</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2"> {{dataList.totalVehicle}}</h3>
								<h6 class="caption"></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Company Vehicle</div>
							</v-card-actions>
						</v-card>
					</v-flex>
			        </v-row >

<v-row  justify="center" >
						<v-flex xs12 sm12 md6 lg6 pa-2>
							<v-card flat class="elevation-8">
									<BarChart :dataList="dataList" />				
								</v-card>
						</v-flex>
						<v-flex xs12 sm12 md6 lg6 pa-2>
								<v-card flat class="elevation-8">
									<AreaChart :dataList="dataList" />			
								</v-card>
						</v-flex>
						
					</v-row>



					 <v-row justify="center" >
						<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color=" teal lighten-3 " dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">gesture</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2"> {{dataList.todayActiveRoute}}</h3>
								<h6 class="caption"></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Today Route</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color="cyan darken-1" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">people</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 " > {{dataList.todayCustomerDelivery}}</h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1">Today Total Delivery </div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color="teal lighten-1" dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon size="72">people</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.todayCustomerDelivered}} </h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Today Delivery Done</div>
							</v-card-actions>
						</v-card>
					</v-flex>
					<v-flex xs12 sm6 md4 lg3 pa-2>
						<v-card class="elevation-5" color=" cyan darken-3 " dark>
							<v-card-title>
							<v-flex xs6>
								<v-icon  size="72">money</v-icon>
							</v-flex>
							<v-flex xs6 class="text-xs-right">
								<h3 class="display-2 ">{{dataList.todaySale}} </h3>
								<h6 class="caption "></h6>
							</v-flex>
							</v-card-title>
							<v-card-actions>
							<div class="body-1"> Today sale closed </div>
							</v-card-actions>
						</v-card>
					</v-flex>
			        </v-row >
					
					

					

					


					<v-row  justify="center" >
						<v-flex xs12 sm12 md6 lg6 pa-2>
								<v-card flat class="elevation-8">
									<v-card-title>
										<h3>Recent Customer Inrolled</h3>
									</v-card-title>
									<v-card-text>
										 <v-simple-table  >
										<template v-slot:default>
										<thead color="purple darken-4" dark>
											<tr>
											<th class="text-left">Name</th>
											<th class="text-left">Email</th>
											<th class="text-left">DOB</th>
											<th class="text-left">Type</th>
											
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.dataNewCustomer" :key="index">
											<td>{{ item.name }}</td>
											<td>{{ item.email }}</td>
											<td>{{ item.date_of_birth }}</td>
											<td>Customer</td>
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
										<h3>Recent Sale Closed </h3>
									</v-card-title>
									<v-card-text>
										 <v-simple-table  >
										<template v-slot:default>
										<thead color="purple darken-4" dark>
											<tr>
											<th class="text-left">Sale Person</th>
											<th class="text-left">Coupon</th>
											<th class="text-left">Payment Type</th>
											<th class="text-left">Paid Amount</th>
											<th class="text-left">Remainig Amount</th>
											
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in dataList.newSale" :key="index">
											<td> {{item.custodybottle.customersaleperson.email}}</td>
											<td> <v-chip class="ma-2" color="primary" small v-for="(i, index) in item.customercoupon" :key="index">{{i.coupon.coupon_no}}</v-chip></td>
											<td>  {{item.customerconsumecouponfirstpayment.payment_type}}</td>
											<td> {{item.customerconsumecouponfirstpayment.paid_amount}}</td>
											<td>  {{item.customerconsumecouponfirstpayment.remaining_amount}}</td>
											</tr>
										</tbody>
										</template>
									</v-simple-table>
									</v-card-text>
									</v-card>
						</v-flex>
				</v-row>
				<v-row>
					<v-flex xs12 sm12 md12 lg12 pa-2>
							<v-card flat class="elevation-8">
								<v-card-title>
									<h3>Customer By Zone</h3>
								</v-card-title>
								<v-card-text>
								    <PieChart :height="800" :dataList="dataList" />
								</v-card-text>
								</v-card>
						</v-flex>
				</v-row>
         
 </div>
</template>
<script>
import AreaChart from "./AreaChart.vue";
import BarChart from "./BarChart.vue";
import PieChart from "./PieChart.vue";
export default {
	components: 
	{
		AreaChart,
		BarChart,
		PieChart,
	},
	props:{
			dataList:{},
		
			totalCouponPurchase:Array,
			
    },
	data: () => ({
     
    }),

    
    	
	watch: {},
	computed:{
	},
	created()
	{
		
	},
}
</script>