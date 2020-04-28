<template>
<v-content>
		<v-container fluid>
		
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-toolbar flat color="white">
            <v-toolbar-title>Deal Cancel (Revoked)</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            
          </v-toolbar>
          <v-data-table :headers="headers" :items-per-page="filters.show" :items="dataList" >
             <template v-slot:item.bdm_id="{ item }">
                          {{item.bdm.name}}
              </template>
              <template v-slot:item.deal_id="{ item }">
                          {{item.deal.company_name}}
              </template>
              
            <template v-slot:no-data>
                 <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
          <div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getDealCancel"
                                ></v-pagination>
                            </div>
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
	  itemsPerPage:1,
        pageCount:2,
    dataList: [],
    headers: [
      { text: "ID", align: "left", value: "id" },
      {text: "Cancel By", value: "bdm_id"},
      { text: "Deal", value: "deal_id" },
      { text: "Remark", value: "remark" },
      { text: "Date", value: "created_at" },
    ],
   filters:
        {
			page: 1,
			show: 20,
        },
  }),
 
  computed: {
  },
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
         this.filters.page=1
         this.getDealCancel();
    },

    async getDealCancel()
    {
    try {
            let { data } = await axios({
            method: "post",
            url: "/app/getdealcancel/bdm",
            params: this.filters
            });
            this.dataList = data.data;
            this.itemsPerPage=data.per_page;
            this.pageCount=data.last_page;
            this.filters.page=data.current_page
        } catch (e) {}
        }
    } 
}
</script>