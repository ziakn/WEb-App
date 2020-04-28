<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Route Name :  {{routeUserData.email}}</v-toolbar-title>
                          <v-spacer></v-spacer>
                         <v-toolbar-title>Zone No : <v-chip class="ma-2" color="primary" small v-for="(i, index) in routeUserData.route.multiplezone" :key="index">{{i.parentzone.zone_no}}</v-chip> </v-toolbar-title>
                           <v-spacer></v-spacer>
                         <v-toolbar-title>Start Date : {{routeUserData.route.start_date}}</v-toolbar-title>
                           <v-spacer></v-spacer>
                         <v-toolbar-title>Start Date : {{routeUserData.route.start_day}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                          <v-toolbar-title>Assign Stock : {{routeUserData.route.assign_bottle}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" dark class="mb-2" @click="getNewRouteCustomerList">Choose New Customer </v-btn>
                        <v-dialog v-model="dialog" persistent max-width="850px" scrollable>
                                <v-card>
                                <v-card-title>Choose New Customer</v-card-title> 
                                <v-divider></v-divider>
                                <v-card-text style="height: 400px;">
                                <v-container>
                                    <v-row>
                                        <v-data-table  v-model="newSelectedCustomer" item-key="id" show-select :single-select="singleSelect" :headers="headers"  :items="dataList" hide-default-footer flat>
                                        <template v-slot:item.name="{ item }">
                                            {{item.user.name}}
                                        </template>
                                        <template v-slot:item.email="{ item }">
                                            {{item.user.email}}
                                        </template>
                                        <template v-slot:item.zone_id="{ item }">
                                            {{item.zone.zone_no}}
                                        </template>
                                    <template v-slot:item.renew_status="{ item }">
                                     <p v-if="item">new</p>
                                    </template>
                                        </v-data-table>
                                    </v-row>
                                </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" text @click="dialog = false">Close</v-btn>
                                <v-btn color="primary" :loading="loading" :disabled="loading" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>  
                    </v-toolbar>
                    <v-data-table  v-model="selectedCustomer"  item-key="id" show-select :single-select="singleSelect" :headers="headers"  :items="assignedCustomerData" hide-default-footer>
                        <template v-slot:item.name="{ item }">
                            {{item.user.name}}
                        </template>
                        <template v-slot:item.email="{ item }">
                            {{item.user.email}}
                        </template>
                      <template v-slot:item.zone_id="{ item }">
                          {{item.zone.zone_no}}
                      </template>
                        <template v-slot:item.renew_status="{ item }">
                           <v-chip small color="green" outlined v-if="item.routecustomerstatus.renew_status=='new'">{{item.routecustomerstatus.renew_status}}</v-chip>
                           <v-chip small color="primary" outlined v-else>{{item.routecustomerstatus.renew_status}}</v-chip>  
                        </template>
                    </v-data-table>
                   
				</v-col>
			</v-row>
               <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-btn bottom color="primary"  v-on="on" dark v-show="updateListButton" fixed right @click="updateList">
                             Update List
                        </v-btn>
                    </template>
                    <span>Add New Data</span>
              </v-tooltip>
               
           <v-dialog  v-model="loadingdialog" hide-overlay persistent width="300">
                <v-card color="primary" dark >
                    <v-card-text>
                    Please wait New Customer data is storing...
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                    </v-card-text>
                </v-card>
        </v-dialog>
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
                singleSelect: false,
                singleSelect2: false,
                menu3:false,
                menu2:false,
                valid: true,
                snackbar: false,
                dataIndex: null,
                deleteTitle: "",
                deleteBody: "",
                isDelete: false,
                loadingdialog:false,
                edit: true,
                mode: "",
                timeout: 6000,
                text: "Hello, I'm a snackbar",
                dialog: false,
                dataList: [],
                newSelectedCustomer:[],
                selectedCustomer:[],
                assignedCustomerData:[],
                routeUserData:{
                    zone:
                    {
                        zone_no:"",
                    },
                    route:
                    {
                        start_date:"",
                        end_date:"",
                    }
                },
                headers: [
                {text: "ID", value: "id"},
                { text: "Customer Name ", value: "name" },
                { text: "Email ", value: "email" },
                {text: "Branch Name", value: "branch_name"},
                {text: "Custody Bottle(branchwise) ", value: "custody_bottle"},
                {text: "Custody Despenser(branchwise) ", value: "custody_despenser"},
                {text: "Status ", value: "renew_status"},
                { text: "Zone ", value: "zone_id" },
                ],
                passwordRules: 
                [
                v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
                ],
                editedIndex: -1,
                editedItem:
                {
                    newSelectedCustomer:[],
                    selectedCustomer:[],
                    user_id:'',
                    route_id:'',
                },
                defaultItem: 
                {
                    newSelectedCustomer:[],
                    selectedCustomer:[],
                    user_id:'',
                    route_id:'',
                },
     
       
      
  }),
  
  props: {
    source: String
  },

  computed: {
    formTitle() 
    {
      return this.editedIndex === -1 ? "New Route" : "Edit Route";
    },

     updateListButton()
    {
        if( this.selectedCustomer.length < this.assignedCustomerData.length)
        {
            return true
        }
        else
        {
            return false
        }
    }
   
  },
  
  watch: 
  {
     
  },

  created() 
    {
        this.initialize();
    },

  methods: 
    {
        async initialize() 
            {
                 try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/routeuser/route/"+this.$route.params.id,
                    });
                    this.routeUserData = data;
                }
                catch (e) 
                {

                }
                this.getRouteCustomerList();
            },

        async getRouteCustomerList() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/routecustomer/"+this.$route.params.id,
                    });
                    this.assignedCustomerData = data;
                    for(let o of this.assignedCustomerData)
                    {
                        this.selectedCustomer.push(o)
                    }
                   
                }
                catch (e) 
                {

                }
            },

         async getNewRouteCustomerList() 
            {
                try 
                {
                    this.dialog=true
                    this.loadingdialog=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/getroutecustomerlistnew/routecustomer",
                    data: this.routeUserData
                    });
                    this.dataList = data;
                    this.loadingdialog=false
                   
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
                    this.dialog1 = false;
                    this.loading = false;
                    this.newSelectedCustomer=[];
                    setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                    }, 300);
            },

        async save() 
            {
                
                try 
                {
                    this.editedItem.newSelectedCustomer = this.newSelectedCustomer
                    this.editedItem.user_id = this.$route.params.id
                    this.editedItem.route_id  = this.routeUserData.route.id
                    this.loading=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/routecustomer",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.getRouteCustomerList();
                        this.close();
                     }
                 else
                    {
						this.snacks("User Name used in database", "red");
						this.loading = false;
					}
                } 
                catch (e) 
                {
                    this.snacks("Failed", "red");
					this.loading = false;
                }
                
                
            },

            async updateList() 
            {
               
                try 
                {
                    this.editedItem.selectedCustomer = this.selectedCustomer
                    this.editedItem.user_id = this.$route.params.id
                    this.editedItem.route_id =  this.routeUserData.route.id
                    this.loading=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/routecustomerlistupdate/routecustomer",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                         this.getRouteCustomerList();
                        this.close();
                     }
                 else
                    {
						this.snacks("User Name used in database", "red");
						this.loading = false;
					}
                } 
                catch (e) 
                {
                    this.snacks("Failed", "red");
					this.loading = false;
                }
                
                
            },

 

      
        
  },
  
};
</script>
