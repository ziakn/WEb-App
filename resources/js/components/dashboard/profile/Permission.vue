<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-toolbar flat color="white">
            <v-toolbar-title>User List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataUser" class="elevation-1">
             <template v-slot:item.userType="{ item }">
                        <p v-if="item.userType == 2">Admin</p> 
                        <p v-if="item.userType == 3">Machine</p>
              </template>
              <template v-slot:item.action="{ item }">
                 <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <v-btn small @click="detailItem(item)" v-on="on">Permission</v-btn>
                          </template>
                          <span>Detail </span>
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
          url: "/app/useradmin"
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
   detailItem(item)
        {
            this.$router.push('/dashboard/pageslist/'+item.id);

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