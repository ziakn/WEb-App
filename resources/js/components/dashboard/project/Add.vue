<template>
	<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
					
					
						 <v-form
					ref="form"
					v-model="valid"
					lazy-validation
				>
				
							<v-card  class="mt-5">
								<v-toolbar flat color="white">
                            <v-toolbar-title>Add Project </v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                             <v-spacer></v-spacer>
                        </v-toolbar>
								<v-card-text>
									<v-row justify="center"  sm="12" md="12" lg="11">
										<v-col sm="12" md="12" lg="6" >
											<v-select
												v-model="formValue.customer_id"
												:items="dataCustomer"
												item-text="name"
												item-value="id"
												:rules="[v => !!v || 'Customer is required']"
												label="Select Customer*"
												filled
											></v-select>
										</v-col>
                                        <v-col sm="12" md="12" lg="6" >
											<v-select
												v-model="formValue.status"
												:items="status"
												item-text="name"
												item-value="value"
												:rules="[v => !!v || 'projecty Status is required']"
												label="Select Status*"
												filled
											></v-select>
										</v-col>
										<v-col sm="12" md="12" lg="6" >
											<v-text-field
													v-model="formValue.title"
													:rules="[v => !!v || 'Title required',
													v => v.length<=200 || '200 Charecter crossed']"
													label="Title*"
													filled
											></v-text-field>
										
										</v-col>
										<v-col sm="12" md="12" lg="6" >
											
											<v-text-field
												v-model="formValue.remark"
												filled
												label="Remarks"
											></v-text-field>
										</v-col>
										<v-col sm="12" md="12" lg="12" >
											<v-textarea
												v-model="formValue.description"
												filled
												:rules="[v => !!v || 'Description is required']"
												label="Description*"
											
												></v-textarea>
										</v-col>
								
									<v-col sm="12" md="12" lg="6" >
                                   
									  <v-file-input
                                            v-model="proposal"
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
                                    	<v-col sm="12" md="12" lg="6" >
                                   
									  <v-file-input
                                        v-model="other_doc"
                                        color="blue accent-4"
                                        label="Document"
                                        multiple
                                        placeholder="Multiple Files"
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
							</v-card-text>
							</v-card>
						
					 </v-form>

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
		<v-btn bottom color="green darken-3" dark fab fixed large right @click="addData" >
			<v-icon>check</v-icon>
		</v-btn>
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
			customer_id:'',
			title:'',
			description:'',
			proposal:'',
			remark:'',
            status:'',
        },
        
        proposal:[],
        other_doc:[],
		
		status:[
			{name:'Initial Stage', value:1},
            {name:'On Going Stage', value:2},
            {name:'Final Stage', value:3},
            {name:'Completed Stage', value:4},
		],
		
        absolute: true,
		editedIndex:null,
        tab: null,
        dataCustomer:[],
		
	}),

	computed: {	
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
					url: "/app/getcustomer"
				});
				this.dataCustomer = data;
			} catch (e) {
				this.fail();
			}
			this.finish();
		},
		
		async addData()
		{
			if (this.$refs.form.validate()) {
			try {
                 const formData = new FormData();
                    
                    this.other_doc.forEach(file => {         //multi file
						formData.append("other_doc[]", file, file.name);
                    });

                    formData.append("proposal", this.proposal);   // single file

                    for ( var key in this.formValue ) {
						formData.append(key, this.formValue[key]);
					}
				let { data } = await axios({
					method: "post",
					url: "/app/project",
					data:formData
				});
				this.snacks('Successfully Done','green')
				 this.$router.push('/dashboard/project/list')
			} catch (e) {
				this.fail();
				this.snacks('Failed','red')
				
			}
		} 
		}


	}
};
</script>