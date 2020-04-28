<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Customer Zone List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="800px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">Add Customer Zone </v-btn>
                                </template>
                                <v-card>
                                <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                <v-chip v-if="custodyBottle" color="primary" small> CB :{{ custodyBottle.custody_bottle }}</v-chip>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                <v-chip v-if="custodyBottle" color="primary" small> CD :{{ custodyBottle.custody_despenser }}</v-chip>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                <v-chip v-if="custodyBottle" color="green" small> CB :{{ totalcustodyBottle }}</v-chip>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                <v-chip v-if="custodyBottle" color="green" small>CD :{{ totalcustodyDespenser }}</v-chip>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                <v-chip v-if="custodyBottle" color="red" small> CB :{{ custodyBottle.custody_bottle - totalcustodyBottle}}</v-chip>
                                <v-divider class="mx-2" inset vertical></v-divider>
                                 <v-chip v-if="custodyBottle" color="red" small>CD :{{ custodyBottle.custody_despenser - totalcustodyDespenser}}</v-chip>
                                </v-card-title>
                                <v-card-text>
                                    <v-form
                                        ref="form"
                                        v-model="valid"
                                        lazy-validation
                                    >
                                <v-container>
                                    <v-row>
                                     <v-col cols="12" sm="6" md="6" lg="6">
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
                                            item-text="email"
                                            item-value="id"
                                            @change="checkCustodyBottle($event)"
                                            filled
                                            label="Select Customer By Email"
                                            v-if="edit==true"
                                            ></v-select>
                                    </v-col>
                                   <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field 
                                        label="Branch Name"  
                                        v-model="editedItem.branch_name"
                                        filled
                                        disabled
                                        ></v-text-field>
                                    </v-col>
                                       <!-- :rules="[ v => v <= this.custodyBottle.custody_bottle || 'The value must be less than or equal to remainig custody bottle']"  -->
                                     <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field label="Custody Bottle For This Branch" 
                                        v-model="editedItem.custody_bottle"
                                     
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                       <!-- :rules="[ v => v <= this.custodyBottle.custody_despenser  || 'The value must be less than or equal to remainig custody Despenser']"  -->
                                     <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field label="Custody Despenser For This Branch" 
                                        v-model="editedItem.custody_despenser"
                                     
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field label="Phone" 
                                        v-model="editedItem.phone"
                                        :rules="[v => !!v.length || 'Phone is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field 
                                        label="Alternative Phone" 
                                        v-model="editedItem.alt_phone"
                                        :rules="[v => !!v.length || 'Alternative Phone is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                     <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field
                                         label="Office/Building Number"  
                                        v-model="editedItem.office_bulding_number"
                                        :rules="[v => !!v.length || 'Office/Building Number is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                     <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field 
                                        label="Floor Number"  
                                        v-model="editedItem.floor_no"
                                        :rules="[v => !!v.length || 'Floor Number is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                      <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field 
                                        label="Street Number"  
                                        v-model="editedItem.street_no"
                                        :rules="[v => !!v.length || 'Street Number is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                     <v-col cols="12" sm="6" md="6" lg="6">
                                        <v-text-field label="Office Or Flate Unit Number"  
                                        v-model="editedItem.office_flate_unit_no"
                                        :rules="[v => !!v.length || 'Office Or Flate Unit Number is required']"
                                        filled
                                        type="number"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                         <v-select
                                            v-model="editedItem.zone_type_id"
                                            :items="dataZone"
                                            item-text="zone_no"
                                            item-value="id"
                                            label="Zone Number"
                                            filled
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
                                    <v-flex xs12 sm12 md12 lg12>
                                    <gmap-autocomplete
                                        @place_changed="setPlace"
                                        :select-first-on-enter="true"
                                        class="inputSearch"
                                        placeholder="Search Place for Map"
                                        :options="autocompleteOptions"
                                        >
                                    </gmap-autocomplete>
                                    </v-flex>
                                    <v-flex xs12 sm12 md12>
                                        <GmapMap
                                        :center="position"
                                        :zoom="zoom"
                                        map-type-id="terrain"
                                        style="width: auto; height: 300px"
                                        @click="newmark"
                                        >
                                        <GmapMarker
                                            :position="position"
                                            :clickable="true"
                                            :draggable="true"
                                            @dragend="mapitem"
                                            />
                                        </GmapMap>
                                    </v-flex>
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
                    <v-data-table :headers="headers" :items-per-page="filters.show" :items="dataList" class="elevation-1">
                        <template v-slot:item.customer_name="{ item }">
                             {{item.user.name}}
                          </template>
                          <template v-slot:item.customer_email="{ item }">
                             {{item.user.email}}
                          </template>
                          <template v-slot:item.zone_type_id="{ item }">
                              {{item.zone.zone_no}}
                          </template>
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                 <v-btn x-small @click="branchItem(item)"  v-on="on" rounded  color="primary" dark>Branch</v-btn>
                              </template>
                                <span>Branch </span>
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
                            @input="getCustomerZoneBranch"
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
         zoom:13,
		 center: {
            lat: 25.2854,
            lng: 51.5310
          },
          markers: [ {
            position: {
              lat: 25.2854,
              lng: 51.5310
            }
          }],
          autocompleteOptions:
            {
                componentRestrictions: { country: 'qa' },
            },
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
        dataSumCustodyBottle:[],
        dataSumCustodyDespenser:[],
        dataZone:[],
        headers: [
        {text: "ID", value: "id"},
        { text: "Name", value: "customer_name"},
        { text: "Customer Email", value: "customer_email" },
        { text: "Zone Type", value: "zone_type_id" },
        { text: "Custody Bottle(branchwise)", value: "custody_bottle" },
        { text: "Custody Despenser(branchwise)", value: "custody_despenser" },
        { text: "Action", value: "action" }
        ],
       
        editedIndex: -1,
        editedItem:
        {
            customer_id:'',
            zone_type_id:'',
            phone:"",
            alt_phone:"",
            branch_name:"Main Branch",
            office_bulding_number: "",
            office_flate_unit_no:"",
            street_no:"",
            floor_no: "",
            custody_bottle:0,
            custody_despenser:0,
            lat:25.2854,
            lng:51.5310,
          
        },
        custodyBottle:{},
        totalcustodyBottle:null,
        totalcustodyDespenser:null,
       
        defaultItem: 
        {
            customer_id:'',
            zone_type_id:'',
            phone:"",
            alt_phone:"",
            branch_name:"Main Branch",
            office_bulding_number: "",
            office_flate_unit_no:"",
            street_no:"",
            floor_no: "",
            custody_bottle:0,
            custody_despenser:0,
            lat:25.2854,
            lng:51.5310,
          
        },
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
      return this.editedIndex === -1 ? "Add Zone " : "Edit Zone ";
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
       
        mapitem(i)
		{
			this.center.lat=i.latLng.lat();
			this.center.lng=i.latLng.lng();
			this.editedItem.lat=i.latLng.lat();
			this.editedItem.lng=i.latLng.lng();
		},
		newmark(i)
		{
			this.editedItem.lat=i.latLng.lat();
			this.editedItem.lng=i.latLng.lng();
		},
        setPlace(place) 
        {
			this.center.lat=place.geometry.location.lat();
			this.center.lng=place.geometry.location.lng();
			this.editedItem.lat=place.geometry.location.lat();
			this.editedItem.lng=place.geometry.location.lng();
			this.zoom=16
        },
         checkCustodyBottle(customer_id)
        {
            
            for (let p of this.dataCustomer)
            {
                if (customer_id == p.id)
                {
                    return this.custodyBottle = p.custodybottle
                }
                
            }
        },
        async initialize() 
            {
                this.filters.page=1
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getcustomerzonebranchzone/customerzonebranch"
                    });
                    this.dataZone = data;
                }
                catch (e) 
                {

                }
                
                this.getCustomerZoneBranch();
                this.getCustomer();
                this.getSumCustodyBottle();
                this.getSumDespenserBottle();
               
            },
        async getCustomer() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getcustomerzonebranch/customerzonebranch"
                    });
                    this.dataCustomer = data;
                }
                catch (e) 
                {

                }
            },
           async getSumCustodyBottle() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getsumcustodybottle/customerzonebranch"
                    });
                    this.dataSumCustodyBottle = data;
                }
                catch (e) 
                {

                }
            },

            async getSumDespenserBottle() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getsumcustodydespenser/customerzonebranch"
                    });
                    this.dataSumCustodyDespenser = data;
                }
                catch (e) 
                {

                }
            },

        async getCustomerZoneBranch() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/customerzonebranch",
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

        branchItem(item)
                {
                    console.log(item)
                     this.$router.push('/dashboard/zone/customerzonebranchlist/'+item.customer_id);
                },
        editItem(item) 
            {       
                    this.edit = false;
                    this.editedIndex = this.dataList.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.editedItem.email = this.editedItem.user.email
                    this.custodyBottle = this.editedItem.user.custodybottle
                    for(let p of this.dataSumCustodyBottle)
                    {
                       
                        if( p.customer_id == this.editedItem.customer_id)
                        {
                            this.totalcustodyBottle = p.totalCustody
                        }
                    }
                    for(let p of this.dataSumCustodyDespenser)
                    {
                         if( p.customer_id == this.editedItem.customer_id)
                        {
                             this.totalcustodyDespenser = p.totalDespenser
                        }

                    }
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
                    this.custodyBottle={}
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
                   let { data } = await axios({
                   method: "post",
                   url: "/app/updatecustomerzonebranch/customerzonebranch" ,
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
                        this.snacks("Fill all the field", "red");
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
                    let { data } = await axios({
                    method: "post",
                    url: "/app/customerzonebranch",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        // this.dataList.unshift(data.data);
                        this.loading=false
                        this.getCustomer();
                         this.getCustomerZoneBranch();
                        this.close();
                     }
                 else
                    {
						this.snacks("Fill all the field", "red");
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
					url: "/app/customerzonebranch/" + this.dataList[this.dataIndex].id
				    });
                    if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataList.splice(this.dataIndex, 1);
                        this.getCustomer();
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
