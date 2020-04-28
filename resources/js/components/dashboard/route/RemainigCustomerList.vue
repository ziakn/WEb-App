<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
                 <v-toolbar flat color="white">
						<v-toolbar-title>Un Assigned Customer</v-toolbar-title>
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
				<v-col sm="12" md="12" lg="11" >
                       
                    <v-data-table    :headers="headers" :search="search"  :items="unAssignedCustomerData" >
                        <template v-slot:item.name="{ item }">
                            {{item.user.name}}
                        </template>
                        <template v-slot:item.email="{ item }">
                            {{item.user.email}}
                        </template>
                      <template v-slot:item.zone_id="{ item }">
                          {{item.zone.zone_no}}
                      </template>
                    </v-data-table>
				</v-col>
			</v-row>
    </v-container>
    	
  </v-content>
</template>

<script>

export default {
  components: {
	
	},
  data: () => ({
       search:"",
                unAssignedCustomerData:[],
                headers: [
                {text: "ID", value: "id"},
                { text: "Customer Name ", value: "name" },
                { text: "Email ", value: "email" },
                {text: "Branch Name", value: "branch_name"},
                { text: "Zone ", value: "zone_id" },
                ],
      
  }),
  
  props: {
    source: String
  },

  computed: { 
  },
  
  watch: 
  {
     
  },

  created() 
    {
        this.initialize();
    },

  methods: 
    {
        async initialize() 
            {
                this.getUnsingedRouteCustomerList();
            },

        async getUnsingedRouteCustomerList() 
            {
                try 
                {
                    let { data } = await axios({
                    method: "get",
                    url: "/app/unassignroutecustomer/routecustomer",
                    });
                    this.unAssignedCustomerData = data;
                    for(let o of this.unAssignedCustomerData)
                    {
                        this.selectedCustomer.push(o)
                    }
                   
                }
                catch (e) 
                {

                }
            },

        
       
        


     
            

 

      
        
  },
  
};
</script>
