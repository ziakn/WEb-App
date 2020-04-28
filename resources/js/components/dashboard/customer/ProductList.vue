<template>
<v-content>
		<v-container fluid>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
          <v-toolbar flat color="white">
            <v-toolbar-title>Product List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataList" class="elevation-1">
              <template v-slot:item.product_logo="{ item }">
                  <v-img
                    :src="item.product.logo"
                    aspect-ratio="1"
                    class="grey lighten-2"
                    width="50"
                    height="50"
                    ></v-img>
              </template>
              <template v-slot:item.product_name="{ item }">
                          {{item.product.name}}
              </template>
              <template v-slot:item.product_subject="{ item }">
                          {{item.product.subject}}
              </template>
              <template v-slot:item.action="{ item }" >
                        <v-btn x-small color="secondary" @click="invoiceIten(item)" dark>Invoice  </v-btn>
              </template>
            <template v-slot:no-data>
               <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
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
   
		loading:false,
   	dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
		edit: true,
		dialog: false,
    mode: "",
    timeout: 6000,
    dialog: false,
    dataList: [],
    headers: [
      { text: "Logo", value: "product_logo"},
      {text: "Product Name", value: "product_name"},
      { text: "Subject", value: "product_subject" },
      { text: "Invoice", value: "action" }
    ],
 
  }),
  

      created()
          {
                  this.initialize();
          },
      methods:
         {
                  async initialize() 
                        {
                          try {
                            let { data } = await axios({
                              method: "get",
                              url: "/app/customer"
                            });
                            this.dataList = data;
                          } catch (e) {}

                        },
                invoiceIten(item)
                 {
                       this.$router.push('/dashboard/customerproduct/customerinvoicelist/'+item.id); 
                 },
   
      }
    };
</script>