<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
            <v-row>
                <v-col>
                    <v-toolbar flat color="white">
						<v-toolbar-title>Product List</v-toolbar-title>
						<v-divider class="mx-2" inset vertical></v-divider>
						<v-spacer></v-spacer>
						<v-text-field
                            dense
							v-model="search"
							append-icon="search"
							label="Search"
							hide-details
							outlined

						></v-text-field>
					</v-toolbar>
                     <v-card flat>
                        <v-card-text>
                            <v-data-table  :headers="headers" :items-per-page="filters.show" :search="search" :items="dataList" 
                                hide-default-footer
                            > 
                                <template v-slot:item.logo="{ item }">
								<v-img
									:src="item.logo"
									aspect-ratio="1"
									class="grey lighten-2"
									width="80"
									height="80"
									></v-img>
                                </template>
                                  <template v-slot:item.status="{ item }">
                                    <v-chip class="ma-2" color="primary" v-if="item.status==1" > completed </v-chip>
                                    <v-chip class="ma-2" color="red" v-if="item.status ==0" > Incomplete </v-chip>
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
                                @input="getProduct"
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
			:right="snackright"
			:color="snackcolor"
		>
			{{ snacktext }}
			
		</v-snackbar>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
            <v-btn bottom color="accent" dark fab fixed right @click="addProduct">
                        <v-icon  v-on="on">mdi-plus</v-icon>
                </v-btn>
            </template>
            <span>Add New Product</span>
        </v-tooltip>
        
        <DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
	</v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
export default {
    components: {
        DeleteModal,
      
    },
	data: () => ({
       search:"",
    	dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
        itemsPerPage:1,
        pageCount:2,
		search: "",
		absolute: true,
		loading: false,
        dataList: [],
		
        filters:
        {
			page: 1,
			show: 20,
        },
		headers: [
            { text: "ID", align: "left", value: "id" },
            { text: "Logo", value: "logo" },
			{ text: "Name", value: "name" },
			{ text: "Subject", value: "subject" },
			{ text: "Statement", value: "statement" },
            { text: "Web Site", value: "website_link" },
            { text: "Play store", value: "playstore_link" },
            { text: "Remark", value: "remark" },
            { text: "Status", value: "status" },
            { text: 'Action', value: 'action' },
		],
	}),
    computed: {},
	watch: {},
	created() {
        this.initialize();
        	},
    methods: {
            async initialize() {
                this.filters.page=1
                this.getProduct();
                },
        async getProduct()
        {
            this.loading=true;
            try {
				let { data } = await axios({
					method: "get",
                    url: "/app/product",
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
        addProduct()
        {
          this.$router.push('/dashboard/product/add')  
        },
        editItem(item)
        {
            this.$router.push('/dashboard/product/edit/'+item.id);

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
        	async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/product/" + this.dataList[this.dataIndex].id
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
		
	}
};
</script>