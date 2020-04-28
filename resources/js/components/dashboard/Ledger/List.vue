<template>
<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-row justify="center">
                      <v-col sm="12" md="6" lg="3">
                            <v-select
                                v-model="filters.user_id"
                                :items="dataUser"
                                item-text="name"
                                item-value="id"
                                label="Belongs To"
                                required
							                	clearable
                                filled
								                @change="getLedger"
                            ></v-select>                            
                      </v-col>
                      <v-col sm="12" md="6" lg="3">
                            <v-select
                                v-model="filters.type"
                                :items="ledgerType"
                                item-text="text"
                                item-value="value"
                                label="Ledger Type"
                                required
							                	clearable
                                filled
								                @change="getLedger"
                            ></v-select>                            
                      </v-col>
                      <v-col sm="12" md="6" lg="2">
                            <v-select
                                v-model="filters.ledger_head_id"
                                :items="dataLedgerHead"
                                item-text="ledger_name"
                                item-value="id"
                                label="Ledger Head"
                                required
							                	clearable
                                filled
								                @change="getLedger"
                            ></v-select>                            
                      </v-col>
                      <v-col  sm="12" md="6" lg="2">
                            <v-menu
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                     min-width="290px"
                                    >
                                    <template v-slot:activator="{ on }">
                                    <v-text-field
                                    v-model="filters.month"
                                    label="Month"
                                    prepend-inner-icon="event"
                                    readonly
                                    v-on="on"
                                    clearable
                                    @click:clear="initialize"
                                    filled
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker  type="month" @change="getLedger" v-model="filters.month" @input="menu= false"></v-date-picker>
                                </v-menu>
                        </v-col>
                        <v-col  sm="12" md="6" lg="2">
                            <v-menu
                                v-model="date2"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"  
                            >
                            <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="filters.start"
                                label="Date"
                                readonly
                                prepend-inner-icon="event"
                                v-on="on"
                                clearable
                                @click:clear="initialize"
                                filled
                            ></v-text-field>
                            </template>
                            <v-date-picker @change="getLedger" v-model="filters.start" @input="date2 = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                        
      	</v-row>
        <v-toolbar flat color="white">
            <v-toolbar-title>Ledger List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
          
            <v-chip outlined color="blue darken-4" label text-color="black" >
                   Total Income 
            <v-divider class="mx-2" inset vertical></v-divider>
                   {{totalIncome}}
            </v-chip>
              <v-divider class="mx-1" inset vertical></v-divider>
            <v-chip outlined color="blue darken-4" label text-color="black" >
                   Total Expense
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{totalExpense}}
          </v-chip>
           <v-divider class="mx-2" inset vertical></v-divider>
          
            <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current Month Income 
            <v-divider class="mx-2" inset vertical></v-divider>
                   {{currentMonthIncome}}
            </v-chip>
              <v-divider class="mx-2" inset vertical></v-divider>
            <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current Month Expense
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{currentMonthExpense}}
          </v-chip>
             <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">Create Ledger</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 sm12 md12>
                        <v-menu
                                v-model="date1"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                                
                            >
                                <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="editedItem.date"
                                    label="Date"
                                    readonly
                                    prepend-inner-icon="event"
                                    v-on="on"
                                    filled
                                ></v-text-field>
                                </template>
                                <v-date-picker v-model="editedItem.date" @input="date1 = false"></v-date-picker>
                            </v-menu>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field
                          v-model="editedItem.remark"
                          label="Remark"
                          :rules="[v => !!v || 'Remark  is required']"
                          required
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-select
                          v-model="editedItem.type"
                          :items="ledgerType"
                          item-text="text"
                          item-value="value"
                          :rules="[v => !!v || 'Ledger Type required']"
                          label="Leadger Type"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-select
                          v-model="editedItem.ledger_head_id"
                          :items="dataLedgerHead"
                          item-text="ledger_name"
                          item-value="id"
                          :rules="[v => !!v || 'Ledger Head required']"
                          label="Leadger Head"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-select
                          v-model="editedItem.user_id"
                          :items="dataUser"
                          item-text="name"
                          item-value="id"
                          :rules="[v => !!v || 'Belongs To required']"
                          label="Belongs To"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                      
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        v-model="editedItem.amount"
                        :rules="[v => !!v || 'Amount is required']"
                        label="Amount"
                        filled
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-container>
              </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="primary" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataLedger"  hide-default-footer>
            <template v-slot:item.user_id="{ item }">
                {{item.user.name}}
            </template>
            <template v-slot:item.ledger_head_id="{ item }">
                {{item.ledgerhead.ledger_name}}
            </template>
            <template v-slot:item.income="{ item }">
                  <p  v-if="item.income==null"><v-icon  >minimize</v-icon></p>
                  <p v-else>{{item.income}}</p>
            </template>
            <template v-slot:item.expense="{ item }">
                  <p  v-if="item.expense==null"><v-icon  >minimize</v-icon></p>
                  <p v-else>{{item.expense}}</p>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small @click="editItem(item)" v-if="item.deal_id==null" >edit</v-icon>
            <v-icon small @click="deleteItem(item)"  v-if="item.deal_id==null" >delete</v-icon>
            </template>
            <template v-slot:no-data>
                <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                   No Data Found
                  <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
            </template>
            <template v-slot:no-data>
              <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                 No Data Found
              <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
            </template>
            </v-data-table>
                    <div class="text-center">
                            <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getLedger"
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
                 search:"",
                 menu:false,
                absolute: true,
                loading:false,
                date1:false,
                date2:false,
                date3:false,
                snackbar: false,
                dataIndex: null,
                deleteTitle: "",
                deleteBody: "",
                isDelete: false,
                edit: true,
                dialog: false,
                itemsPerPage:1,
                pageCount:2,
                timeout: 6000,
                text: "Hello, I'm a snackbar",
                dialog: false,
                dataLedger: [],
                dataUser: [],
                dataLedgerHead: [],
                totalIncome:[],
                totalExpense:[],
                currentMonthIncome:[],
                currentMonthExpense:[],
                headers:
                 [
                        { text: "ID", align: "left", value: "id" },
                        { text: "Ledger Head", value: "ledger_head_id" },
                        { text: "Belong To", value: "user_id" },
                        { text: "Type", value: "type" },
                        { text: "Expense", value: "expense" },
                        { text: "Income", value: "income" },
                         { text: "Remark", value: "remark" },
                         { text: "Date", value: "date" },
                        { text: "Action", value: "action" }
                ],
    
                editedIndex: -1,
                editedItem:
                {
                        type:"",
                        user_id: "",
                        expense: "",
                        income:"",
                        date:'',
                        remark: "",
                        amount:"",
                        
                },
                ledgerType:
                [
                        { text: "Income", value: "income" } ,
                        { text: "Expense", value: "expense" } ,
                ],
                defaultItem: 
                {
                        type:"",
                        user_id: "",
                        expense: "",
                        income:"",
                        date:'',
                        remark: "",
                        amount:"",
                       
                },
                filters:
                {
                        user_id:null,
                        type:"",
                        start:"",
                        month:'',
                        ledger_head_id:"",
                        page: 1,
                        show: 20,
                },
               }),
                props:
                {           
                },
                computed: 
                {
                        formTitle()
                        {
                          return this.editedIndex === -1 ? "New Ledger" : "Edit Ledger";
                        }
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
                          url: "/app/ledgerhead"
                          });
                          this.dataLedgerHead = data;
                  }
                  catch (e)
                    {
                    }

                  try
                  {
                          let { data } = await axios({
                          method: "get",
                          url: "/app/getuser/ledger"
                          });
                          this.dataUser = data;
                  }
                  catch (e) 
                      {
                      }
                      this.getLedger();
    },

    async getLedger()
    {
      
                try
                {
                        let { data } = await axios({
                        method: "get",
                        url: "/app/ledger",
                        params: this.filters
                        });
                        this.dataLedger = data.data.data;
                        this.itemsPerPage=data.data.per_page;
                        this.pageCount=data.data.last_page;
                        this.filters.page=data.data.current_page
                        this.totalIncome = data.totalIncome;
                        this.totalExpense = data.totalExpense;
                        this.currentMonthIncome = data.currentMonthIncome;
                        this.currentMonthExpense = data.currentMonthExpense;
                        this.loading=false;
                } 
                catch (e) 
                {
                        this.loading=false;   
                }

    },

    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataLedger.indexOf(item);
      this.editedItem = Object.assign({}, item);
      if(item.type == "income")
      {
         this.editedItem.amount = item.income
      }
      else if(item.type == "expense")
      {
          this.editedItem.amount = item.expense
      }
      this.dialog = true;
    },
    deleteItem(item) {
    	this.dataIndex = this.dataLedger.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    async save() {
      if (this.editedIndex > -1) {
        try {
          let { data } = await axios({
            method: "put",
            url: "/app/ledger/" + this.dataLedger[this.editedIndex].id,
            data: this.editedItem
          });
          if(data.status)
          {
              this.snacks('Successfully Done','green')
               Object.assign(this.dataLedger[this.editedIndex], data.data);
               this.close();
          }
          else
          {
                this.snacks(data.data,'red')
					      this.loading = false;
          }
       
        } catch (e) {
        }
      } else {
        try {
          let { data } = await axios({
            method: "post",
            url: "/app/ledger",
            data: this.editedItem
          });
         
          if(data.status)
          {
              	this.snacks('Successfully Done','green')
                this.dataLedger.unshift(data.data);
                this.close();
          }
          else
          {
                this.snacks(data.data,'red')
					      this.loading = false;
          }
        } catch (e) {
        }
      }
    },
    async remove() {
			this.loading=true;
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/ledger/" + this.dataLedger[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataLedger.splice(this.dataIndex, 1);
					this.close();				
				}
				else
				{
					this.snacks(data.data,'red')
					this.loading = false;
				}

			} catch (e) {
				this.snacks('Operation Failed','red')
				this.loading = false;
			}
		}
  }
};
</script>