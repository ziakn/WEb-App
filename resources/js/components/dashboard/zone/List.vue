<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Zone List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Zone</v-btn>
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
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                    <v-flex xs12 sm12 md12>
                                        <v-text-field
                                        v-model="editedItem.zone_no"
                                        label="Zone No"
                                        :rules="[v => !!v || 'Zone Number is required']"
                                        required
                                        type="number"
                                        filled
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm12 md12>
                                      <v-textarea
                                        v-model="editedItem.area" 
                                        label="Areas Inculdes in this zone"
                                        :rules="[v => !!v || 'Areas is required']"
                                        filled
                                        ></v-textarea>
                                    </v-flex>
                                    </v-layout>
                                </v-container>
                                 </v-form>
                                </v-card-text>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                                <v-btn color="primary" :loading="loading" :disabled="loading" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                    </v-dialog> 
                    </v-toolbar>
                    <v-data-table :headers="headers" :items-per-page="filters.show"  :items="dataList" class="elevation-1">
                        <template v-slot:item.driver_id="{ item }" >
                            <p v-if="item.driver == null">not assign</p>
                             <p v-else> {{item.driver.name}}</p>
                             </template>
                        <template v-slot:item.vehicle_id="{ item }">
                              <p v-if="item.vehicle == null">not assign</p>
                             <p v-else> {{item.vehicle.vehicle_name}}</p>
                         
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
                    <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getZone"
                            color="red darken-3"
                    ></v-pagination>
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
        loading:false,
        
        valid: true,
        snackbar: false,
        dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
        isDelete: false,
        itemsPerPage:1,
        pageCount:2,
		edit: true,
		dialog: false,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        dialog: false,
        headers: [
        {text: "Zone Number", value: "zone_no"},
        { text: "Areas Includes", value: "area" },
        { text: "Action", value: "action" }
        ],
      
        dataList:[],
        editedIndex: -1,
        editedItem:
        {
        zone_no: "",
        area: "",
       
        },
        defaultItem: 
        {
        zone_no: "",
        area: "",
       
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
      return this.editedIndex === -1 ? "New Zone" : "Edit Zone";
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
                this.filters.page=1;
                this.getZone();
            },

         async getZone() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/zone",
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

        async save() 
            {
                if (this.$refs.form.validate())
                {
                if (this.editedIndex > -1)
                {
                try
                {
                   this.loading=true 
                   let { data } = await axios({
                   method: "put",
                   url: "/app/zone/" + this.dataList[this.editedIndex].id,
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
                        this.snacks("Failed", "red");
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
                    url: "/app/zone",
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
						this.snacks("Failed", "red");
						this.loading = false;
					}
                } 
                catch (e) 
                {
                }
                }
                }
            },

    async remove() 
        {
            try 
            {
    				let { data } = await axios({
					method: "delete",
					url: "/app/zone/" + this.dataList[this.dataIndex].id
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
		}
  }
};
</script>
