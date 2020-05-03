<style>

.headeroption{
	/* margin-bottom: 10px !important; */
}

.space{
	margin-bottom: 10px !important;
}

.headertitle{
	margin-bottom: 20px !important;

}

.headertitle h3{
font-weight: 200;
}

.myresp.col-lg-3{
		background-color: #fafafa;
		text-align: center;
		border:1px solid rgba(0,0,0,.12);
}

.myresp.col-lg-6{
		background-color: #fafafa;
		border:1px solid rgba(0,0,0,.12);
}

.headeroption h4{
	       color: #000000;
    	font-weight: 200;
			font-family: Roboto,sans-serif!important;
}

.headeroption h3{
	       color: #000000;
    		font-weight: 200;
		font-family: Roboto,sans-serif!important;
}

.headeroption span{
	    color: rgba(0,0,0,.6);
	font-weight: 200;
}

.doc{
		padding-bottom: 10px !important;
	border-bottom: 1px solid rgba(0,0,0,.12);
	padding-top: 0px;
	margin-bottom: 10px;
}
</style>

<template>
	<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
					<v-card outlined >
							<v-list-item three-line>
							<v-list-item-content>
							<v-row justify="center">
								<v-col sm="12" md="12" lg="12" style="text-align:center;">
									<v-list-item-title class="headline headertitle "> <h3> {{dataTaskName}} </h3></v-list-item-title>
								</v-col>
								<v-col  class="myresp col-sm-12 col-md-6 col-lg-6">
									<v-list-item-subtitle class="headeroption" style="padding-left:15px;"><h3>DESCRIPTION : <span>{{dataTaskDescription}}</span></h3></v-list-item-subtitle>
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3" >
									<v-col sm="12" md="12" lg="12" class="doc">Make</v-col>
									{{dataTaskMake}}
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3" >
									<v-col sm="12" md="12" lg="12" class="doc">Model</v-col>
									{{dataTaskModel}}
								</v-col>
								
							</v-row>
							</v-list-item-content>
							</v-list-item>
							 <v-dialog v-model="dialog" persistent max-width="800px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">New Task</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container fluid  style="overflow-x:hidden;" >
                            <v-row wrap>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Task Name"  
                                 :rules="[v => !!v.length || 'Name is required']"
                                  v-model="editedItem.task_name"
                                  filled
                                 ></v-text-field>
                            </v-col>
							  <v-col cols="12" sm="6" md="6">
									<v-select
										v-model="editedItem.target_type"
										:items="dataTarget"
										item-text="text"
                                        item-value="value"
										required
										label="Target*"
										filled
									>
									</v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Qty Produce"  
                                  v-model="editedItem.qunatity_produce"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Qty Require"
                                  v-model="editedItem.qunatity_require"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-menu
                                     ref="menu2"
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="editedItem.start_time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                    >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            v-model="editedItem.start_time"
                                            label="Start shift Time"
                                            prepend-inner-icon="access_time"
                                            :rules="[v => !!v.length || 'Start Appoinment Time is required']"
                                            readonly
                                            filled
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                     <v-time-picker
                                      v-if="menu2"
                                      v-model="time"
                                      :ampm-in-title="ampmInTitle"
                                      full-width
                                      @click:minute="$refs.menu2.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-menu
                                     ref="menu4"
                                    v-model="menu4"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="editedItem.end_time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                    >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            v-model="editedItem.end_time"
                                            label="End shift Time"
                                            :rules="[v => !!v.length || 'End Appoinment Time is required']"
                                            prepend-inner-icon="access_time"
                                            readonly
                                            filled
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                     <v-time-picker
                                      v-if="menu4"
                                      v-model="time"
                                      :ampm-in-title="ampmInTitle"
                                      full-width
                                      @click:minute="$refs.menu4.save(time)"
                                    ></v-time-picker>
                                </v-menu>
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
                                    v-model="editedItem.end_date"
                                    label="End Date"
                                    prepend-inner-icon="event"
                                    readonly
                                    v-on="on"
                                    filled
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="editedItem.end_date" @input="menu1 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                              <v-col cols="12" sm="6" md="12">
                                  <v-text-field label="Remark"  
                                   v-model="editedItem.remark"
                                   filled
                                  ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6" lg="">
									<v-select
										v-model="editedItem.status"
										:items="dataStatus"
										item-text="text"
                                        item-value="value"
										required
										label="Status"
										filled
										chips
									>
									</v-select>
                            </v-col>
                      
                            </v-row>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="dialog = false">Close</v-btn>
                        <v-btn color="primary" :loading="loading"  :disabled="loading" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>
							<v-card-text>
												 <v-data-table :headers="headers" :items="dataList" :items-per-page="filters.show"   hide-default-footer >
													
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
														<v-skeleton-loader v-show="loading" type="table-tbody"></v-skeleton-loader>
														<v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
												</template>  
												</v-data-table>
												<div class="text-center">
												<v-pagination
												v-model="filters.page"
												:length="pageCount"
												@input="getTaskDetail"
												color="primary"
												></v-pagination>
												</div>
									
							</v-card-text>
  					</v-card>
				</v-col>
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
							<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
							<v-tooltip top>
								<template v-slot:activator="{ on }">
									<v-btn bottom color="primary" dark fab fixed right @click="dialog = !dialog">
											<v-icon  v-on="on">mdi-plus</v-icon>
									</v-btn>
								</template>
								<span>Add New Status</span>
							</v-tooltip>
	</v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
export default {
	components: {
		DeleteModal
	},
	data: () => ({
				valid: false,
				absolute: true,
				menu1:false,
				menu3:false,
				menu4:false,
				menu2:false,
				ampmInTitle: true,
        		time:null,
				loading:false,
				search: "",
				dataIndex: null,
				deleteTitle: "",
				deleteBody: "",
				isDelete: false,
				edit: true,
				dialog: false,
				itemsPerPage:1,
				pageCount:2,
				editedIndex: -1,
				dataList:[],
				otherFile:[],
				admin_id:"",
				dataTask: {},
				headers: [
					{ text: "ID", value: "id" },
					{ text: "Name", value: "task_name" },
					{ text: "Target type", value: "target_type" },
					{ text: "Start Time", value: "start_time" },
					{ text: "End Time", value: "end_time" },
					{ text: "Start Date", value: "start_date" },
					{ text: "End Date", value: "end_date" },
					{ text: "Qty Produce", value: "qunatity_produce" },
					{ text: "Qty Require", value: "qunatity_require" },
					{ text: "Remark", value: "remark" }, 
					{ text: "Status", value: "status" },
					{ text: "Action", align: "center", value: "action", sortable: false }
				],
				filters:
				{
					page: 1,
					show: 20,
					machine_id:'',
				},
				editedItem:
				 {
					machine_id: "",
					task_name:"",
					target_type:"",
					start_time:"",
					end_time:"",
					start_date: "",
					end_date:"",
					qunatity_produce:"",
					qunatity_require:"",
					remark:"",
					status:"",
				 },
				defaultItem: 
				{
					machine_id: "",
					task_name:"",
					target_type:"",
					start_time:"",
					end_time:"",
					start_date: "",
					end_date:"",
					qunatity_produce:"",
					qunatity_require:"",
					remark:"",
					status:"",
				},
				dataStatus:[
					{text:'Pending', value:'pending'},
					{text:'Machine Damaged', value:'machinedamaged'},
					{text:'Employee On leave', value:'employeeonleave'},
					{text:'Machine Maintenance', value:'machinemaintenance'},
				],
				dataTarget:[
					{text:'Daily', value:'daily'},
					{text:'Weekly', value:'monthly'},
					{text:'Monthly', value:'weekly'},
				]
				
	}),

	computed: 
	{
			dataTaskName()
			{
				return	this.dataTask.name
			},
			dataTaskMake()
			{
				return	this.dataTask.make
			},
			dataTaskModel()
			{
				return	this.dataTask.model
			},
			dataTaskDescription()
			{
				return	this.dataTask.description
			}
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
			   		this.filters.page=1
					this.start();
					try 
					{
						let { data } = await axios({
						method: "get",
						url: "/app/getmachinetask/"+this.$route.params.id
						});
						this.dataTask = data;
						
					} 
					catch (e) 
					{
						this.fail();
					}
					this.getTaskDetail();
					this.finish();
			},

		async getTaskDetail()
		{
				try 
					{
						this.filters.machine_id=this.$route.params.id
						let { data } = await axios({
						method: "get",
						url: "/app/taskdetail",
						params: this.filters
						});
						this.dataList = data.data;
						this.itemsPerPage=data.per_page;
						this.pageCount=data.last_page;
						this.filters.page=data.current_page
						this.loading=false;  
						            
					} 
					catch (e) 
					{
						this.fail();
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
					this.loading = false;
					setTimeout(() => {
						this.editedItem = Object.assign({}, this.defaultItem);
						this.otherFile=[];
						this.editedIndex = -1;
					}, 300);
		},
		async save() 
		{
					this.loading=true;
					if (this.editedIndex > -1) {
						
						try {
							let { data } = await axios({
							method: "put",
							url: "/app/taskdetail/" + this.dataList[this.editedIndex].id,
							data: this.editedItem
							});
							if (data.status) {
							this.snacks('Successfully Done','green')
							Object.assign(this.dataList[this.editedIndex],data.data);
							this.close();
							}
							else{
								this.snacks("Failed", "red");
								this.loading = false;
							}
						} catch (e) {
							this.loading = false;
							this.snacks('Operation Failed','red')
						
						}
						
					} 
					else {
						
						try {
							
							this.editedItem.machine_id=this.$route.params.id
							let { data } = await axios({
							method: "post",
							url: "/app/taskdetail",
							data: this.editedItem
							});
							if (data.status) {
							this.snacks('Successfully Done','green')
							this.dataList.unshift(data.data);
							this.close();
							}
							else
							{
								this.snacks("Failed", "red");
								this.loading = false;
							}
							} catch (e) {
								this.loading = false;
								this.snacks('Operation Failed','red')

							}
							
					}
		},
		async remove() 
		{
					try {
						let { data } = await axios({
						method: "delete",
						url: "/app/taskdetail/" + this.dataList[this.dataIndex].id
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

					}
		}
	}
};
</script>