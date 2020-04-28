<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Customer Coupon List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="800px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">Add Coupon</v-btn>
                                </template>
                                <v-card>
                                <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-form
                                        ref="form"
                                        v-model="valid"
                                        lazy-validation
                                    >
                                <v-container>
                                    <v-row wrap>
                                    <v-col cols="12" sm="12" md="12" lg="6" v-if="edit==false">
                                        <v-text-field
                                            v-model="showemail"
                                            filled
                                            disabled
                                            ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6" v-if="edit==true">
                                          <v-select
                                            v-model="editedItem.customer_id"
                                            :items="dataCustomer"
                                            item-value="id"
                                            item-text="email"
                                            filled
                                            label="Select Customer By Email"
                                            
                                            ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                          <v-select
                                            v-model="editedItem.saleperson_id"
                                            :items="dataSalePerson"
                                            item-value="id"
                                            item-text="email"
                                            filled
                                            label="Select Sale Person By Email"
                                            ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                            <v-select
                                            v-model="couponType_id"
                                            :items="dataCoupon"
                                            item-value="id"
                                            item-text="coupon_no"
                                            filled
                                            multiple
                                            chips
                                            label="Select Coupon Type"
                                            ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                            <v-text-field
                                            v-model="editedItem.custody_bottle"
                                            filled
                                            type="number"
                                            label="Custody Bottle"
                                            ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                             <v-text-field
                                            v-model="editedItem.custody_despenser"
                                            filled
                                            type="number"
                                            label="Custody Despenser"
                                            ></v-text-field>
                                             </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                            <v-select
                                            v-model="editedItem.payment_type"
                                            :items="paymentType"
                                            item-value="value"
                                            item-text="name"
                                            filled
                                            label="Payment  Type"
                                            ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                             <v-text-field
                                            v-model="editedItem.paid_amount"
                                            filled
                                            label="Paid Amount"
                                            type="number"
                                            ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="6">
                                             <v-text-field
                                            v-model="editedItem.remaining_amount"
                                            filled
                                            label="Remainig Amount"
                                            type="number"
                                            ></v-text-field>
                                    </v-col>
                                    </v-row>
                                </v-container>
                                </v-form>
                                </v-card-text>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" text @click="close">Close</v-btn>
                                <v-btn color="primary" :loading="loading" :disabled="loading" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>  
                    </v-toolbar>
                    <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                          <template v-slot:item.coupon_type_id="{ item }">
                               <v-chip class="ma-2" color="primary" small v-for="(i, index) in item.customercoupon" :key="index">{{i.coupon.coupon_no}}</v-chip>
                          </template>
                       
                         <template v-slot:item.saleperson_id="{ item }" >
                             {{item.custodybottle.customersaleperson.email}}
                          </template>

                          <template v-slot:item.custody_bottle="{ item }" >
                             {{item.custodybottle.custody_bottle}}
                          </template>
                          
                          <template v-slot:item.custody_despenser="{ item }" >
                               {{item.custodybottle.custody_despenser}}
                          </template>
                          <template v-slot:item.payment_type="{ item }" >
                              {{item.customerconsumecouponlatestpayment.payment_type}}
                          </template>
                          <template v-slot:item.paid_amount="{ item }" >
                               {{item.customerconsumecouponlatestpayment.paid_amount}}
                          </template>
                          <template v-slot:item.remaining_amount="{ item }" >
                               {{item.customerconsumecouponlatestpayment.remaining_amount}}
                          </template>
                           <template v-slot:item.renew_status="{ item }" >
                                  <v-chip color="primary" outlined small>{{item.customerconsumecouponlatestpayment.renew_status}}</v-chip>
                          </template>
                         
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="editItem(item)" v-on="on">edit</v-icon>
                                </template>
                                <span>Edit </span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="deleteItem(item)" v-on="on">delete</v-icon>
                                </template>
                                <span>Delete</span>
                            </v-tooltip>
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
               	<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
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
import DeleteModal from "./../common/DeleteModal";
export default {
  components: {
		DeleteModal
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
        {text: "ID", value: "id"},
        { text: "Customer Email", value: "email" },
        { text: "Sale Person ", value: "saleperson_id" },
        { text: "Coupon Type", value: "coupon_type_id" },
        { text: "Custody Bottle", value: "custody_bottle" },
        { text: "Custody Despenser", value: "custody_despenser" },
        { text: "Payment Type", value: "payment_type" },
        { text: "Paid Amount", value: "paid_amount" },
        { text: "Remainig Amount", value: "remaining_amount" },
        { text: "Renew Status", value: "renew_status" },
        { text: "Action", value: "action" }
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
                this.getCustomerWithOutCoupon();

               
            },
        async getCustomerWithOutCoupon() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getcustomer/customercoupon"
                    });
                    this.dataCustomer = data;
                }
                catch (e) 
                {

                }
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
                    method: "get",
                    url: "/app/customercoupon",
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
        editItem(item) 
            {       
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    for(let p of this.editedItem.customercoupon)
                                {
                                    this.couponType_id.push( p.coupon.id)

                                }
                    this.showemail= this.editedItem.email
                    this.editedItem.saleperson_id=this.editedItem.custodybottle.saleperson_id
                    this.editedItem.custody_bottle=this.editedItem.custodybottle.custody_bottle
                    this.editedItem.custody_despenser=this.editedItem.custodybottle.custody_despenser
                    this.editedItem.payment_type=this.editedItem.customerconsumecouponlatestpayment.payment_type
                    this.editedItem.paid_amount=this.editedItem.customerconsumecouponlatestpayment.paid_amount
                    this.editedItem.remaining_amount=this.editedItem.customerconsumecouponlatestpayment.remaining_amount
                    this.editedItem.custody_id=this.editedItem.custodybottle.id
                    this.dialog = true;
            },

        deleteItem(item) 
            {
    	            this.dataIndex = this.dataList.indexOf(item);
			        this.deleteTitle = "Are you sure you want to delete this item?";
			        this.isDelete = !this.isDelete;
            },

        close() 
            {
                    this.couponType_id=[]
                    this.dialog = false;
                    setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                    }, 300);
            },

        async save() 
            {
                // if (this.$refs.form.validate())
                // {
                if (this.editedIndex > -1)
                {
                    console.log(this.editedItem)
                try
                {
                    
                   this.loading=true 
                   this.editedItem.couponType_id= this.couponType_id
                   let { data } = await axios({
                   method: "put",
                   url: "/app/customercoupon/" + this.dataList[this.editedIndex].id,
                   data: this.editedItem
                  });
                 if(data.status)
                    {
                        this.snacks('Successfully Done','green')
                        Object.assign(this.dataList[this.editedIndex], data.data);
                        this.loading=false
                        this.close();
                     }
                else
                    {
                        this.snacks("Coupon Type Allready used in database", "red");
                        this.loading = false;
                    }
                } 
                catch (e) 
                    {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                } 
               else
                {
                try 
                {
                    this.loading=true
                    this.editedItem.couponType_id= this.couponType_id
                    let { data } = await axios({
                    method: "post",
                    url: "/app/customercoupon",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataList.unshift(data.data);
                        this.loading=false
                        this.close();
                        this.getCustomerWithOutCoupon();	
                     }
                 else
                    {
						this.snacks("Coupon Type Allready used in database", "red");
						this.loading = false;
					}
                } 
                catch (e) 
                {
                    this.snacks("Failed", "red");
					this.loading = false;
                }
                }
                // }
            },

    async remove() 
        {
            try 
            {
    				let { data } = await axios({
					method: "delete",
					url: "/app/customercoupon/" + this.dataList[this.dataIndex].id
				    });
                    if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataList.splice(this.dataIndex, 1);
                        this.close();	
                        this.getCustomerWithOutCoupon();		
				    }
                    else
                    {
                        this.snacks(data.data,'red')
                        this.loading = false;
                    }

            }
            catch (e) 
            {
                    this.snacks('Operation Failed','red')
                    this.loading = false;
			}
		}
  }
};
</script>
