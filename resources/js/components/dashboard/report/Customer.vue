<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Customer List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                          <template v-slot:item.total_coupon_credit="{ item }" >
                               {{sumCouponCredit(item)}}
                          </template>
                          <template v-slot:item.total_custody_bottle_delivery="{ item }" >
                               {{sumCouponDebit(item)}}
                          </template>
                          <template v-slot:item.remaining_coupon="{ item }" >
                               {{remainigCredit(item)}}
                          </template>
                        <template v-slot:item.action="{ item }">
                                <v-btn x-small color="primary"  @click="reportDeliveryItem(item)"  dark>Delivery Report</v-btn>
                                 <v-btn x-small color="primary"  @click="reportPurchasetItem(item)"  dark>Purchase Report</v-btn>
                                
                        </template>
                        <template v-slot:no-data>
                        <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                        <v-btn color="primary" @click="initialize">Reset</v-btn>
                        </template>
                    </v-data-table>
                    <div class="text-center">
                        <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getCustomerConsumeCoupon"
                        ></v-pagination>
                    </div>
				</v-col>
			</v-row>
    </v-container>
  </v-content>
</template>

<script>
export default {
  components: {
		
	},
  data: () => ({
        loading:false,
        menu3:false,
        valid: true,
       
        snackbar: false,
        dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
        isDelete: false,
        itemsPerPage:1,
        pageCount:2,
		edit: true,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        dialog: false,
        dataCoupon:[],
        dataList: [],
        dataCustomer: [],
        headers: [
        {text: "ID", value: "id"},
        { text: "Customer Email", value: "email" },
        { text: "Total Coupon Purchase", value: "total_coupon_credit" },
        { text: "Consume Coupon", value: "total_custody_bottle_delivery" },
        { text: "Remaining Coupon", value: "remaining_coupon" },
        { text: "Action", value: "action" }
        ],
       
        editedIndex: -1,
        couponType_id:[],
        editedItem:
        {
            customer_id:'',
            couponType_id:[],
            custody_bottle:'',
            custody_despenser:'',
            payment_type:'',
            paid_amount:0,
            remaining_amount:0,
            custody_id:'',
            remaining_credit:'',
        },
        defaultItem: 
        {
            customer_id:'',
            couponType_id:[],
            custody_bottle:'',
            custody_despenser:'',
            payment_type:'',
            paid_amount:0,
            remaining_amount:0,
            custody_id:'',
           remaining_credit:'',
        },
        paymentType:[
            {name:"Cash", value:"cash"},
            {name:"Credit", value:"credit"},
        ],
        filters:
        {
			page: 1,
			show: 20,
        },
        
      
        
  }),
  
  props: {
    source: String
  },

  computed: {
   
   
   
  },
  
  watch: {},

  created() 
    {
        this.initialize();
    },

  methods: 
    {
        async initialize() 
            {
                this.filters.page=1
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getcoupon/coupon"
                    });
                    this.dataCoupon = data;
                }
                catch (e) 
                {

                }
                this.getCustomerConsumeCoupon();
            },
            sumCouponCredit(data)
            {
                let sum=0;
                for(let o of data.customerconsumecoupon)
                {
                    sum= sum+o.coupon_credit
                }
               return sum;
            },
            sumCouponDebit(data)
            {
                 let sum=0;
                for(let o of data.customer_zone_branch)
                {
                    sum= sum+o.delivery_bottle
                }
               return sum;
            },

            remainigCredit(data)
            {
                let sum1=0;
                for(let o of data.customerconsumecoupon)
                {
                    sum1= sum1+o.coupon_credit
                }
               
                let sum2=0;
                for(let o of data.customer_zone_branch)
                {
                    sum2= sum2+o.delivery_bottle
                }
               return sum1-sum2;

            },
      

        async getCustomerConsumeCoupon() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/customerlist/report/",
                    params: this.filters
                    });
                    this.dataList = data.data;
                    this.itemsPerPage=per_page;
                    this.pageCount=last_page;
                    this.filters.page=current_page
                }
                catch (e) 
                {

                }
               
            },
        reportDeliveryItem(item) 
            {       
                 this.$router.push('/dashboard/report/customerconsume/'+ item.id)   
            },
        reportPurchasetItem(item) 
            {       
                 this.$router.push('/dashboard/report/customerpurchase/'+ item.id)   
            },
    
  }
};
</script>
