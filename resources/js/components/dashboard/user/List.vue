<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-toolbar flat color="white">
            <v-toolbar-title>User List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
                  <template v-slot:activator="{ on }">
                     <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New User</v-btn>
                  </template>
             
             
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 sm12 md12>
                        <v-text-field
                          v-model="editedItem.name"
                          label="Full Name"
                          required
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        v-model="editedItem.email" 
                        label="Email / User Name"
                        filled
                        ></v-text-field>
                      </v-flex>

                      <v-flex xs12 sm12s md12 v-if="edit">
                        <v-text-field
                          v-model="editedItem.password"
                          :rules="passwordRules"
                          label="Password"
                          type="password"
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12 v-if="edit">
                        <v-select
                          v-model="editedItem.userType"
                          :items="userTypeList"
                          item-text="text"
                          item-value="value"
                          :rules="[v => !!v || 'User type is required']"
                          label="User Type"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                    </v-layout>
                  </v-container>
              </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="primary" 
                  :loading="loading"
                  :disabled="loading"
                  text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataUser" class="elevation-1">
             <template v-slot:item.userType="{ item }">
                        <p v-if="item.userType == 2">Admin</p> 
                        <p v-if="item.userType == 3">Machine</p>
              </template>
              <template v-slot:item.action="{ item }">
                <v-tooltip bottom  >
                      <template v-slot:activator="{ on }">
                      <v-icon small @click="editItem(item)" v-on="on">edit</v-icon>
                      </template>
                      <span>Edit </span>
                </v-tooltip>
                <v-tooltip bottom >
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
   
		loading:false,
    snackbar: false,
   	dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
		edit: true,
		dialog: false,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    dialog: false,
    dataUser: [],
    headers: [
      { text: "ID", align: "left", value: "id" },
      {text: "Name", value: "name"},
      { text: "Email", value: "email" },
      { text: "Type", value: "userType" },
      { text: "Action", value: "action" }
    ],
    passwordRules: [
      v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
      email: "",
      password:"",
      userType: "",
      contact:"",
    },
     userTypeList:[
         { text: "Admin", value: 2 },
        { text: "Machine", value: 3 },
      ],
    defaultItem: {
      name: "",
      email: "",
      password:"",
      userType: "",
      contact:"",
    }
  }),
  props: {
    source: String
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New User" : "Edit User";
    }
  },
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/user"
        });
        this.dataUser = data;
      } catch (e) {}

    },
    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataUser.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
    	this.dataIndex = this.dataUser.indexOf(item);
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
    async save() 
    {
      if (this.editedIndex > -1)
         {
             try
              {
                   this.loading=true
                   
                  let { data } = await axios({
                  method: "put",
                  url: "/app/user/" + this.dataUser[this.editedIndex].id,
                  data: this.editedItem
              });
              if(data.status)
              {
                  this.snacks('Successfully Done','green')
                  Object.assign(this.dataUser[this.editedIndex], this.editedItem);
                   this.loading=false
                  this.close();
             }
          else
            {
                this.snacks("Failed", "red");
                this.loading = false;
            }
          
            } catch (e) 
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
            url: "/app/user",
            data: this.editedItem
          });
            if (data.status) 
            {
            this.snacks('Successfully Done','green')
            this.dataUser.unshift(data.data);
            this.loading=false
            this.close();
            }
          else
          {
						this.snacks("Failed", "red");
						this.loading = false;
					}
        } catch (e) {
        }
      }
    },
    async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/user/" + this.dataUser[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataUser.splice(this.dataIndex, 1);
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