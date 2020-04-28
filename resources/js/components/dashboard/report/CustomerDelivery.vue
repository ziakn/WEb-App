<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                         <v-toolbar-title>Email :  {{dataPurchase.email}}</v-toolbar-title>
                         <v-spacer></v-spacer>
                         <v-toolbar-title> Total Coupon Purchase : {{sumCouponCredit}}</v-toolbar-title>
                           <v-spacer></v-spacer>
                         <v-toolbar-title>Consume Coupon : {{ sumCouponDebit }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                         <v-toolbar-title>Remaining Coupon : {{remaningCoupon}}</v-toolbar-title>
                          <v-spacer></v-spacer>
                         <v-toolbar-title> Paid Amount : {{paidAmount}}</v-toolbar-title>
                           <v-spacer></v-spacer>
                         <v-toolbar-title>Remaining Amount : {{remainingAmount}}</v-toolbar-title>
                    </v-toolbar>
                 
                   
					
                             <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                                 <template v-slot:item.date="{ item }">
                                    {{item.routecustomer.route.start_date}}
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
                            @input="getCustomerConsumeCouponReportDeleivery"
                        ></v-pagination>
                    </div>
						
                   
				</v-col>
			</v-row>
               
    </v-container>
    	<v-snackbar
			v-model="snackbar"
			:vertical="snackvertical"
			:timeout="snacktimeout"
			:top="snacktop"
			:color="snackcolor"
			>
			{{ snacktext }}
			<v-btn
				color="white"
				text
				@click="snackbar = false"
			>
				Close
      		</v-btn>
    	</v-snackbar>
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
        tab: null,
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
      
        dataList: [],
        dataPurchase:{},
        headers: [
        { text: "Branch Name", value: "branch_name" },
        { text: "Custody Bottle(rent)", value: "custody_bottle" },
        { text: "Custody Despenser(rent)", value: "custody_despenser"},
        { text: "Bottle Delivered", value: "delivery_bottle" },
        { text: "Custody Delivered", value: "delivery_despenser"},
        { text: "Status", value: "delivery_status"},
        { text: "Date", value: "date" },
       
        ],
       
        editedIndex: -1,
      
        editedItem:
        {
            delivery_bottle:0,
            delivery_despenser:0,
            custody_bottle:0,
            custody_despenser:0,
           
            customer_id:'',
          
        },
        defaultItem: 
        {
            delivery_bottle:0,
            delivery_despenser:0,
            custody_bottle:0,
            custody_despenser:0,
            customer_id:'',
           
           
        },
        filters:
        {
			page: 1,
            show: 20,
            customer_id:''
        },
        customerValue:
        {
            customer_id:''
        },
      
        
  }),
  
  props: {
    source: String
  },
    watch: {
        
    },

  computed: {
    formTitle() 
    {
      return this.editedIndex === -1 ? "Deliever Coupon " : "Edit Deliever Coupon ";
    },
    sumCouponCredit()
    {
         if(this.dataPurchase.customerconsumecoupon)
        {
         let sum1=0;
                for(let o of this.dataPurchase.customerconsumecoupon)
                {
                    sum1= sum1+o.coupon_credit
                }
               return sum1;
        }

    },
    
    sumCouponDebit()
    {
         if(this.dataPurchase.customerconsumecoupon)
        {
         let sum=0;
                for(let o of this.dataPurchase.customerzonebranch)
                {
                    sum= sum+o.delivery_bottle
                }
               return sum;
        }

    },
    remaningCoupon()
    {
         if(this.dataPurchase.customerconsumecoupon)
        {
        let sum1=0;
                for(let o of this.dataPurchase.customerconsumecoupon)
                {
                    sum1= sum1+o.coupon_credit
                }
              

         let sum2=0;
                for(let o of this.dataPurchase.customerzonebranch)
                {
                    sum2= sum2+o.delivery_bottle
                }
            let total=sum1 - sum2;
        return total
        }

    },
    paidAmount()
    {
         if(this.dataPurchase.customerconsumecoupon)
        {
         let sum=0;
                for(let o of this.dataPurchase.customerconsumecoupon)
                {
                    sum= sum+o.paid_amount
                }
               return sum;
        }

    },
    remainingAmount()
    {
         if(this.dataPurchase.customerconsumecoupon)
        {
         let sum=0;
                for(let o of this.dataPurchase.customerconsumecoupon)
                {
                    sum= sum+o.remaining_amount
                }
               return sum;
        }

    },
   
  },
  


  created() 
    {
        this.initialize();
        this.customerValue.customer_id=this.$route.params.id
    },

  methods: 
    {


        async initialize() 
            {
              
                  this.filters.customer_id=this.$route.params.id
                  this.filters.page=1
                
                this.getCustomerConsumeCouponReportDeleivery();
                this.getCustomerInformation();
            },
            
        

        async getCustomerConsumeCouponReportDeleivery() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "post",
                    url: "/app/customerdeliveryreport/report",
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
        async getCustomerInformation() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getgeneraldeatilcustomer/"+this.$route.params.id,
                   
                    });
                    this.dataPurchase = data;
                }
                catch (e) 
                {

                }
               
            },
      

        

     

       
  }
};
</script>
