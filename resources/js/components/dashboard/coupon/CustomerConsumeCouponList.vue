<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Customer Consume Coupon List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                                <v-dialog v-model="dialog" persistent max-width="600px">
                                <v-card>
                                <v-card-title>
                                <span class="headline">Renew Coupon / Confirm Coupon</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-form
                                        ref="form"
                                        v-model="valid"
                                        lazy-validation
                                    >
                                <v-container>
                                    <v-row>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                        <v-text-field
                                            v-model="editedItem.email"
                                            item-value="id"
                                            item-text="email"
                                            filled
                                            label="Select Customer By Email"
                                            disabled
                                            v-if="edit==false"
                                            ></v-text-field>
                                          <v-select
                                            v-model="editedItem.customer_id"
                                            :items="dataCustomer"
                                            item-value="id"
                                            item-text="email"
                                            filled
                                            label="Select Customer By Email"
                                            v-if="edit==true"
                                            ></v-select>
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
                                            <v-text-field
                                            v-model="editedItem.custody_bottle"
                                            filled
                                            type="number"
                                            label="Custody Bottle"
                                            ></v-text-field>
                                             <v-text-field
                                            v-model="editedItem.custody_despenser"
                                            filled
                                            type="number"
                                            label="Custody Despenser"
                                            ></v-text-field>
                                            <v-select
                                            v-model="editedItem.payment_type"
                                            :items="paymentType"
                                            item-value="value"
                                            item-text="name"
                                            filled
                                            label="Payment Type"
                                            ></v-select>
                                             <v-text-field
                                            v-model="editedItem.paid_amount"
                                            filled
                                            label="Paid Amount"
                                            type="number"
                                            ></v-text-field>
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
                                <v-btn color="primary" :loading="loading" :disabled="loading" text @click="saveRenew">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog> 
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
                                <v-btn x-small color="primary"  @click="reportItem(item)"  dark>Report</v-btn>
                                <v-btn x-small color="red lighten-1"  @click="renewItem(item)"  dark v-if="(sumCouponCredit(item)-sumCouponDebit(item)) <= 15">Renew Coupon</v-btn>
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
                    url: "/app/customercouponconsume",
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
        reportItem(item) 
            {       
                 this.$router.push('/dashboard/coupon/customerconsumecouponreport/'+ item.id)   
            },
        renewItem(item)
            {
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    for(let p of this.editedItem.customercoupon)
                                {
                                    this.couponType_id.push( p.coupon.id)

                                }
                    let sum1=0;
                    for(let o of this.editedItem.customerconsumecoupon)
                    {
                        sum1= sum1+o.coupon_credit
                    }
                
                    let sum2=0;
                    for(let o of this.editedItem.customer_zone_branch)
                    {
                        sum2= sum2+o.delivery_bottle
                    }
                    this.editedItem.remaining_credit = sum1-sum2;
                    this.editedItem.custody_bottle=this.editedItem.custodybottle.custody_bottle
                    this.editedItem.custody_despenser=this.editedItem.custodybottle.custody_despenser
                    this.editedItem.custody_id=this.editedItem.custodybottle.id
                    this.dialog = true;
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

        async saveRenew() 
            {
                // if (this.$refs.form.validate())
                // {
                
                try 
                {
                    this.loading=true
                    this.editedItem.couponType_id= this.couponType_id
                    let { data } = await axios({
                    method: "post",
                    url: "/app/renewcustomercoupon",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                         this.getCustomerConsumeCoupon();
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
