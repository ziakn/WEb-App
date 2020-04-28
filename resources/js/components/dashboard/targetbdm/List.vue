<template>
  <v-content>
    <v-container fluid>
      <v-overlay :value="showFullLoading" :absolute="absolute">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
         <v-row justify="center">
            <v-col sm="12" md="12" lg="11">
              <v-row>
                   <v-col xs="12" sm="12" md="6" lg="6">
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
                                    filled
                                    clearable
                                    @click:clear="initialize"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker  type="month" @change="getTargetListBDM" v-model="filters.month" @input="menu= false"></v-date-picker>
                          </v-menu>
                  </v-col>
                  <v-col sm="12" md="6" lg="6">
                            <v-select
                                v-model="filters.type"
                                :items="type"
                                item-text="text"
                                item-value="value"
                                label="Type"
                                required
							                	clearable
                                filled
								                @change="getTargetListBDM"
                            ></v-select>                            
                      </v-col>
            </v-row>
            <v-toolbar flat color="white">
                  <v-toolbar-title>BDM Target List</v-toolbar-title>
                  <v-divider class="mx-2" inset vertical></v-divider>
                  <v-spacer></v-spacer>
                  <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current month Target (amount)
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{monthlyTargetAmount}}
                  </v-chip>
                  <v-spacer></v-spacer>
                  <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current month Target (number)
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{monthlyTargetNumber}}
                  </v-chip>
                   <v-divider class="mx-2" inset vertical></v-divider>
                    <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current month Sale (amount)
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{monthlySaleAmount}}
                  </v-chip>
                  <v-spacer></v-spacer>
                  <v-chip outlined color="blue darken-4" label text-color="black" >
                   Current month Sale (number)
                  <v-divider class="mx-2" inset vertical></v-divider>
                   {{monthlySaleNumber}}
                  </v-chip>
         
                  <v-spacer></v-spacer>
                
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataTarget" :items-per-page="filters.show">
            <!-- <template v-slot:item.bdm_id="{ item }">{{item.bussinessdm.name}}</template> -->
            <template v-slot:item.debit="{ item }">
             <p  v-if="item.debit==null"><v-icon  >minimize</v-icon></p>
             <p v-else>{{item.debit}}</p>
              </template>
            <template v-slot:item.volume_debit="{ item }">
              <p  v-if="item.volume_debit==null"><v-icon >minimize</v-icon></p>
              <p v-else>{{item.volume_debit}}</p>
              </template>
            <template v-slot:no-data>
              <v-skeleton-loader type="table-tbody"></v-skeleton-loader>No Data Found
              <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
            </template>
          </v-data-table>
          <div class="text-center">
                            <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getTargetListBDM"
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
      <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-content>
</template>

<script>

export default {
  components: {
   
  },
  data: () => ({
     valid: false,
    absolute: true,
    loading: false,
    menu: false,
    menu1: false,
    snackbar: false,
    dataIndex: null,
    deleteTitle: "",
    deleteBody: "",
    isDelete: false,
    edit: true,
    dialog: false,
    itemsPerPage:1,
    pageCount:2,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    dialog: false,
    dataTarget: [],
    monthlyTargetAmount:[],
    monthlyTargetNumber:[],
    monthlySaleAmount:[],
    monthlySaleNumber:[],
    headers: [
      { text: "ID", align: "left", value: "id" },
      { text: "Name", value: "bdm_id" },
      { text: "Debit", value: "debit" },
      { text: "Volume Debit", value: "volume_debit" },
      { text: "Type", value: "type" },
      { text: "Remark", value: "remark" },
      { text: "Date", value: "date" },
    ],

    editedIndex: -1,
    editedItem: {
      id: "",
      admin_id: "",
      deal_id: "",
      date: "",
      year: "",
      type: "",
      target_debit: "",
      balance: "",
      status: ""
    },
    status: [{ text: "Active", value: 1 }, { text: "In Active", value: 0 }],
     type:[
                  { text: "Numbers", value: 'number' },
                  { text: "Amount", value: 'amount' },
              ],
    defaultItem: {
      id: "",
      admin_id: "",
      deal_id: "",
      date: "",
      year: "",
      type: "",
      target_debit: "",
      balance: "",
      status: ""
    },
    filters:
        {
            month:'',
            type:'',
            page: 1,
            show: 20,
        },
  }),
  props: {
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
    initialize()
      {
         this.filters.month='';
         this.filters.page=1
          this.getTargetListBDM();
      },
      async getTargetListBDM()
      {
            try {
              let { data } = await axios({
                method: "post",
                url: "/app/gettargetlistbdm/target",
                params: this.filters
              });
              this.dataTarget = data.data;
              this.monthlyTargetAmount = data.monthlyTargetAmount;
              this.monthlyTargetNumber = data.monthlyTargetNumber;
              this.monthlySaleAmount = data.monthlySaleAmount;
              this.monthlySaleNumber = data.monthlySaleNumber;
              this.itemsPerPage=per_page;
              this.pageCount=last_page;
              this.filters.page=current_page
             
            } catch (e) {}
    },

   
    
   
    

    
  }
};
</script>