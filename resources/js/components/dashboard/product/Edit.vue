<template>
	<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
					<v-tabs
					v-model="tab"
					background-color="primary"
					centered
					dark
					grow
					>
					<v-tabs-slider></v-tabs-slider>
					<v-tab href="#tab-1">
						Product Details
					</v-tab>
					</v-tabs>
					<v-tabs-items v-model="tab">
						<v-tab-item
							value="tab-1"
						>
						 <v-form
					ref="form"
					v-model="valid"
					lazy-validation
				>
				<v-card  class="mt-5">
								<v-card-text>
                                    <v-row justify="center">
                                        <v-col sm="12" md="12" lg="4" >
                                             <span class="title font-weight-light">Status</span>
											<v-select
												v-model="formValue.status"
												:items="status"
												item-text="text"
												item-value="value"
												:rules="[v => !!v || 'Product Status is required']"
												label="Select Product Status*"
												filled
											></v-select>
										</v-col>
                                        <v-col sm="12" md="12" lg="4" >
                                    <span class="title font-weight-light">Upload logo</span>
									  <v-file-input
                                        v-model="logo"
                                        color="blue accent-4"
                                        label=" Product logo"
                                        placeholder=" Product Logo"
                                        prepend-icon="mdi-paperclip"
                                        filled
										accept="image/*" 
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
								</v-card-text>
							</v-card>
							<v-card  class="mt-5">
								<v-card-title> 
									<v-icon large left color="blue">
										description
									</v-icon>
									<span class="title font-weight-light">Description</span>
								</v-card-title>
							<v-card-text>
								<v-row justify="center">
										<v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="formValue.name"
													:rules="[v => !!v || 'Product Name required']"
													label=" Product Name*"
													filled
											></v-text-field>
										</v-col>
										<!-- </v-row>
										<v-row justify="center"> -->
										<v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="formValue.subject"
													:rules="[v => !!v || 'Subject required']"
													label="Subject*"
													filled
											></v-text-field>
										</v-col>
								</v-row>
                                <v-row justify="center">
                                    <v-col sm="12" md="12" lg="8" >
											<v-textarea
												v-model="formValue.statement"
												filled
												:rules="[v => !!v || 'statement is required']"
												label="statement*"
												></v-textarea>
										</v-col>
								</v-row>
                                <v-row justify="center">
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="formValue.website_link"
													label="Playstore Link*"
													filled
											></v-text-field>
										</v-col>
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="formValue.playstore_link"
													label="Website link*"
													filled=""
											></v-text-field>
										</v-col>
								</v-row>
							</v-card-text>
							</v-card>
							<v-card  class="mt-5">
								<v-card-title> 
									<v-icon large left color="blue">
										style
									</v-icon>
									<span class="title font-weight-light">Remarks (if any)</span>
								</v-card-title>
							<v-card-text>
								<v-row justify="center">
									<v-col sm="12" md="12" lg="8" >
									<v-textarea
												v-model="formValue.remark"
												filled
												label="Remarks*"
											></v-textarea>
									</v-col>
								</v-row>
							</v-card-text>
							</v-card>
                            <v-card  class="mt-5">
								<v-card-title> 
									<v-icon large left color="blue">
										device_hub
									</v-icon>
									<span class="title font-weight-light">Product Option</span>
								</v-card-title>
							<v-card-text>
								<v-row justify="center" v-for="(input1 , index) in productOption" :key="index">
									
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="input1.frequency"
													:rules="[v => !!v || 'frequency required']"
													label="frequency*"
													filled
												
											></v-text-field>
										</v-col>
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="input1.total_amount"
													:rules="[v => !!v || 'Total Amount  required']"
													label="Total Amount *"
													filled
													type="number"
											></v-text-field>
										</v-col>
										<v-col sm="12" md="12" lg="8" >
											<v-textarea
												v-model="input1.description"
												filled
												:rules="[v => !!v || 'Description is required']"
												label="Description*"
												></v-textarea>
										</v-col>
										 <div class="my-2">
											<v-btn depressed small color="error" @click="removeproductOption(index)"><v-icon dark>mdi-minus</v-icon></v-btn>
										</div>
								</v-row>
								<v-row justify="center" >
									 <div class="my-2">
											<v-btn depressed small color="primary"  @click="addproductOption"><v-icon dark>mdi-plus</v-icon></v-btn>
										</div> 
                                    </v-row>
							</v-card-text>
							</v-card>
                            <v-card  class="mt-5">
								<v-card-title> 
									<v-icon large left color="blue">
										add_shopping_cart
									</v-icon>
									<span class="title font-weight-light">Pick Up And Deleiverys</span>
								</v-card-title>
							<v-card-text>
								<v-row justify="center" v-for="(input2 , index) in pickupDelivery" :key="index">
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="input2.tag"
													:rules="[v => !!v || 'Tag  required']"
													label="Tag*"
													filled
											></v-text-field>
										</v-col>
                                        <v-col sm="12" md="12" lg="4" >
											<v-text-field
													v-model="input2.amount"
													:rules="[v => !!v || 'Amount  required',
													v => v.length<=200 || '200 Charecter crossed']"
													label="Amount *"
													filled
													type="number"
											></v-text-field>
										</v-col>
										 <div class="my-2">
											<v-btn depressed small color="error" @click="removepickupDelivery(index)"><v-icon dark>mdi-minus</v-icon></v-btn>
										</div>
								</v-row>
								<v-row justify="center" >
									 <div class="my-2">
											<v-btn depressed small color="primary"  @click="addpickupDelivery"><v-icon dark>mdi-plus</v-icon></v-btn>
										</div> 
                                    </v-row>
							</v-card-text>
							</v-card>
							<v-btn bottom color="success" dark fab fixed large right @click="addData" >
								<v-icon>check</v-icon>
							</v-btn>
							 </v-form>
						</v-tab-item>
					</v-tabs-items>
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
		
	</v-content>
</template>

<script>


export default {
	components: {
	
	},
	data: () => ({
		valid: false,
		formValue:
		{
			name:'',
			subject:'',
			statement:'',
			website_link:'',
            playstore_link:'',
            remark:'',
            status:'',
			tag:'',
            amount:'',
        },
        productOption:[
		
		],
		pickupDelivery:[
        ],
        logo:[],
		status:[
			{ text:'In Complete', value: 0},
            { text:'Complete', value: 1},
		],
		
        absolute: true,
		editedIndex:null,
        tab: null,
      
	}),

	computed: {	
		
	},
	watch: {},
	created() {
          this.initialize();
	},
	methods: {

        addproductOption() {
			this.productOption.push({
				description:"",
				frequency:"",
				total_amount:'',
			})
			},

        removeproductOption(index){
            if(this.productOption.length==1)
            {
                return
            }
            else{
            this.productOption.splice(index,1);
			}
		},
		addpickupDelivery() {
			this.pickupDelivery.push({
				tag: '',
				amount: ''
			})
			},

        removepickupDelivery(index){
            if(this.pickupDelivery.length==1)
            {
                return
            }
            else{
            this.pickupDelivery.splice(index,1);
			}
        },
        
        async initialize() {
			this.start();
            	try {
				let { data } = await axios({
					method: "get",
					url: "/app/product/"+this.$route.params.id
				});
                this.formValue = data;
                for(let d of data.productpickupdelivery)
                {
                    this.pickupDelivery.push(JSON.parse(JSON.stringify(d)))
                }
                for(let d of data.productoption)
                {
                    this.productOption.push(JSON.parse(JSON.stringify(d)))
                }
                
			} catch (e) {
				this.fail();
            }
            
			this.finish();
		},
		async addData()
		{
			if (this.$refs.form.validate()) {
						this.start();
							try {
								const formData = new FormData();
									formData.append("logo", this.logo);   // single file
								this.pickupDelivery.forEach(file => {
									formData.append("pickupDelivery[]", JSON.stringify(file)); // array in formData
                                });
                                this.productOption.forEach(file => {
									formData.append("productOption[]", JSON.stringify(file)); // array in formData
								});
								for ( var key in this.formValue ) {
									formData.append(key, this.formValue[key]);
								}	
								let { data } = await axios({
									method: "post",
									url: "/app/productupdate",
									data:formData
								});
								this.snacks('Successfully Done','green')
								this.$router.push('/dashboard/product/list')
							} catch (e) {
								this.fail();
								this.snacks('Failed','red')
								
							}
							this.finish();
				}
		else{
			return
		}
			
		}


	}
};
</script>