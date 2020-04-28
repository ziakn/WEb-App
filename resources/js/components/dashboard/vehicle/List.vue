<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Vehicle List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="600px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">Add Vehicle</v-btn>
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
                                            <v-select
                                            v-model="editedItem.vehicle_type_id"
                                            :items="dataVehicleType"
                                            item-value="id"
                                            item-text="type"
                                            filled
                                            label="Select Vehicle Type"
                                            ></v-select>
                                    </v-col>
                                      <v-col cols="12" sm="12" md="12" lg="12">
                                            <v-text-field
                                            v-model="editedItem.vehicle_name"
                                            filled
                                            label="Vehicle Name"
                                            ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
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
                                            v-model="editedItem.model"
                                            label="Vehicle Model"
                                            prepend-inner-icon="event"
                                            :rules="[v => !!v.length || 'Vehicle Model is required']"
                                            readonly
                                            filled
                                            v-on="on"
                                            ></v-text-field>
                                            </template>
                                            <v-date-picker  type="month" v-model="editedItem.model" @input="menu = false"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                            <v-text-field
                                            v-model="editedItem.registration_no"
                                            filled
                                            label="Vehicle Registration No"
                                            ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12" lg="12">
                                            <v-row class="justify-center">
                                             <v-card  flat max-width="250" >
                                                <v-img
                                                :src="images[0]"
                                                aspect-ratio="1"
                                                class="grey lighten-2"
                                                >
                                                </v-img>
                                                <v-card-actions>
                                                <v-btn :loading="loading" :disabled="loading" dark color="red-grey" @click="$refs.inputUpload.click()">
                                                     Vehicle Image<v-icon right >add_a_photo</v-icon>
                                                </v-btn>
                                                <input
                                                    v-show="false"
                                                    ref="inputUpload"
                                                    accept="image/*"
                                                    type="file"
                                                     @change="vehicleChange"
                                                />
                                                </v-card-actions>
                                             </v-card>
                                        </v-row>
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
                          <template v-slot:item.vehicle_type_id="{ item }">
                              {{item.vehicletype.type}}
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
        
        menu: false,
        files:[],
        registrationImage:[],
        images:[],
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
        dataVehicleType: [],
        headers: [
        {text: "ID", value: "id"},
        { text: "Vehicle Name", value: "vehicle_name" },
        { text: "Vehicle Model", value: "model" },
        { text: "Vehicle Type", value: "vehicle_type_id" },
        { text: "Vehicle Registration", value: "registration_no" },
        { text: "Action", value: "action" }
        ],
       
        editedIndex: -1,
        editedItem:
        {
            registration_no:'',
            vehicle_type_id:'',
            model:'',
            vehicle_name:'',
            
        },
       
        defaultItem: 
        {
            registration_no:'',
            vehicle_type_id:'',
            model:'',
            vehicle_name:'',
           
        },
      
        
  }),
  
  props: {
    source: String
  },

  computed: {
    formTitle() 
    {
      return this.editedIndex === -1 ? "Add Vehicle " : "Edit Vehicle ";
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
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/getvehicletype/vehicle"
                    });
                    this.dataVehicleType = data;
                }
                catch (e) 
                {

                }
                this.getVehicle();
            },
        async getVehicle() 
            {
              
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/vehicle"
                    });
                    this.dataList = data;
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
                    this.images[0] = item.registration_image
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
                    this.registrationImage=[]
                    this.images=[]
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
                try
                {
                   
                   this.loading=true 
                   const formData = new FormData();
                    this.registrationImage.forEach(file => {
					formData.append("registrationImage", file); // array in formData
                    });
                    for ( var key in this.editedItem ) {
                        formData.append(key, this.editedItem[key]);
                    }
                   let { data } = await axios({
                   method: "post",
                   url: "/app/updatevehicle/vehicle",
                   data: formData
                  });
                  console.log(data)
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
                    const formData = new FormData();
                    
                    this.registrationImage.forEach(file => {
					formData.append("registrationImage", file); // array in formData
                    });
                    for ( var key in this.editedItem ) {
                        formData.append(key, this.editedItem[key]);
                    }
                    this.loading=true
                    this.loading=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/vehicle",
                    data: formData
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataList.unshift(data.data);
                        this.loading=false
                        this.registrationImage=[]
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
                // }
            },

    async remove() 
        {
            try 
            {
    				let { data } = await axios({
					method: "delete",
					url: "/app/vehicle/" + this.dataList[this.dataIndex].id
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
        _getURLObj()
        {
            return window.URL || window.webkitURL;
        },
        vehicleChange(e)
        {
            this.files=event.target.files;
        }
  },
    watch:
    {
        files()
        {
                this.images=[];
                 var files = this.files;
           
                if (files[0].type.indexOf('image') !== -1) 
                {
                // We need to represent the image as a file
                var blob = files[0];
                var URLObj = this._getURLObj();
                this.images.push(URLObj.createObjectURL(blob))
                this.registrationImage.push(files[0])
              
                }
        },
    }
};
</script>
