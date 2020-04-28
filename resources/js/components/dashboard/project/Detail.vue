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
									<v-list-item-title class="headline headertitle "> <h3> {{dataProject.title}} </h3></v-list-item-title>
								</v-col>
								
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3">
									<v-list-item-subtitle class="headeroption"><h4>CUSTOMER NAME : <span>{{dataProject.customer.name}}</span></h4></v-list-item-subtitle>
								</v-col>
								<v-col  class="myresp col-sm-6 col-md-4 col-lg-3" >
									<v-list-item-subtitle class="headeroption"><h4>REMARKS : <span>{{dataProject.remark}}</span></h4></v-list-item-subtitle>
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3">
									<v-list-item-subtitle class="headeroption"><h4>BELONGS TO : <span>{{dataProject.admin.name}}</span></h4></v-list-item-subtitle>
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3">
									<v-list-item-subtitle class="headeroption"><h4>STATUS : 
									<v-chip class="ma-2"  outlined  v-if="dataProject.status==1" > Initial stage </v-chip>
                                    <v-chip class="ma-2"   color="primary" v-else-if="dataProject.status==2" > Onging stage </v-chip>
                                    <v-chip class="ma-2"   color="orange" v-else-if="dataProject.status==3" > Final stage </v-chip>
                                    <v-chip class="ma-2"   color="green" v-else-if="dataProject.status==4" > Completed stage </v-chip>
									</h4></v-list-item-subtitle>
								</v-col>
								<v-col  class="myresp col-sm-12 col-md-6 col-lg-6">
									<v-list-item-subtitle class="headeroption" style="padding-left:15px;"><h3>DESCRIPTION : <span>{{dataProject.description}}</span></h3></v-list-item-subtitle>
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3" >
									<v-col sm="12" md="12" lg="12" class="doc">PROPOSAL</v-col>
									<v-list-item-subtitle class="headeroption"> <span>{{dataProject.proposal}}</span><a :href="dataProject.proposal_src" target="_blank" download> download link</a></v-list-item-subtitle>
								</v-col>
								<v-col class="myresp col-sm-6 col-md-3 col-lg-3" >
									<v-col sm="12" md="12" lg="12" class="doc">OTHER DOCUMENT</v-col>
									<v-list-item-subtitle v-for="(data,index) in dataProject.document" :key="index" class="headeroption space"> {{data.document}} <a :href="data.document_src" target="_blank" download>download link</a></v-list-item-subtitle>
								</v-col>
								
							</v-row>
							</v-list-item-content>
							</v-list-item>
							<v-dialog v-model="dialog" persistent max-width="800px">
								<v-card>
									<v-card-title>
									<span class="headline">New Schedule</span>
									</v-card-title>
									<v-card-text>
									<v-container>
										 <v-form
											ref="form"
											v-model="valid"
											lazy-validation
										>
										<v-row>
											
										<v-col cols="12" sm="12" md="12">
											<v-text-field label="Title*"  
											v-model="editedItem.title"
											:rules="[v => !!v || 'title is required']"
											filled
											></v-text-field>
										</v-col>
										<v-col cols="12" sm="12" md="12">
											<v-textarea label="Description*"  
											v-model="editedItem.description"
											:rules="[v => !!v || 'Description is required']"
											filled
											></v-textarea>
										</v-col>
										<v-col cols="12" sm="6" md="6">
											<v-text-field label="File Name"  
											v-model="editedItem.file_name"
											filled
											></v-text-field>
										</v-col>
										<v-col cols="12" sm="6" md="6">
											<v-file-input
													v-model="otherFile"
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
										</v-col>
										
										</v-row>
										 </v-form>
									</v-container>
									</v-card-text>
									<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn color="primary" text @click="dialog = false">Close</v-btn>
									<v-btn color="primary" text @click="save">Save</v-btn>
									</v-card-actions>
								</v-card>
                 			</v-dialog>
							<v-card-text>
										<template>
												<v-expansion-panels focusable inset hover  tile >
													<v-expansion-panel v-for="(item,i) in dataList"
     												 :key="i" >
													<v-expansion-panel-header >
														 <v-list-item>
															 <v-list-item-icon>
															<v-chip
																class="ma-2"
      															small
																color="blue"
																outlined
																v-if="item.sender_id==admin_id"
																>
																Me
															</v-chip>
															<v-chip
																class="ma-2"
      															small
																color="blue"
																outlined
																v-else
																>
																{{item.user.name}}
															</v-chip>
															</v-list-item-icon>
															<v-list-item-content>
															<v-list-item-title v-text="item.title"></v-list-item-title>
															</v-list-item-content>
																{{item.created_at.slice(0,-9)}}
															<v-list-item-icon>
																<p v-if="item.sender_id==admin_id">
															<v-tooltip bottom>
																<template v-slot:activator="{ on }">
																<v-icon small @click="editItem(item)" v-on="on">edit</v-icon>
																</template>
																<span>Edit</span>
															</v-tooltip>
																<v-tooltip bottom>
																<template v-slot:activator="{ on }">
																<v-icon small @click="deleteItem(item)" v-on="on">delete</v-icon>
																</template>
																<span>Delete</span>
															</v-tooltip>
																</p>
															</v-list-item-icon>
														</v-list-item>
														</v-expansion-panel-header>
														
													
													<v-expansion-panel-content>
														<v-list-item-subtitle class="headeroption">Description : <span>{{item.description}}</span></v-list-item-subtitle> 
														<p v-if="item.file_src">
															<v-divider></v-divider>
															{{item.file_name}}:
															<a :href="item.file_src" target="_blank" download >download link</a>
														</p>
													</v-expansion-panel-content>
													</v-expansion-panel>
												</v-expansion-panels>
												<div class="text-center">
												<v-pagination
												v-model="filters.page"
												:length="pageCount"
												@input="getProjectDiscussion"
												color="primary"
												></v-pagination>
												</div>
										</template>
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
				dataProject: 
				{
					customer:
					{
							name:''
					},
					admin:
					{
							name:''
					}
				},
				filters:
				{
					page: 1,
					show: 20,
					project_id:"",
				},
				editedItem:
				 {
					title: "",
					description:"",
					file_name:"",
					receiver_id:"",
					project_id:"",
				 },
				defaultItem: 
				{
					title: "",
					description:"",
					file_name:"",
					receiver_id:"",
					project_id:"",
				},
				
	}),

	computed: 
	{
			formTitle() 
			{
					return this.editedIndex === -1 ? "New UserType" : "Edit UserType";
			}
	},

	watch: {},

	created()
	 {
		 	this.admin_id= this.$store.state.authUser.id
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
						url: "/app/projectdetail/"+this.$route.params.id
						});
						this.dataProject = data;
						
					} 
					catch (e) 
					{
						this.fail();
					}
					this.getProjectDiscussion();
					this.finish();
			},

		async getProjectDiscussion()
		{
				try 
					{
						this.filters.project_id=this.dataProject.id
						let { data } = await axios({
						method: "get",
						url: "/app/projectdiscussion",
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
						if (this.$refs.form.validate()) {
						try {
							const formData = new FormData();
							formData.append("otherFile", this.otherFile);   // single file
							formData.append("_method", "put");
							for ( var key in this.editedItem ) {
							formData.append(key, this.editedItem[key]);
							}
							let { data } = await axios({
							method: "POST",
							url: "/app/projectdiscussion/" + this.dataList[this.editedIndex].id,
							data: formData
							});
							if (data.status) {
							this.snacks('Successfully Done','green')
							Object.assign(this.dataList[this.editedIndex],this.editedItem);
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
					} 
					else {
						if (this.$refs.form.validate()) {
						try {
							this.editedItem.project_id=this.dataProject.id
							this.editedItem.receiver_id=this.dataProject.customer.id
							const formData = new FormData();
							formData.append("otherFile", this.otherFile);   // single file
							for ( var key in this.editedItem ) {
							formData.append(key, this.editedItem[key]);
							}
							let { data } = await axios({
							method: "post",
							url: "/app/projectdiscussion",
							data: formData
							});
							if (data.status) {
							this.snacks('Successfully Done','green')
							this.dataList.unshift(data.data);
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
					}
		},
		async remove() 
		{
					try {
						let { data } = await axios({
						method: "delete",
						url: "/app/projectdiscussion/" + this.dataList[this.dataIndex].id
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