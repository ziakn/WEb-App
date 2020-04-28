<template>
	<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="10" >
					<v-row>
						<v-col cols="12" lg="6" offset="6">
							<v-text-field
								v-model="search"
								append-icon="search"
								label="Search"
								single-line
								hide-details
								filled
							></v-text-field>
						</v-col>
					</v-row>
					<v-toolbar flat color="white">
						<v-toolbar-title>User Type List</v-toolbar-title>
						<v-divider class="mx-2" inset vertical></v-divider>
						<v-spacer></v-spacer>
						<v-dialog v-model="dialog" max-width="500px">
						<v-card>
						<v-card-title>
						<span class="subtitle-1">{{ formTitle }}</span>
						</v-card-title>
						<v-card-text>
						<v-container grid-list-md>
								<v-layout wrap>	
								<v-flex xs12 sm12 md12>
								<v-text-field
									v-model="editedItem.name"
									label="User Type"
									:rules="[v => !!v || 'User type is required']"
									required
									filled
									></v-text-field>
									</v-flex>
									</v-layout>
									</v-container>
								</v-card-text>
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn text color="error" @click="close">Cancel</v-btn>
									<v-btn  :loading="loading" :disabled="loading" text color="primary" @click="save">Save</v-btn>
								</v-card-actions>
							</v-card>
						</v-dialog>
					</v-toolbar>
					<v-data-table :headers="headers" :items="dataList" :search="search" class="elevation-1">

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
                <v-btn bottom color="accent" dark fab fixed right @click="dialog = !dialog">
                        <v-icon  v-on="on">mdi-plus</v-icon>
                </v-btn>
            </template>
            <span>Add New User</span>
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
		absolute: true,
		loading:false,
		search: "",
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
		edit: true,
		dialog: false,
		filterValue:
		{

        },
        dataPages:[],
		snackBar: {
			text: "",
			color: "red",
			trigger: false
		},
		dataList: [],
		headers: [
			{ text: "ID", value: "id" },
			{ text: "User Type", value: "name" },
			{ text: "Action", align: "center", value: "action", sortable: false }
		],

		editedIndex: -1,
		editedItem: {
			name: "",
		},
		defaultItem: {
            name: "",
		},
		user_type_id:"",
	}),

	computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New UserType" : "Edit UserType";
		}
	},
	watch: {},

	created()
	 {
		this.user_type_id=window.authUser.user_type_id;
		this.initialize();
	 },
	methods: {
		async initialize() 
		   {
				this.start();
				try {
					let { data } = await axios({
					method: "get",
					url: "/app/usertypelist"
					});
					this.dataList = data;
				} catch (e) {
					this.fail();
				}
				this.finish();
		},

		editItem(item)
		 {
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem.name = item.name;
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
				this.editedIndex = -1;
			}, 300);
		},
		async save() 
		{
			if(this.editedItem.name=='')
			{
				return
			}
			
			this.loading=true;
			if (this.editedIndex > -1) {
				try {
					let { data } = await axios({
					method: "put",
					url: "/app/usertype/" + this.dataList[this.editedIndex].id,
					data: this.editedItem
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
			else {
				try {
					let { data } = await axios({
					method: "post",
					url: "/app/usertype",
					data: this.editedItem
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
		},
		async remove() {
			try {
				let { data } = await axios({
				method: "delete",
				url: "/app/usertype/" + this.dataList[this.dataIndex].id
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