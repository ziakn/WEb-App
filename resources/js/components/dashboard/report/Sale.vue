<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Sale List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                         
                    </v-toolbar>
                    <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                          <template v-slot:item.coupon_type_id="{ item }">
                               <v-chip class="ma-2" color="primary" small v-for="(i, index) in item.customercoupon" :key="index">{{i.coupon.coupon_no}}</v-chip>
                          </template>
                       
                         <template v-slot:item.saleperson_id="{ item }" >
                             {{item.custodybottle.customersaleperson.email}}
                          </template>

                          <!-- <template v-slot:item.custody_bottle="{ item }" >
                             {{item.custodybottle.custody_bottle}}
                          </template>
                          
                          <template v-slot:item.custody_despenser="{ item }" >
                               {{item.custodybottle.custody_despenser}}
                          </template> -->
                          <template v-slot:item.date="{ item }" >
                               {{item.custodybottle.date}}
                          </template>
                          <template v-slot:item.payment_type="{ item }" >
                              {{item.customerconsumecouponfirstpayment.payment_type}}
                          </template>
                          <template v-slot:item.paid_amount="{ item }" >
                               {{item.customerconsumecouponfirstpayment.paid_amount}}
                          </template>
                          <template v-slot:item.remaining_amount="{ item }" >
                               {{item.customerconsumecouponfirstpayment.remaining_amount}}
                          </template>
                           <template v-slot:item.renew_status="{ item }" >
                                  <v-chip color="primary" outlined small>{{item.customerconsumecouponfirstpayment.renew_status}}</v-chip>
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
                            @input="getCustomerCoupon"
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
      
        dataList: [],
        dataCustomer: [],
        dataSalePerson:[],
        dataCoupon:[],
        headers: [
        { text: "Sale Person ", value: "saleperson_id" },
        { text: "Coupon Type", value: "coupon_type_id" },
        // { text: "Custody Bottle", value: "custody_bottle" },
        // { text: "Custody Despenser", value: "custody_despenser" },
        { text: "Payment Type", value: "payment_type" },
        { text: "Paid Amount", value: "paid_amount" },
        { text: "Remainig Amount", value: "remaining_amount" },
        { text: "Date ", value: "date" },
        { text: "Renew Status", value: "renew_status" },
        ],
       
        editedIndex: -1,
        couponType_id:[],
        showemail:'',
        editedItem:
        {
            saleperson_id:'',
            customer_id:'',
            couponType_id:[],
            custody_bottle:'',
            custody_despenser:'',
            payment_type:'',
            paid_amount:0,
            remaining_amount:0,
            custody_id:''
        },
        defaultItem: 
        {
            saleperson_id:'',
             customer_id:'',
            couponType_id:[],
            custody_bottle:'',
            custody_despenser:'',
            payment_type:'',
            paid_amount:0,
            remaining_amount:0,
            custody_id:''
           
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
    formTitle() 
    {
      return this.editedIndex === -1 ? "Add Coupon " : "Edit Coupon ";
    },
   
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
                
                this.getCustomerCoupon();
                this.getSalePerson();

               
            },
      

        async getSalePerson()
        {
            try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getsaleperson/customercoupon"
                    });
                    this.dataSalePerson = data;
                }
                catch (e) 
                {

                }
        },

        async getCustomerCoupon() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "post",
                    url: "/app/salist/report",
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
      


       
  }
};
</script>
