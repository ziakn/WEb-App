<template>
<v-content>
		<v-container fluid>
		<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
                     <!-- <v-col cols="5">
                            <v-select
                                v-model="filters.admin_id"
                                :items="dataMachine"
                                item-text="name"
                                item-value="id"
                                label="Belongs To"
                                required
								clearable
                                filled
								@change="getTask"
                            ></v-select>                            
                        </v-col> -->
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Machine Task List</v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                             <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card flat>
                        <v-card-text>
                            <v-data-table :headers="headers" :items="dataList" :items-per-page="filters.show"   hide-default-footer >
                                <template v-slot:item.machine_id="{ item }">
                                    <p>{{item.machine.name}}</p>
                                </template>
                                 <template v-slot:item.action="{ item }">
                                      <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                              <v-icon small @click="detailItem(item)" v-on="on">note</v-icon>
                                            </template>
                                            <span>Detail </span>
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
                                    <v-skeleton-loader v-show="loading" type="table-tbody"></v-skeleton-loader>
                                    <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
                            </template>  
                            </v-data-table>
                            <div class="text-center">
                            <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getTask"
                            color="primary"
                            ></v-pagination>
                            </div>
                         </v-card-text>
                    </v-card>
        <DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
        	<v-dialog v-model="dialog" max-width="500px" persistent>
							<v-card>
								<v-card-title>
									<span class="headline">{{ formTitle }}</span>
								</v-card-title>

								<v-card-text>
									<v-container grid-list-md>
										<v-layout wrap>
                                             <v-flex xs12 sm12 md12 v-if="edit==false">
												<v-select
													v-model="editedItem.machine_id"
													:items="dataMachine"
													item-text="name"
													item-value="id"
													label="Machine"
                                                    disabled
													required
													filled
												></v-select>
											</v-flex>
                                              <v-flex xs12 sm12 md12 v-if="edit==true">
												<v-select
													v-model="editedItem.machine_id"
													:items="dataMachine"
													item-text="name"
													item-value="id"
													label="Machine"
													required
													filled
												></v-select>
											</v-flex>
											<v-flex xs12 sm12 md12>
												<v-text-field
													v-model="editedItem.name"
													label="Name"
													filled
													required
												></v-text-field>
											</v-flex>
                                            	<v-flex xs12 sm12 md12>
												<v-text-field
													v-model="editedItem.make"
													label="Make"
													filled
													required
												></v-text-field>
											</v-flex>
                                            	<v-flex xs12 sm12 md12>
												<v-text-field
													v-model="editedItem.model"
													label="Model"
													filled
													required
												></v-text-field>
											</v-flex>
                                            <v-flex xs12 sm12 md12>
												<v-textarea
													v-model="editedItem.description"
													label="Description"
													filled
													required
												></v-textarea>
											</v-flex>
										</v-layout>
									</v-container>
								</v-card-text>

								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn color="red darken-1" text @click="close">Cancel</v-btn>
									<v-btn
										color="primary"
										:loading="loading"
										:disabled="loading"
										text
										@click="save"
									>Save</v-btn>
								</v-card-actions>
							</v-card>
						</v-dialog>
	</v-container>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
               <v-btn bottom color="primary" dark fab fixed right @click="dialog = !dialog">
			    <v-icon v-on="on">mdi-plus</v-icon>
		        </v-btn>
            </template>
            <span>Add New Task</span>
        </v-tooltip>
</v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";

export default {
	components: {
        DeleteModal,
    },
    props: {
		source: String
	},
	data: () => ({
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
        isDelete: false,
        absolute: true,
        edit: true,
        dialog: false,
        dialog: false,
        loading: false,
        itemsPerPage:1,
        pageCount:2,
		search: "",
		headers: [
			{ text: "ID", value: "id" },
			{ text: "Title", value: "name" },
			{ text: "Make", value: "make" },
            { text: "Model", value: "model" },
			{ text: "Description", value: "description" },
            { text: "Name By Super User", value: "machine_id" },
			{ text: "Action", align: "center", value: "action", sortable: false }
		],
		editedIndex: -1,
       editedIndex: -1,
        editedItem:
            {
                machine_id:"",
                name:"",
                make:"",
                model:"",
                description:"",
                
            },
        defaultItem: 
            {
                machine_id:"",
                name:"",
                make:"",
                model:"",
                description:"",
            },
        dataList:[],
        dataMachine:[],
         filters:
        {
            start:new Date().toISOString().substr(0, 10),
			end:"",
			page: 1,
			show: 20,
        },
	}),
computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New Item" : "Edit Item";
		}
	},
	created() {
		this.initialize();
	},
	methods: {
            
    
        async initialize() {
            
            this.filters.page=1
           

            this.getTask();
            this.getMachine();

            },
        async getMachine()
        {
              try {
				let { data } = await axios({
					method: "get",
                    url: "/app/getunsignmachinetask",
				});
				this.dataMachine = data;          
			} catch (e) {   
                this.loading=false;   
            }
        },
        async getTask()
        {
            this.loading=true;
            try {
				let { data } = await axios({
					method: "get",
                    url: "/app/task",
                    params: this.filters
				});
                this.dataList = data.data;
                this.itemsPerPage=per_page;
                this.pageCount=last_page;
                this.filters.page=current_page
				this.loading=false;                
			} catch (e) {
				this.loading=false;                

                
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
			const index = this.dataList.indexOf(item);
			confirm("Are you sure you want to delete this item?") &&
			this.dataList.splice(index, 1);
		},
		close() {
			this.dialog = false;
			this.loading = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
        detailItem(item)
        {
            this.$router.push('/dashboard/task/detail/'+item.machine_id);

        },
		deleteItem(item) {
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
		},
		close() {
			this.dialog = false;
			this.loading = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
        },
            async save() 
            {
                this.loading = true;
                if (this.editedIndex > -1) {
                    try {
                        let { data } = await axios({
                            method: "put",
                            url: "/app/task/" + this.editedItem.id,
                            data: this.editedItem
                        });
                        if (data.status) {
                            
                            Object.assign(this.dataList[this.editedIndex], this.editedItem);
                            this.snacks("Successfully Added", "green");
                            this.close();
                        } else {
                            this.snacks("Failed", "red");
                            this.loading = false;
                        }
                    } catch (e) {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                } else {
                    try { 
                        let { data } = await axios({
                            method: "post",
                            url: "/app/task",
                            data: this.editedItem
                        });
                        if (data.status) {
                            this.dataList.unshift(data.data);
                            this.snacks("Successfully Added", "green");
                            this.getMachine();
                            this.close();
                        } else {
                            this.snacks("Failed", "red");
                            this.loading = false;
                        }
                    } catch (e) {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                }
        },
        
		async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/task/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
				this.snacks('Successfully Done','green')
                this.dataList.splice(this.dataIndex, 1);
                this.getMachine();
                this.close();
                }
                else{
                    this.snacks(data.data,'red')
					this.loading = false;
                }
			} catch (e) {
				this.snacks('Operation Failed','red')

            }
            
        },
        async getDetail()
            {
                
            }
	}
};
</script>