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
                     <v-tabs
                        grow
                        background-color="primary"
                        dark
                        v-model="tab"
                    >
                        <v-tab href="#tab-1">
                        Delivery Report
                        </v-tab>
                        <v-tab href="#tab-2">
                        Purchasing Report
                        </v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
						<v-tab-item value="tab-1">
                             <v-toolbar flat color="white">
                       
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="600px">
                                <!-- <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">Deliver Bottle</v-btn>
                                </template> -->
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
                                    <v-row>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                        <v-text-field
                                            v-model="editedItem.custody_bottle"
                                            filled
                                            label="Custody Bottle (rent)"
                                            type="number"
                                            disabled
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="editedItem.custody_despenser"
                                            filled
                                            label="Enter Despenser (rent)"
                                            type="number"
                                            disabled
                                        ></v-text-field>
                                       <v-text-field
                                            v-model="editedItem.delivery_bottle"
                                            filled
                                            label="Enter Deliver Bottle"
                                            type="number"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="editedItem.delivery_despenser"
                                            filled
                                            label="Enter Deliver Despenser"
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
                                
                                <template v-slot:item.date="{ item }">
                                    {{item.routecustomer.route.start_date}}
                                </template>
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="editItem(item)" v-on="on">edit</v-icon>
                                </template>
                                <span>Edit </span>
                            </v-tooltip>
                            <!-- <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="deleteItem(item)" v-on="on">delete</v-icon>
                                </template>
                                <span>Delete</span>
                            </v-tooltip> -->
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
						</v-tab-item>
                        <v-tab-item value="tab-2">
                            <PurchaseReport :customerValue="customerValue"></PurchaseReport>
						</v-tab-item>
                    </v-tabs-items>
                   
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
import PurchaseReport from "./PurchaseReport";
export default {
  components: {
        DeleteModal,
        PurchaseReport
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
        { text: "Action", value: "action" }
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
    sumCouponCredit(){
        if(this.dataPurchase.customerconsumecoupon)
        {
            var sum1=0;
                for(var o of this.dataPurchase.customerconsumecoupon)
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
                    url: "/app/getcustomerdeliveryreport",
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
        editItem(item) 
            {       
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
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
                    this.editedItem.customer_id=this.$route.params.id
                   this.loading=true
                   let { data } = await axios({
                   method: "put",
                   url: "/app/customercouponconsume/" + this.dataList[this.editedIndex].id,
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
                // try 
                // {
                    
                //     this.editedItem.customer_id=this.$route.params.id
                //     this.loading=true
                //     let { data } = await axios({
                //     method: "post",
                //     url: "/app/customercouponconsume",
                //     data: this.editedItem
                //  });
                // if (data.status) 
                //     {
                //         this.snacks('Successfully Done','green')
                //         this.dataList.unshift(data.data);
                //         this.loading=false
                //         this.close();	
                //      }
                //  else
                //     {
				// 		this.snacks("Coupon Type Allready used in database", "red");
				// 		this.loading = false;
				// 	}
                // } 
                // catch (e) 
                // {
                //     this.snacks("Failed", "red");
				// 	this.loading = false;
                // }
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
