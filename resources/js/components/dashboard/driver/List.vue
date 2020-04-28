<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Driver List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="800px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Driver</v-btn>
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
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field label="Name"  
                                            v-model="editedItem.name"
                                            :rules="[v => !!v.length || 'Name is required']"
                                            required
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field label="Phone" 
                                            v-model="editedItem.phone"
                                            :rules="[v => !!v.length || 'Phone is required']"
                                            filled
                                            type="number"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field label="Email"  
                                            v-model="editedItem.email"
                                            :rules="emailRules" 
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12" v-if="edit">
                                            <v-text-field label="Password"  
                                            v-model="editedItem.password"
                                            :rules="passwordRules" 
                                            type="password"
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field
                                            label="Address "  
                                            v-model="editedItem.address"
                                            :rules="[v => !!v.length || 'Address is required']"
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field 
                                            label="City"  
                                            v-model="editedItem.city"
                                            :rules="[v => !!v.length || 'city is required']"
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field 
                                            label="State"  
                                            v-model="editedItem.state"
                                            :rules="[v => !!v.length || 'State is required']"
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field label="License Number"  
                                            v-model="editedItem.driver_license_no"
                                            :rules="[v => !!v.length || 'License Number is required']"
                                            filled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-menu
												v-model="menu1"
												:close-on-content-click="false"
												:nudge-right="40"
												transition="scale-transition"
												offset-y
												min-width="290px"
												>
												<template v-slot:activator="{ on }">
												<v-text-field
												v-model="editedItem.driver_license_expiry_date"
												label="Driver Expiry"
												prepend-inner-icon="event"
												:rules="[v => !!v || 'Driver Expiry is required']"
												readonly
												v-on="on"
												filled
												></v-text-field>
												</template>
												<v-date-picker v-model="editedItem.driver_license_expiry_date" @input="menu1 = false"></v-date-picker>
											</v-menu>
                                        </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                            <v-select
                                            v-model="editedItem.status"
                                            :items="status"
                                            item-text="text"
                                            item-value="value"
                                            label="Status"
                                            required
                                            filled
                                            ></v-select>
                                    </v-col>
                                     <v-col cols="12" sm="12" md="12" lg="12">
                                           <v-row class="justify-center">
                                            <v-card flat max-width="250" >
                                                <v-img
                                                :src="images[0]"
                                                aspect-ratio="1"
                                                class="grey lighten-2"
                                                >
                                                </v-img>
                                                <v-card-actions>
                                                <v-btn :loading="loading" :disabled="loading" dark color="red-grey" @click="$refs.inputUpload.click()">
                                                     License Image<v-icon right >add_a_photo</v-icon>
                                                </v-btn>
                                                <input
                                                    v-show="false"
                                                    ref="inputUpload"
                                                    accept="image/*"
                                                    type="file"
                                                     @change="licenseChange"
                                                />
                                            </v-card-actions>
                                          </v-card>
                                           </v-row>
                                    </v-col>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <gmap-autocomplete
                                            @place_changed="setPlace"
                                            :select-first-on-enter="true"
                                            class="inputSearch"
                                            placeholder="Search Place for Map"
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
                    <v-data-table :headers="headers" :items-per-page="filters.show"  :items="dataDriver" class="elevation-1">
                        <template v-slot:item.status="{ item }">
                                    <v-chip class="ma-2" color="success" v-if="item.status==1" > Active </v-chip>
                                    <v-chip class="ma-2" color="error" v-else > Disabled </v-chip>
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
                             <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-icon small @click="editPassword(item)" v-on="on">https</v-icon>
                                </template>
                                <span>Password </span>
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
                            @input="getDriver"
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
        files:[],
        licenseImage:[],
        images:[],
        menu1:false,
 dialog1: false,
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
        dataDriver: [],
        zoneData:[],
        headers: [
        {text: "Name", value: "name"},
        { text: "Phone", value: "phone" },
        { text: "Email", value: "email" },
        { text: "status", value: "status" },
        { text: "Action", value: "action" }
        ],
        emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+.\.+.+/.test(v) || "E-mail must be valid" 
        ],
         passwordRules: [
        v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
        ],
        editedIndex: -1,
        editedItem:
        {
            name: "",
            email: "",
            password:"",
            user_type_id: "",
            phone:"",
            address:"",
            city: "",
            state: "",
            driver_license_expiry_date:"",
            driver_license_no: "",
            lat:25.2854,
            lng:51.5310,
            status:"",
        },
        status:
        [
            { text: "Active", value: 1 },
            { text: "In Active", value: 0 },
        ],
        defaultItem: 
        {
            name: "",
            email: "",
            password:"",
            user_type_id: "",
            phone:"",
            address:"",
            city: "",
            state: "",
            driver_license_expiry_date:"",
            driver_license_no: "",
            lat:25.2854,
            lng:51.5310,
            status:"",
        },
        status:
        [
         { text: "Active", value: 1 },
         { text: "In Active", value: 0 },
        ],
         filters:
        {
			page: 1,
            show: 20,
        },
  }),
  
 props:
    {
    },

  computed: {
    formTitle() 
    {
      return this.editedIndex === -1 ? "New Driver" : "Edit Driver";
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
		setPlace(place) {
			this.center.lat=place.geometry.location.lat();
			this.center.lng=place.geometry.location.lng();
			this.editedItem.lat=place.geometry.location.lat();
			this.editedItem.lng=place.geometry.location.lng();
			this.zoom=16
        console.log(place)
      },
        async initialize() 
            {
                this.filters.page=1;
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/driver"
                    });
                    this.zoneData = data;
                }
                catch (e) 
                {

                }
                this.getDriver();
            },

         async getDriver() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/driver",
                    params: this.filters
                    });
                    this.dataDriver = data.data;
                    this.itemsPerPage=per_page;
                    this.pageCount=last_page;
                    this.filters.page=current_page
                } 
                catch (e) 
                {

                }
            },
        editPassword(item) 
            {
                    this.edit = false;
                    this.editedIndex = this.dataDriver.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.editedItem.password = Math.random().toString(36).slice(-10);
                    this.dialog1 = true;
            },
        editItem(item) 
            {
                    this.edit = false;
                    this.editedIndex = this.dataDriver.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.images[0]=item.license_image
                    this.dialog = true;
            },

        deleteItem(item) 
            {
    	            this.dataIndex = this.dataDriver.indexOf(item);
			        this.deleteTitle = "Are you sure you want to delete this item?";
			        this.isDelete = !this.isDelete;
            },

        close() 
            {
                    this.images =[]
                    this.license_image=[]
                      this.dialog1 = false;
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
                    this.licenseImage.forEach(file => {
					formData.append("licenseImage", file); // array in formData
                    });
                    for ( var key in this.editedItem ) {
                        formData.append(key, this.editedItem[key]);
                    }
                    let { data } = await axios({
                    method: "post",
                    url: "/app/updatedriver/driver",
                    data:formData
                    });
                 if(data.status)
                    {
                        this.snacks('Successfully Done','green')
                        Object.assign(this.dataDriver[this.editedIndex], data.data);
                        this.loading=false
                        this.close();
                     }
                else
                    {
                        this.snacks("Email or Phone Number allready used", "red");
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
                    
                    this.licenseImage.forEach(file => {
					formData.append("licenseImage", file); // array in formData
                    });
                    for ( var key in this.editedItem ) {
                        formData.append(key, this.editedItem[key]);
                    }
                    this.loading=true
                    let { data } = await axios({
                    method: "post",
                    url: "/app/driver",
                    data:formData
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataDriver.unshift(data.data);
                        this.loading=false
                        this.licenseImage=[]
                        this.close();
                     }
                 else
                    {
						this.snacks("Email or Phone Number allready used", "red");
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
                        url: "/app/updatedriverpassword/driver",
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
					url: "/app/driver/" + this.dataDriver[this.dataIndex].id
				    });
                    if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataDriver.splice(this.dataIndex, 1);
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

         _getURLObj(){
            return window.URL || window.webkitURL;
        },
        
        
        licenseChange(e)
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
           
                if (files[0].type.indexOf('image') !== -1) {
                // We need to represent the image as a file
                var blob = files[0];
                var URLObj = this._getURLObj();
                this.images.push(URLObj.createObjectURL(blob))
                this.licenseImage.push(files[0])
              
                }
           
            
        },
    }
};
</script>
<style >
.inputSearch{
	padding: 16px;
	border-bottom: 1px solid grey;
  float: left;
  width: 100%;
  background: #f1f1f1;
}
</style>