<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-toolbar flat color="white">
            <v-toolbar-title>Document List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
           
            <v-dialog v-model="dialog" max-width="500px">
                  <template v-slot:activator="{ on }">
                     <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true" :disabled="userType==3">New Document</v-btn>
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
                          v-model="editedItem.title"
                          label="Full Name"
                          required
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        v-model="editedItem.barcode" 
                        label="Barcode"
                        filled
                        ></v-text-field>
                      </v-flex>

                      <v-flex xs12 sm12s md12>
                        <v-textarea
                          v-model="editedItem.description"
                          label="Descriprion"
                          filled
                        ></v-textarea>
                      </v-flex>
                      <v-flex xs12 sm12 md12 >
                       	  <v-file-input
                                            v-model="document"
                                            color="blue accent-4"
                                            counter
                                            label="pdf only"
                                            placeholder="Single Files"
                                            prepend-icon="mdi-paperclip"
                                            filled
                                            :show-size="1000"
                                        >
                                    <template v-slot:selection="{ index, text }">
                                        <v-chip
                                            v-if="index < 2"
                                            color="blue accent-4"
                                            dark
                                            label
                                            small
                                        >
                                            {{ text }}
                                        </v-chip>
                                        <span
                                            v-else-if="index === 2"
                                            class="overline grey--text text--darken-3 mx-2"
                                        >
                                        +{{ files.length - 2 }} File(s)
                                        </span>
                                    </template>
                                    </v-file-input>
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
           <v-text-field
                            dense
							v-model="search"
							append-icon="search"
							label="Search"
							hide-details
							outlined
						></v-text-field>
          <v-data-table :headers="headers" :items="dataList" :search="search" class="elevation-1">
            
              <template v-slot:item.action="{ item }">
                 <v-btn x-small color="primary" :href="item.file_src" download v-if="item.file_src">download link</v-btn>
                <v-tooltip bottom  >
                      <template v-slot:activator="{ on }">
                      <v-icon small @click="editItem(item)" v-on="on" :disabled="userType==3" >edit</v-icon>
                      </template>
                      <span>Edit </span>
                </v-tooltip>
                <v-tooltip bottom >
                      <template v-slot:activator="{ on }">
                      <v-icon small @click="deleteItem(item)" v-on="on" :disabled="userType==3">delete</v-icon>
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
                                @input="getDoc"
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
   userType:null,
		loading:false,
    snackbar: false,
       dataIndex: null,
       search: "",
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
    dataList: [],
    headers: [
      { text: "ID", align: "left", value: "id" },
      {text: "Title", value: "title"},
      { text: "Barcode", value: "barcode" },
      { text: "Description", value: "description" },
      { text: "Action", value: "action" }
    ],
    editedIndex: -1,
    document:[],
    editedItem: {
      title: "",
      barcode: "",
      description:"",
    },
    defaultItem: {
      title: "",
      barcode: "",
      description:"",
    },
    filters:
        {
            show:20,
            page:1,

        },
  }),
  props: {
    source: String
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Document" : " Edit Document";
    }
  },
  watch: {},
  created() {
    this.userType = this.$store.state.authUser.userType
    this.initialize();
  },
  methods: {
    async initialize() {
    

      this.getDoc();

    },
    async getDoc()
      {
  try {
        let { data } = await axios({
          method: "get",
          url: "/app/document",
         params: this.filters
				});
                this.dataList = data.data;
                this.itemsPerPage=per_page;
                this.pageCount=last_page;
				this.filters.page=current_page
				this.loading=false;
      } catch (e) {}
      },
    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataList.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
    	this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
    },
    close() {
      this.dialog = false;
      this.loading=false;
      this.document=[];
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
                   const formData = new FormData();
                    formData.append("document", this.document);   // single file
                    for ( var key in this.editedItem ) {
						formData.append(key, this.editedItem[key]);
                    }
                    formData.append("_method", "put");
                  let { data } = await axios({
                  method: "POST",
                  url: "/app/document/" + this.dataList[this.editedIndex].id,
                  data:formData
              });
              if(data.status)
              {
                  this.snacks('Successfully Done','green')
                  Object.assign(this.dataList[this.editedIndex], this.editedItem);
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
             const formData = new FormData();
                    formData.append("document", this.document);   // single file

                    for ( var key in this.editedItem ) {
						formData.append(key, this.editedItem[key]);
					}
            let { data } = await axios({
            method: "post",
            url: "/app/document",
            data:formData
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
        } catch (e) {
        }
      }
    },
    async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/document/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataList.splice(this.dataIndex, 1);
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