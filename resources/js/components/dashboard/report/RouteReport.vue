<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Route Report List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-data-table :headers="headers"  :items="dataList" class="elevation-1">
                         <template v-slot:item.id="{ item }" >
                            {{item.user.id}}
                        </template>
                         <template v-slot:item.email="{ item }" >
                            {{item.user.email}}
                        </template>
                          <template v-slot:item.zone_id="{ item }">
                           <v-chip class="ma-2" color="primary" small v-for="(i, index) in item.user.route.multiplezone" :key="index">{{i.parentzone.zone_no}}</v-chip>
                         </template> 
                         <template v-slot:item.driver_id="{ item }" >
                            {{item.user.route.driver.name}}
                        </template>
                        <template v-slot:item.vehicle_id="{ item }">
                             {{item.user.route.vehicle.vehicle_name}}
                        </template>
                        <template v-slot:item.renew_status="{ item }">
                            <v-chip class="ma-2" color="primary"  outlined small v-if="item.renew_status=='current'">{{item.renew_status}}</v-chip>
                            <v-chip class="ma-2" color="red"  outlined small v-else>{{item.renew_status}}</v-chip>
                        </template> 
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-btn x-small color="primary"  @click="routeCustomerReport(item)" v-on="on" dark>Route Customer Report</v-btn>
                                </template>
                                <span>Route Customer Detail Report</span>
                            </v-tooltip>
                        </template>
                        <template v-slot:no-data>
                        <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                        <v-btn color="primary" @click="initialize">Reset</v-btn>
                        </template>
                    </v-data-table>
                    <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getRouteList"
                            color="red darken-3"
                    ></v-pagination>
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
        menu2:false,
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
        dialog1: false,
        dialog2: false,
        dataList: [],
        zoneType_id:[],
        headers: [
        {text: "ID", value: "id"},
        { text: "User Name ", value: "email" },
        { text: "Assign Bottle ", value: "assign_bottle" },
        { text: "Return Bottle ", value: "return_bottle" },
        { text: "Zone ", value: "zone_id" },
        { text: "Vehicle", value: "vehicle_id" },
        { text: "Driver", value: "driver_id" },
        { text: "Start Date ", value: "start_date" },
        { text: "Start Day ", value: "start_day" },
        { text: "Status ", value: "renew_status" },
        { text: "Action", value: "action" }
        ],
      

        startDay:
        [
            {name:'Monday', value:'monday'},
            {name:'Tuesday', value:'tuesday'},
            {name:'Wednesday', value:'wednesday'},
            {name:'Thursady', value:'thursday'},
            {name:'Friday', value:'friday'},
            {name:'Saturday', value:'saturday'},
            {name:'Sunday', value:'sunday'},
        ],

        driverData:[],
        vehicleData:[],
        
        editedIndex: -1,
        editedItem:
        {
        name:"",
        password:"",
        start_date:"",
        start_day:"",
        zoneType_id:'',
        assign_bottle:0,
        vehicle_id:'',
        driver_id:'',
        },
        defaultItem: 
        {
        name:"",
        password:"",
        start_date:"",
        start_day:"",
        zoneType_id:'',
        assign_bottle:0,
        vehicle_id:'',
        driver_id:'',
        },
        zoneData:[],
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
      return this.editedIndex === -1 ? "New Route" : "Edit Route";
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
                
                this.getRouteList();
            },

         async getRouteList() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "put",
                    url: "/app/routereport/report/"+this.$route.params.id,
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
      
        routeCustomerReport(item)
            {
                this.$router.push('/dashboard/report/routecustomerreport/'+ item.id)
            },
      
  },
  
};
</script>
