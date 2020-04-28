<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
               <v-row>
                        <v-col sm="12" md="12" lg="6">
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
                          v-model="filters.month"
                          label="Month"
                          prepend-inner-icon="event"
                          readonly
                          v-on="on"
                          filled
                          clearable
                          @click:clear="initialize"
                          ></v-text-field>
                          </template>
                          <v-date-picker type="month" v-model="filters.month" @input="menu1= false" @change="getExcellSheet" ></v-date-picker>
                        </v-menu>
                        </v-col>
                        <v-col  sm="12" md="6" lg="6">
                            <v-menu
                                v-model="date2"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"  
                            >
                            <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="filters.start"
                                label="date"
                                readonly
                                prepend-inner-icon="event"
                                v-on="on"
                                clearable
                                @click:clear="initialize"
                                filled
                            ></v-text-field>
                            </template>
                            <v-date-picker @change="getExcellSheet" v-model="filters.start" @input="date2 = false"></v-date-picker>
                            </v-menu>
                        </v-col> 
                </v-row>
            <v-row>
                 <v-dialog v-model="dialog" persistent max-width="800px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">Edit</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container>
                            <v-row>
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
                                    v-model="editedItem.date"
                                    label="Date"
                                    prepend-inner-icon="event"
                                    readonly
                                    v-on="on"
                                    filled
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="editedItem.date" @input="menu1 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Company"  
                                  v-model="editedItem.company_name"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Attention"  
                                  v-model="editedItem.attention"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Position"  
                                  v-model="editedItem.position"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Mobile"  
                                  v-model="editedItem.mobile"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Phone" 
                                  v-model="editedItem.phone"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-text-field label="Email"  
                                  v-model="editedItem.email"
                                  filled
                                 ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-select
                                    v-model="editedItem.excel_sheet_status_id"
                                    :items="status"
                                    item-text="text"
                                    item-value="value"
                                    label="Appoinment Status"
                                    
                                    filled
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                 <v-menu
                                     ref="menu"
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="editedItem.appoinment_time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                    >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            v-model="editedItem.appoinment_time"
                                            label="Appoinment Time"
                                            prepend-inner-icon="access_time"
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
                                      @click:minute="$refs.menu.save(time)"
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
                                    v-model="editedItem.appoinment_date"
                                    label="Appoinment Date"
                                    prepend-inner-icon="event"
                                    readonly
                                    filled
                                    v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="editedItem.appoinment_date" @input="menu3 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                              <v-col cols="12" sm="6" md="12">
                                  <v-text-field label="Remark"  
                                   v-model="editedItem.remark"
                                   filled
                                  ></v-text-field>
                            </v-col>
                             <v-col cols="12" sm="6" md="12">
                                  <v-text-field label="Address"  
                                   v-model="editedItem.address"
                                   filled
                                  ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="12">
									<v-select
										v-model="product"
										:items="dataProduct"
										item-text="name"
                                        item-value="id"
										return-object
										:rules="[v => !!v.length || 'Product is required']"
										required
										label="Product*"
										multiple
										filled
										chips
									>
									</v-select>
                            </v-col>
                            <v-flex xs12 sm12 md12>
								<GmapMap
								:center="position"
								:zoom="zoom"
								map-type-id="terrain"
								style="width: auto; height: 300px"
								@click="newmark"
								>
								<GmapMarker
									:position="position"
									:clickable="true"
									:draggable="true"
									@dragend="mapitem"
									/>
								</GmapMap>
							</v-flex>
                            </v-row>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="dialog = false">Close</v-btn>
                        <v-btn color="primary" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>

                 <v-dialog v-model="dialog1" persistent max-width="550px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">Download Proposal</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container>
                            <v-row justify="center">
                           <v-simple-table dense>
                                <template v-slot:default>
                                <thead>
                                    <tr>
                                    <th class="text-left">Product Name</th>
                                    <th class="text-left">Download Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in editedItem.product" :key="i">
                                    <td> {{item.product.name}}</td>
                                    <td> <a :href="'/downloadpdf/'+item.excelsheet_id+'/'+item.product.id" target="_blank">download</a> </td>
                                    </tr>
                                </tbody>
                                </template>
                            </v-simple-table>

                            </v-row>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="dialog1 = false">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>
               
                <v-col>
                    <v-toolbar flat color="white">
						<v-toolbar-title>Deal Closed</v-toolbar-title>
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
                            <v-data-table dense :headers="headers" :items-per-page="filters.show" :search="search" :items="dataList"  >
                                    <template v-slot:item.excel_sheet_status_id="{ item }">
                                       <v-select
										v-model="item.excel_sheet_status_id"
										:items="status"
										item-text="text"
										item-value="value"
										solo
                                        disabled
										dense
										class="mt-3"
										style="max-width: 150px"
										@change="changeStatus(item)"
									></v-select>   
                                    </template>
                                    <template v-slot:item.status="{ item }">
                                       <v-select
										v-model="item.status"
										:items="dealStatus"
										item-text="text"
										item-value="value"
										solo
                                        disabled
										dense
										class="mt-3"
										style="max-width: 150px"
										@change="changeDealStatus(item)"
									></v-select>   
                                    </template>
                                     <template v-slot:item.admin_id="{ item }">
                                    {{item.telesale.name}}
                                   </template>
                                   <template v-slot:item.bde_id="{ item }">
                                    {{item.bussinessde.name}}
                                   </template>
                                    <template v-slot:item.action="{ item }">
                                          <!-- <v-icon small @click="assignBDE(item)">assignment_ind</v-icon>
                                          <v-icon small @click="editItem(item)">edit</v-icon>
                                         <v-icon small @click="deleteItem(item)">delete</v-icon> -->
                                         <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                              <v-icon small @click="proposalItem(item)" v-on="on">post_add</v-icon>
                                            </template>
                                            <span>Proposal </span>
                                        </v-tooltip>
                                         <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                              <v-icon small @click="paymentDialog=true" v-on="on">payment</v-icon>
                                            </template>
                                            <span>Proposal </span>
                                        </v-tooltip>
                                   </template>
                                    <template v-slot:no-data>
                                        <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                                        No Data Found
                                        <!-- <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn> -->
                                    </template>
                            </v-data-table>
                            <div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getExcellSheet"
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
       <!-- <v-btn bottom color="accent" dark fab fixed right @click="dialog = !dialog">
			<v-icon>mdi-plus</v-icon>
		</v-btn> -->
        <DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
         <v-dialog v-model="paymentDialog" persistent max-width="550px">
                    <v-card>
                        <v-card-title>
                        <span class="headline">Payment</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container>
                            <v-row justify="center" >
                             
                       <v-form action="https://sadadqa.com/webpurchase" method="post">
                      
                         
                            <v-text-field
                            v-model="parameter.merchant_id"
                            label="merchant_id(string)"
                         
                            ></v-text-field>
                             <v-text-field
                            v-model="parameter.secret_key"
                            label="secret_key(string)"
                            ></v-text-field>

                             <v-text-field
                            v-model="parameter.TXN_AMOUNT"
                            label="TXN_AMOUNT(string/n)"
                            ></v-text-field>

                             <v-text-field
                            v-model="parameter.ORDER_ID"
                            label="ORDER_ID(string)"
                            ></v-text-field>

                           
                           
                             <v-text-field
                            v-model="parameter.CALLBACK_URL"
                            label="CALLBACK_URL"
                            ></v-text-field>

                            <v-text-field
                            v-model="parameter.WEBSITE"
                            label="WEBSITE(string)"
                            ></v-text-field>

                            <v-text-field
                            v-model="parameter.CUST_ID"
                            label="CUST_ID String (Optional)"
                            ></v-text-field>

                            <v-text-field
                            v-model="parameter.EMAIL"
                            label="EMAIL"
                            ></v-text-field>

                             <v-text-field
                            v-model="parameter.MOBILE_NO"
                            label="MOBILE_NO"
                            ></v-text-field>

                            <v-text-field
                            v-model="parameter.txnDate"
                            label="txnDate"
                            ></v-text-field>
                            
                          
                            <span ><h4>Product Detail</h4></span>
                            <div  v-for="(data,index) in this.parameter.productdetail" :key="index">
                                 
                                <v-text-field
                                v-model="data.itemname"
                                label="product name"
                                ></v-text-field>
                                 
                                <v-text-field
                                v-model="data.quantity"
                                label="Quantity"
                                ></v-text-field>
                                   
                                <v-text-field
                                v-model="data.amount"
                                label="Amount"
                                ></v-text-field>
                                
                            </div>
                         
                            <v-btn type="submit" value="Submit">Submit</v-btn>
                        </v-form>    
                      
                            </v-row>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="close">Close</v-btn>
                        <v-btn color="primary" text @click="orderPayment">Submit</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>
	</v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
export default {
    components: {
        DeleteModal,
      
    },
	data: () => ({
        merchant_id:'',
        secret_key:'',
        TXN_AMOUNT:'',
        ORDER_ID:'',
        CALLBACK_URL:'',
        productdetail:
        [
            {
                 itemname:'',
                 amount:'',
                 quantity:'',
                 type:'',
                 item_meta:null,
            }
        ],
        CUST_ID:'',             //optional
        EMAIL:'',               //optional
        MOBILE_NO:'',
        txnDate:'',             //optional
        WEBSITE:'',             //optional
        parameter:{
        merchant_id:'',
        secret_key:'',
        TXN_AMOUNT:'',
        ORDER_ID:'',
        CALLBACK_URL:'',
        productdetail:
        [
            {
                 itemname:'',
                 amount:'',
                 quantity:'',
                 type:'',
                 item_meta:null,
            }
        ],
        CUST_ID:'',             //optional
        EMAIL:'',               //optional
        MOBILE_NO:'',
        txnDate:'',             //optional
        WEBSITE:'',             //optional
        },















        zoom:13,
		 center: {
            lat: 25.2854,
            lng: 51.5310
          },
          markers: [ {
            position: {
              lat: 25.2854,
              lng: 51.5310
            }
          }],
        date2:false,
        menu:false,
        dialog: false,
        dialog1:false,
        paymentDialog:false,
        menu1:false,
        menu2: false,
        menu3:false,
        ampmInTitle: true,
        time:null,
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
        edit: true,
        timeout: 6000,
        dataList: [],
        dataBDE: [],
        dataProduct:[],
        product:[],
         filters:
        {
            start:'',
			page: 1,
            show: 20,
            month:'',
        },
		headers: [
            { text: "ID", align: "left", value: "id" },
            { text: "Date", value: "date" },
            { text: "Company", value: "company_name" },
			{ text: "Attention", value: "attention" },
			{ text: "Position", value: "position" },
			{ text: "Mobile", value: "mobile" },
            { text: "Phone", value: "phone" },
            { text: "Email", value: "email" },
            { text: "Status", value: "excel_sheet_status_id" },
            { text: "Date", value: "appoinment_date" },
            { text: "Start", value: "start_appoinment_time" },
            { text: "End", value: "end_appoinment_time" },
            { text: "Remark", value: "remark" },
            { text: "Address", value: "address" },
            { text: "TeleSale", value: "admin_id" },
            { text: "BDE", value: "bde_id" },
            {text : "Deal Status", value:"status"},
            { text: 'Action', value: 'action' },
        ],
         editedIndex: -1,
         editedItem: {
            date: "",
            company_name: "",
            attention:'',
            position: "",
            mobile:"",
            phone: "",
            email: "",
            excel_sheet_status_id: "",
            appoinment_time:'',
            appoinment_date:'',
            remark: "",
            address:"",
            admin_id:'',
             lat:25.2854,
            lng:51.5310,
            product:[],
            },
        defaultItem:{
            date: "",
            company_name: "",
            attention:'',
            position: "",
            mobile:"",
            phone: "",
            email: "",
            excel_sheet_status_id: "",
            appoinment_time:'',
            appoinment_date:'',
            remark: "",
            address:"",
            admin_id:'',
             lat:25.2854,
            lng:51.5310,
            product:[],
        },
            status:[
                { text: "Not Complete", value: 0 },
                { text: "Appoinment Fixed", value: 1 },
                { text: "Follow Up", value: 2 },
            ],
           dealStatus:[
                { text: "Not Intrested", value: 0 },
                { text: "Deal closed", value: 1 },
                { text: "Follow Up", value: 2 },
            ],

    }),
   
    computed: {
        position()
		{
			var position =
			{
				lat: this.editedItem.lat,
				lng: this.editedItem.lng
			}
			return position;
		}
    },
    watch: {},
    mounted()
    {
        // this.orderPayment();
        console.log(1);
    },
    created() 
    {
        this.initialize();
            
     },
    methods: {
         mapitem(i)
		{
			this.center.lat=i.latLng.lat();
			this.center.lng=i.latLng.lng();
			this.editedItem.lat=i.latLng.lat();
			this.editedItem.lng=i.latLng.lng();
		},
		newmark(i)
		{
			this.editedItem.lat=i.latLng.lat();
			this.editedItem.lng=i.latLng.lng();
		},
		setPlace(place) {
			this.center.lat=place.geometry.location.lat();
			this.center.lng=place.geometry.location.lng();
			this.editedItem.lat=place.geometry.location.lat();
			this.editedItem.lng=place.geometry.location.lng();
			this.zoom=16
        
      },
        async changeStatus(i)
                    {
                        this.loading = true;	
                        try {
                            let { data } = await axios({
                                method: "post",
                                url: "/app/excel/change_status",
                                data: i
                            });
                            if (data.status) {
                                this.snacks("Successfully Changed", "green");
                                this.close();
                            } else {
                                this.snacks("Failed", "red");
                                this.loading = false;
                            }
                        } catch (e) {
                            this.snacks("Error, Server issue", "red");
                            this.loading = false;
                        } 
                    },

                     async changeDealStatus(i)
                    {
                        this.loading = true;	
                        try {
                            let { data } = await axios({
                                method: "post",
                                url: "/app/excellsheet/changedealstatus/bde",
                                data: i
                            });
                            if (data.status) {
                                this.snacks("Successfully Changed", "green");
                                this.close();
                            } else {
                                this.snacks("Failed", "red");
                                this.loading = false;
                            }
                        } catch (e) {
                            this.snacks("Error, Server issue", "red");
                            this.loading = false;
                        } 
                    },
        
            async initialize()
             {
                  this.loading = true;	
                this.filters.page=1
                     try {
                    let { data } = await axios({
                        method: "get",
                        url: "/app/bussinessdevelopmentexecutive"  
                    });
                    this.dataBDE = data;
                        }
                        catch (e) {
                            this.loading=false;
                        }

                    try {
				let { data } = await axios({
					method: "get",
					url: "/app/getproduct"  
                });
				this.dataProduct = data;
                    }
                     catch (e) {
                        this.loading=false;
                    }

                this.getExcellSheet();
                 this.loading = false;
            },
            async getExcellSheet()
                        {
                            this.loading=true;
                            try {
                                let { data } = await axios({
                                    method: "post",
                                    url: "/app/getcloseddeal",
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

            assignBDE(item){
                            this.edit = false;
                            this.editedIndex = this.dataList.indexOf(item);
                            this.editedItem = Object.assign({}, item);
                            this.dialog1 = true;
                        },

             editItem(item) {
                            this.product=[];
                            this.edit = false;
                            this.editedIndex = this.dataList.indexOf(item);
                            this.editedItem = Object.assign({}, item);
                            for(let p of this.editedItem.product)
                                {
                                    this.product.push(Object.assign({}, p.product))

                                }
                            this.dialog = true;
                            },

            deleteItem(item) {
                                this.dataIndex = this.dataList.indexOf(item);
                                    this.deleteTitle = "Are you sure you want to delete this item?";
                                    this.isDelete = !this.isDelete;
                            },
            proposalItem(item) {
                                    this.editedIndex = this.dataList.indexOf(item);
                                    this.editedItem = Object.assign({}, item);
                                    this.dialog1 = true;
                            },
           
            close() {
                            this.dialog = false;
                             this.dialog1 = false;
                             this.paymentDialog=false;
                            setTimeout(() => {
                                this.editedItem = Object.assign({}, this.defaultItem);
                                this.editedIndex = -1;
                            }, 300);
                        },

             async save() {
                    if (this.editedIndex > -1) 
                    {
                        try {  
                           
                            this.editedItem.product=this.product
                        let { data } = await axios({
                            method: "put",
                            url: "/app/excellsheet/" + this.dataList[this.editedIndex].id,
                            data: this.editedItem
                        });
                        this.snacks('Successfully Done','green')
                        Object.assign(this.dataList[this.editedIndex], data.data);
                        this.close();
                        } 
                        catch (e) 
                        {
                        }
                    } 
                    else
                     {
                        try { 
                            this.editedItem.product=this.product
                        let { data } = await axios({
                            method: "post",
                            url: "/app/excellsheet", 
                            data: this.editedItem
                        });
                        this.snacks('Successfully Done','green')
                        data.excel_sheet_status_id=parseInt(data.excel_sheet_status_id)
                        this.dataList.unshift(data.data);
                        this.close();
                        } 
                        catch (e) 
                        {
                        }
                    }
            },

             async orderPayment()
               {
                        
                    console.log(this.productdetail)
                    this.parameter
                    try{
                        let { data } = await axios({
                            method: "post",
                            url: "/app/payment/callback",
                            params :this.parameter
                        });
                        this.close();
                        } 
                        catch (e) 
                        {
                        }   
                },

          async saveBDE()
            {
                
                 try { 
                  let { data } = await axios({
                            method: "post",
                            url: "/app/assignbde/",
                            data: this.editedItem
                        });
                        this.snacks('Successfully Done','green')
                        Object.assign(this.dataList[this.editedIndex], data);
                        this.close();
                 }
                 catch (e) 
                        {
                        }
            },


         async remove() {
                    try {
                        let { data } = await axios({
                            method: "delete",
                            url: "/app/excellsheet/" + this.dataList[this.dataIndex].id
                        });
                        this.snacks('Successfully Done','green')
                        this.dataList.splice(this.dataIndex, 1);
                        this.close();
                    } catch (e) {
                        this.snacks('Operation Failed','red')

                    }
                    
                },
		
	}
};
</script>