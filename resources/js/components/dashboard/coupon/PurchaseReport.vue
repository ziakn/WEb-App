<template>
    <v-row >
        <v-col sm="12" md="12" lg="12">
            <v-data-table :headers="headers"  :items-per-page="filters.show" :items="dataList" class="elevation-1">
                        <template v-slot:no-data>
                        <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                        <v-btn color="primary" @click="initialize">Reset</v-btn>
                        </template>
            </v-data-table>
                    <div class="text-center">
                        <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getcustomerReport"
                        ></v-pagination>
                    </div>
        </v-col>
  </v-row>
</template>

<script>
export default {
    data: () =>({
        search:'',
        isLoading: false,
           itemsPerPage:1,
        pageCount:2,
         headers: [
        { text: "Payment Type", value: "payment_type" },
        { text: "Paid Amount", value: "paid_amount" },
        { text: "Remaining Amount", value: "remaining_amount" },
        { text: "Coupon Credit", value: "coupon_credit" },
         { text: "Total calculate", value: "total_calculate" },
        { text: "Calculate Credit", value: "calculate_credit" },
        { text: "Remaining Credit", value: "remaining_credit" },
        { text: "Renew Status", value: "renew_status" },
        { text: "Date", value: "date" },
        ],
        dataList: [],
    filters:
        {
			page: 1,
            show: 20,
            customer_id:''
        },
        
    }),
    
    props:
    {
        customerValue:Object,
    },
    watch:
    {
    },
    created()
    {
      
          this.filters.customer_id=this.customerValue.customer_id
        this.initialize();
             
        
    },
    methods:
    {
        initialize()
        {
           
            this.filters.page=1
            this.getcustomerReport();
           
        },
        async getcustomerReport()
        {
             try 
                {
                    let { data } = await axios({
                    method: "post",
                    url: "/app/getcustomerpurchasereport",
                    params: this.filters
                    });
                    this.dataList = data.data;
                    this.itemsPerPage=per_page;
                    this.pageCount=last_page;
                    this.filters.page=current_page
                }
                catch (e) 
                {

                }
        }
    }


}
</script>

<style>

</style>