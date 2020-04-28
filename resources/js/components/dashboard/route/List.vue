<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Route List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="600px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Route </v-btn>
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
                                    <v-row>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                        <v-text-field label="User Name"  
                                        v-model="editedItem.name"
                                        :rules="[v => !!v.length || 'User Name is required']"
                                        required
                                        filled
                                        :disabled="edit?false:true"
                                        ></v-text-field>
                                    </v-col>
                                   <v-col cols="12" sm="12" md="12"  v-if="edit">
                                        <v-text-field label="Password"  
                                        v-model="editedItem.password"
                                        :rules="passwordRules" 
                                        type="password"
                                        filled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    
                                     <v-col cols="12" sm="12" md="12" >
                                        <v-select
                                            v-model="zoneType_id"
                                            :items="zoneData"
                                            item-text="zone_no"
                                            item-value="id"
                                            label="Zone Number"
                                            filled
                                            :disabled="edit?false:true"
                                            multiple
                                            chips
                                        >
                                         <template slot="item" slot-scope="data">
                                    <template >
                                         <v-list>
                                    <v-list-item>
                                        <v-list-item-action>
                                        <v-list-item-title>{{data.item.zone_no}}</v-list-item-title>
                                        </v-list-item-action>
                                        <v-list-item-content>
                                        <v-list-item-title>Area : <small>{{data.item.area}} </small></v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                    </v-list>
                                    </template>
                                    </template>
                                        </v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" >
                                        <v-text-field label="Assign Stock Bottle"  
                                        v-model="editedItem.assign_bottle"
                                        type="number"
                                        filled
                                        ></v-text-field>
                                    </v-col>
                                     <v-col cols="12" sm="12" md="12" lg="12">
                                            <v-select
                                            v-model="editedItem.vehicle_id"
                                            :items="vehicleData"
                                            item-value="id"
                                            item-text="vehicle_name"
                                            filled
                                            label="Select Vehicle "
                                            ></v-select>
                                      </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                            <v-select
                                            v-model="editedItem.driver_id"
                                            :items="driverData"
                                            item-value="id"
                                            item-text="name"
                                            filled
                                            label="Select Driver"
                                            ></v-select>
                                      </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                        <v-menu
                                            v-model="menu3"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="290px"
                                            >
                                            <template v-slot:activator="{ on }">
                                            <v-text-field
                                            v-model="editedItem.start_date"
                                            label="Start Date"
                                            prepend-inner-icon="event"
                                            readonly
                                            filled
                                            v-on="on"
                                            ></v-text-field>
                                            </template>
                                            <v-date-picker v-model="editedItem.start_date" @input="menu3 = false"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                     <v-col cols="12" sm="12" md="12" lg="12">
                                          <v-select
                                            v-model="editedItem.start_day"
                                            :items="startDay"
                                            item-value="value"
                                            item-text="name"
                                            filled
                                            label="Select Start Day"
                                            ></v-select>
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
                    <v-data-table :headers="headers"  :items="dataList" class="elevation-1">
                         <template v-slot:item.assign_bottle="{ item }" >
                            {{item.route.assign_bottle}}
                        </template>
                         <template v-slot:item.zone_id="{ item }">
                           <v-chip class="ma-2" color="primary" small v-for="(i, index) in item.route.multiplezone" :key="index">{{i.parentzone.zone_no}}</v-chip>
                         </template> 
                         <template v-slot:item.driver_id="{ item }" >
                            {{item.route.driver.name}}
                        </template>
                        <template v-slot:item.vehicle_id="{ item }">
                             {{item.route.vehicle.vehicle_name}}
                        </template>
                        <template v-slot:item.start_date="{ item }" >
                            {{item.route.start_date}}
                             </template>
                        <template v-slot:item.start_day="{ item }">
                             {{item.route.start_day}}
                        </template>
                        <template v-slot:item.renew_status="{ item }">
                             <v-chip class="ma-2" color="primary"  outlined small >{{item.route.renew_status}}</v-chip>
                            
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="routeCustomerMap(item)" v-on="on">add_location</v-icon>
                                </template>
                                <span>Location</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="routeCustomer(item)" v-on="on">people</v-icon>
                                </template>
                                <span>Customer</span>
                            </v-tooltip>
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
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="editPassword(item)" v-on="on">https</v-icon>
                                </template>
                                <span>Password </span>
                            </v-tooltip>
                            <!-- <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="routeReport(item)" v-on="on">assignment</v-icon>
                                </template>
                                <span>Route Report</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="routeCustomerReport(item)" v-on="on">assignment_ind</v-icon>
                                </template>
                                <span>Route Customer Report</span>
                            </v-tooltip> -->
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
               	<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
                    <v-dialog v-model="dialog1" max-width="500px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">Generate Password</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            <v-flex xs12 sm12s md12 >
                                <v-text-field
                                v-model="editedItem.password"
                                :rules="passwordRules"
                                label="Password"
                                type="text"
                                filled
                                ></v-text-field>
                            </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>

                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                        <v-btn color="primary" text @click="changePassword" :loading="loading" :disabled="loading">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialog2" persistent max-width="800px">
                                
                                <v-card>
                                <v-card-title>
                                <span class="headline">Map </span>
                                </v-card-title>
                                <v-card-text>
                                <v-container>
                                    <v-row>
                                    <v-flex xs12 sm12 md12>
                                        <GmapMap
                                        :center="position"
                                        :zoom="zoom"
                                        map-type-id="terrain"
                                        style="width: auto; height: 300px"
                                 
                                        >
                                        <gmap-info-window :options="infoOptions" :position="infoPosition" :opened="infoOpened" @closeclick="infoOpened=false">
                                        {{infoContent}}
                                    </gmap-info-window>
                                        <GmapMarker
                                            v-for="(item, index) in markers"
                                            :key="index"
                                            :position="getPosition(item)"
                                            :clickable="true"
                                            @click="toggleInfo(item, index)"
                                            />
                                        </GmapMap>
                                    </v-flex>
                                    </v-row>
                                </v-container>
                                </v-card-text>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" text @click="dialog2 = false">Close</v-btn>
                                </v-card-actions>
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
import DeleteModal from "./../common/DeleteModal";
export default {
  components: {
		DeleteModal
	},
  data: () => ({
        zoom:14,
         center: 
         {
            lat: 25.2854,
            lng: 51.5310
         },
        markers: [],
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
        { text: "Zone ", value: "zone_id" },
        { text: "Vehicle", value: "vehicle_id" },
        { text: "Driver", value: "driver_id" },
        { text: "Start Date ", value: "start_date" },
        { text: "Start Day ", value: "start_day" },
        { text: "Status ", value: "renew_status" },
        { text: "Action", value: "action" }
        ],
        passwordRules: [
        v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
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
        lat:25.2854,
        lng:51.5310,
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
        lat:25.2854,
        lng:51.5310,
        vehicle_id:'',
        driver_id:'',
        },
        zoneData:[],
        filters:
        {
			page: 1,
            show: 20,
        },
        infoPosition: null,
        infoContent: null,
        infoOpened: false,
        infoCurrentKey: null,
        infoOptions: {
        pixelOffset: {
            width: 0,
            height: -35
        }
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
    position()
		{
			var position =
			{
				lat: this.editedItem.lat,
				lng: this.editedItem.lng
			}
			return position;
        },
   
  },
  
  watch: {},

  created() 
    {
        this.initialize();
    },

  methods: 
    {
         getPosition(marker) 
                {
                            var mark =
                            {
                                lat: marker.lat,
                                lng: marker.lng
                            }
                    return mark;
                },

        toggleInfo(marker, key)
                {
                    this.infoPosition = this.getPosition(marker);
                    this.infoContent = marker.user.name;
                    if (this.infoCurrentKey == key) 
                    {
                        this.infoOpened = !this.infoOpened;
                    } else 
                    {
                        this.infoOpened = true;
                        this.infoCurrentKey = key;
                    }
                },

        async initialize() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/routezone"
                    });
                    this.zoneData = data;
                }
                catch (e) 
                {

                }
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/driver"
                    });
                    this.driverData = data;
                }
                catch (e) 
                {

                }
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/vehicle"
                    });
                    this.vehicleData = data;
                }
                catch (e) 
                {

                }
           
                this.getRouteList();
            },

         async getRouteList() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/route",
                    params: this.filters
                    });
                    this.dataList = data.data;
                    this.itemsPerPage=data.per_page;
                    this.pageCount=data.last_page;
                    this.filters.page=data.current_page
                } 
                catch (e) 
                {

                }
            },
        routeCustomer(item)
            {
                this.$router.push('/dashboard/route/customerlist/'+ item.id)
            },
        routeReport(item)
            {
                console.log(item)
                // this.$router.push('/dashboard/route/routereport/'+ item.id)
            },
        routeCustomerReport(item)
            {
                 console.log(item)
                // this.$router.push('/dashboard/route/routecustomerreport/'+ item.id)
            },
        async routeCustomerMap(item)
            {
                console.log(item)
                try 
                {
                    let { data } = await axios({
                    method: "post",
                    url: "/app/getroutecustomerlocation/route",
                    data: item
                 });
                
                   this.markers=data
                    this.dialog2=true
                } 
                catch (e) 
                {
                    this.snacks("No data", "red");
                }
                
            },
        editPassword(item) 
            {
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.editedItem.password = Math.random().toString(36).slice(-10);
                    this.dialog1 = true;
            },
        editItem(item) 
            {
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    console.log(this.editedItem)
                    for(let p of this.editedItem.route.multiplezone)
                                {
                                    this.zoneType_id.push( p.zone_type_id)
                                }
                    this.editedItem.assign_bottle=  this.editedItem.route.assign_bottle
                    this.editedItem.start_date=  this.editedItem.route.start_date
                    this.editedItem.start_day= this.editedItem.route.start_day
                    this.editedItem.driver_id=  this.editedItem.route.driver_id
                    this.editedItem.vehicle_id= this.editedItem.route.vehicle_id

                             
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
                   this.zoneType_id=[]
                    this.dialog = false;
                    this.dialog1 = false;
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
                try
                {
                   this.loading=true 
                   this.editedItem.zoneType_id= this.zoneType_id
                   let { data } = await axios({
                   method: "put",
                   url: "/app/route/" + this.dataList[this.editedIndex].id,
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
                        this.snacks("Unsuccefully", "red");
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
                    this.editedItem.zoneType_id= this.zoneType_id
                    this.loading=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/route",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataList.unshift(data.data);
                        this.loading=false
                       
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
                }
                
                // }
            },

            async changePassword()
            {
                try {
                        this.loading=true
                        let { data } = await axios({
                        method: "post",
                        url: "/app/updatepassword/route",
                        data: this.editedItem
                    });
                        this.snacks('Successfully Done','green')
                        this.close();
                        this.loading = false;
                    } catch (e)
                    {
                        this.loading = false;
                    }
            },

    async remove() 
        {
            try 
            {
    				let { data } = await axios({
					method: "delete",
					url: "/app/route/" + this.dataList[this.dataIndex].id
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
        },

      
        
  },
  
};
</script>
