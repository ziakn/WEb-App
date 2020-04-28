<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Sales People List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" persistent max-width="800px">
                                <template v-slot:activator="{ on }">
                                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Sale Person</v-btn>
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
                                            v-model="editedItem.date_of_birth"
                                            label="Date Of Birth"
                                            prepend-inner-icon="event"
                                            :rules="[v => !!v.length || 'Date Of Birth is required']"
                                            readonly
                                            filled
                                            v-on="on"
                                            ></v-text-field>
                                            </template>
                                            <v-date-picker v-model="editedItem.date_of_birth" @input="menu3 = false"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field label="Email"  
                                        v-model="editedItem.email"
                                        :rules="emailRules" 
                                        filled
                                        ></v-text-field>
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
                                   
                                    <v-col cols="12" sm="12" md="12"  v-if="edit">
                                        <v-text-field label="Password"  
                                        v-model="editedItem.password"
                                        :rules="passwordRules" 
                                        type="password"
                                        filled
                                        ></v-text-field>
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
                    <v-data-table :headers="headers" :items-per-page="filters.show"  :items="dataSalePeople" class="elevation-1">
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
                            @input="getSalesPeople"
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
                   <v-row justify="center">
                    <v-dialog
                    v-model="qrdialog"
                    max-width="290"
                    >
                    <v-card>
                        <v-card-text>
                        <v-img :src="editedItem.qrcode" ></v-img>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="close"> close</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
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
        qrdialog: false,
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
         dialog1: false,
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        dialog: false,
        dataSalePeople: [],
        zoneData:[],
        headers: [
        {text: "Name", value: "name"},
        { text: "Email", value: "email" },
        { text: "DOB", value: "date_of_birth" },
        { text: "status", value: "status" },
        { text: "Action", value: "action" }
        ],
        emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+.\.+.+/.test(v) || "E-mail must be valid" 
        ],
        usernameRules: [
        v => !!v || "Name is required",
        v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
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
        date_of_birth: "",
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
        date_of_birth: "",
        status:"",
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
      return this.editedIndex === -1 ? "New Sales Person" : "Edit Sales Person";
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
                this.getSalesPeople();
            },

         async getSalesPeople() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/salespeople",
                    params: this.filters
                    });
                    this.dataSalePeople = data.data;
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
                    this.editedIndex = this.dataSalePeople.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.editedItem.password = Math.random().toString(36).slice(-10);
                    this.dialog1 = true;
            },
        editItem(item) 
            {
                    this.edit = false;
                    this.editedIndex = this.dataSalePeople.indexOf(item);
                    this.editedItem = Object.assign({}, item);
                    this.dialog = true;
            },

        deleteItem(item) 
            {
    	            this.dataIndex = this.dataSalePeople.indexOf(item);
			        this.deleteTitle = "Are you sure you want to delete this item?";
			        this.isDelete = !this.isDelete;
            },
        close() 
            {
                  this.dialog1 = false;
                    this.dialog = false;
                     this.qrdialog = false;
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
                   let { data } = await axios({
                   method: "put",
                   url: "/app/salespeople/" + this.dataSalePeople[this.editedIndex].id,
                   data: this.editedItem
                  });
                 if(data.status)
                    {
                        this.snacks('Successfully Done','green')
                        Object.assign(this.dataSalePeople[this.editedIndex], data.data);
                        this.loading=false
                        this.close();
                     }
                else
                    {
                        this.snacks("Email or Phone Number allready used or check the form", "red");
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
                    url: "/app/salespeople",
                    data: this.editedItem
                 });
                if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataSalePeople.unshift(data.data);
                        this.loading=false
                        this.close();
                     }
                 else
                    {
						this.snacks("Email or Phone Number allready used or check the form", "red");
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
                        url: "/app/updatesalepassword/sale",
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
					url: "/app/salespeople/" + this.dataSalePeople[this.dataIndex].id
				    });
                    if (data.status) 
                    {
                        this.snacks('Successfully Done','green')
                        this.dataSalePeople.splice(this.dataIndex, 1);
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
<style >
.inputSearch{
	padding: 16px;
	border-bottom: 1px solid grey;
  float: left;
  width: 100%;
  background: #f1f1f1;
}
</style>