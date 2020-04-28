<template>
<v-content>
		<v-container fluid>
		<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
                     <!-- <v-col cols="5">
                            <v-select
                                v-model="filters.admin_id"
                                :items="dataUser"
                                item-text="name"
                                item-value="id"
                                label="Belongs To"
                                required
								clearable
                                filled
								@change="getProject"
                            ></v-select>                            
                        </v-col> -->
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Project List</v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                             <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card flat>
                        <v-card-text>
                            <v-data-table :headers="headers" :items="dataList" :items-per-page="filters.show"   hide-default-footer >
                            <template v-slot:item.customer_id="{ item }">
                                            {{item.customer.name}}
                                </template>
                                <template v-slot:item.admin_id="{ item }">
                                            {{item.admin.name}}
                                </template>
                                <template v-slot:item.status="{ item }">
                                            <v-chip class="ma-2"  outlined  v-if="item.status==1" > Initial stage </v-chip>
                                            <v-chip class="ma-2"   color="primary" v-else-if="item.status==2" > Onging stage </v-chip>
                                            <v-chip class="ma-2"   color="orange" v-else-if="item.status==3" > Final stage </v-chip>
                                            <v-chip class="ma-2"   color="green" v-else-if="item.status==4" > Completed stage </v-chip>
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <!-- <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                              <v-icon small @click="detailItem(item)" v-on="on">filter_1</v-icon>
                                            </template>
                                            <span>Detail </span>
                                        </v-tooltip> -->
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
                            @input="getProject"
                            color="primary"
                            ></v-pagination>
                            </div>
                         </v-card-text>
                    </v-card>
        <DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
	</v-container>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
               <v-btn bottom color="primary" dark fab fixed right @click="save">
			    <v-icon v-on="on">mdi-plus</v-icon>
		        </v-btn>
            </template>
            <span>Add New Project</span>
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
        loading: false,
        itemsPerPage:1,
        pageCount:2,
		search: "",
		headers: [
			{ text: "ID", value: "id" },
			{ text: "Title", value: "title" },
			{ text: "Description", value: "description" },
			{ text: "Remark", value: "remark" },
			{ text: "Customer", value: "customer_id" },
            { text: "Belongs To", value: "admin_id" },
            { text: "Status", value: "status" },
			{ text: "Action", align: "center", value: "action", sortable: false }
		],
		editedIndex: -1,
        defaultItem: {},
        dataList:[],
        dataUser:[],
        status:[
			{name:'Initial Stage', value:1},
            {name:'On Going Stage', value:2},
            {name:'Final Stage', value:3},
            {name:'Completed Stage', value:4},
        ],
         filters:
        {
          
            start:new Date().toISOString().substr(0, 10),
			end:"",
			page: 1,
			show: 20,
        },
	}),

	created() {
		this.initialize();
	},
	methods: {
        save(item) {
			this.$router.push('/dashboard/project/add');
		},
        editItem(item)
        {
            this.$router.push('/dashboard/project/edit/'+item.id);

        },
        detailItem(item)
        {
            this.$router.push('/dashboard/project/detail/'+item.id);

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
        async initialize() {
            
            this.filters.page=1
             try {
				let { data } = await axios({
					method: "get",
                    url: "/app/user",
				});
				this.dataUser = data;          
			} catch (e) {   
                this.loading=false;   
            }

            this.getProject();

        	},
        async getProject()
        {
            this.loading=true;
            try {
				let { data } = await axios({
					method: "get",
                    url: "/app/project",
                    params: this.filters
				});
                this.dataList = data.data;
                this.itemsPerPage=data.per_page;
                this.pageCount=data.last_page;
                this.filters.page=data.current_page
				this.loading=false;                
			} catch (e) {
				this.loading=false;                

                
            }
        },
		async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/project/" + this.dataList[this.dataIndex].id
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
            
        },
        async getDetail()
            {
                
            }
	}
};
</script>