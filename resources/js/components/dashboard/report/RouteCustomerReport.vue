<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                         <v-toolbar-title>Route Customer Report </v-toolbar-title>
                    </v-toolbar>
                    
               
					
                <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                      <template v-slot:item.name="{ item }">
                            {{item.user.name}}
                        </template>
                        <template v-slot:item.email="{ item }">
                            {{item.user.email}}
                        </template>
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

        headers: [
        { text: "Customer Name", value: "name" },
        { text: "Email ", value: "email" },
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
           
            route_id:'',
          
        },
        defaultItem: 
        {
            delivery_bottle:0,
            delivery_despenser:0,
            custody_bottle:0,
            custody_despenser:0,
            route_id:'',
           
           
        },
        filters:
        {
			page: 1,
            show: 20,
           
        },
        customerValue:
        {
            route_id:''
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
  },
  


  created() 
    {
        this.initialize();
        this.customerValue.route_id=this.$route.params.id
    },

  methods: 
    {


        async initialize() 
            {
              
               
                  this.filters.page=1
                
                this.getCustomerConsumeCouponReportDeleivery();
               
            },
            
        

        async getCustomerConsumeCouponReportDeleivery() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "put",
                    url: "/app/routecustomerreport/report/"+this.$route.params.id,
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

  

 
  }
};
</script>
