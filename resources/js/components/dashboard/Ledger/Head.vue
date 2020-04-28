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
						<v-toolbar-title>Ledger Head </v-toolbar-title>
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
													v-model="editedItem.ledger_name"
													label="Ledger Head Type"
													:rules="[v => !!v || 'Ledger Head type is required']"
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
							<v-icon small @click="editItem(item)">edit</v-icon>
							<v-icon small @click="deleteItem(item)">delete</v-icon>
						</template>
						<template v-slot:no-data>
                            <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                             No Data Found
                            <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
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
		<v-btn bottom color="accent" dark fab fixed right @click="dialog = !dialog">
			<v-icon>mdi-plus</v-icon>
		</v-btn>
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
			{ text: "Ledger Head", value: "ledger_name" },
			{ text: "Action", align: "center", value: "action", sortable: false }
		],

		editedIndex: -1,
		editedItem: {
			ledger_name: "",
		},
		defaultItem: {
            ledger_name: "",
        }
	}),

	computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New Ledger Head" : "Edit Leadger Head";
		}
	},
	watch: {},
	created() {
		this.initialize();
	},
	methods: {

		async initialize() {
			this.start();
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/ledgerhead"
				});
				this.dataList = data;
			} catch (e) {
				this.fail();
            }
			this.finish();
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
			this.loading = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
		async save() {
			if(this.editedItem.ledger_name=='')
			{
				return

			}
			
			this.loading=true;
			if (this.editedIndex > -1) {
				try {
					let { data } = await axios({
						method: "put",
						url: "/app/ledgerhead/" + this.dataList[this.editedIndex].id,
						data: this.editedItem
					});
					if(data.status)
					{
						this.snacks('Successfully Done','green')
						Object.assign(this.dataList[this.editedIndex], this.editedItem);
						this.close();
					}
					else{
						this.loading = false;
						this.snacks('Operation Failed','red')
					}
				} catch (e) {
					this.loading = false;
					this.snacks('Operation Failed','red')
				
				}
			} else {
				try {
					let { data } = await axios({
						method: "post",
						url: "/app/ledgerhead",
						data: this.editedItem
					});
					if(data.status)
					{	
						this.snacks('Successfully Done','green')
						this.dataList.unshift(data.data);
						this.close();
					}
					else{
						this.loading = false;
						this.snacks('Operation Failed','red')
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
					url: "/app/ledgerhead/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
				this.snacks('Successfully Done','green')
				this.dataList.splice(this.dataIndex, 1);
                this.close();
                }
                else{
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