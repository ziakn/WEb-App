<template>
  <v-content>
    <v-container fluid>
      <v-overlay :value="showFullLoading" :absolute="absolute">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
         <v-row justify="center">
            <v-col sm="12" md="12" lg="11">
              <v-row >
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
                          <v-date-picker type="month" v-model="filters.month" @input="menu1= false" @change="getTargetListBDE" ></v-date-picker>
                          </v-menu>
                  </v-col>
            </v-row>
            <v-toolbar flat color="white">
                  <v-toolbar-title>BDE Sale List</v-toolbar-title>
                  <v-divider class="mx-2" inset vertical></v-divider>
                  <v-spacer></v-spacer>
                  <v-dialog v-model="dialog" max-width="500px">
                      
                  <!-- <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Target</v-btn>
                  </template> -->
                  <v-form
					ref="form"
					v-model="valid"
					lazy-validation
				>
                  <v-card>
                  <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                  </v-card-title>
                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 sm12 md12>
                        <v-text-field v-model="editedItem.remark" label="Remark" type="text" filled></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-select
                          v-model="editedItem.type"
                          :items="type"
                          item-text="text"
                          item-value="value"
                          label="Target"
                          :rules="[v => !!v || 'Amount/Number is required']"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                            <v-text-field
                            v-model="editedItem.target_credit"
                            label="Value"
                            type="number"
                             :rules="[v => !!v || 'Amount/Number is required']"
                            filled
                            required
                            ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                            <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                            >
                          <template v-slot:activator="{ on }">
                              <v-text-field
                              v-model="editedItem.date"
                              label="Month"
                              prepend-inner-icon="event"
                              readonly
                              :rules="[v => !!v || 'Month is required']"
                              v-on="on"
                              filled
                            ></v-text-field>
                          </template>
                          <v-date-picker  type="month" v-model="editedItem.date" @input="menu= false"></v-date-picker>
                        </v-menu>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="primary" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
              </v-form>
            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataTarget" :items-per-page="filters.show">
            <template v-slot:item.bde_id="{ item }">
              {{item.bussinessde.name}}
              </template>
              <template v-slot:item.product_id="{ item }">
              {{item.product.name}}
              </template>
               <template v-slot:item.deal_id="{ item }">
              {{item.excelsheet.attention}}
              </template>
            <!-- <template v-slot:item.action="{ item }">
              <v-icon small @click="editItem(item)">edit</v-icon>
              <v-icon small @click="deleteItem(item)">delete</v-icon>
            </template> -->
            <template v-slot:no-data>
              <v-skeleton-loader type="table-tbody"></v-skeleton-loader>No Data Found
              <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
            </template>
          </v-data-table>
          <div class="text-center">
              <v-pagination
                v-model="filters.page"
                :length="pageCount"
                @input="getTargetListBDE"
              ></v-pagination>
          </div>
        </v-col>
      </v-row>
      <DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
    </v-container>
    <v-snackbar
      v-model="snackbar"
      :vertical="snackvertical"
      :timeout="snacktimeout"
      :top="snacktop"
      :color="snackcolor"
    >
      {{ snacktext }}
      <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
import { async } from 'q';
export default {
  components: {
    DeleteModal
  },
  data: () => ({
     valid: false,
    absolute: true,
    loading: false,
    menu: false,
    menu1: false,
    snackbar: false,
    dataIndex: null,
    deleteTitle: "",
    deleteBody: "",
    isDelete: false,
    edit: true,
    dialog: false,
    itemsPerPage:1,
    pageCount:2,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    dialog: false,
    dataTarget: [],

    headers: [
      { text: "ID", align: "left", value: "id" },
      { text: "Name", value: "bde_id" },
      { text: "Product", value: "product_id" },
      { text: "Customer", value: "deal_id" },
      { text: "Credit", value: "credit" },
      { text: "Volume Credit", value: "volume_credit" },
      { text: "Date", value: "date" },
      // { text: "Action", value: "action" }
    ],

    editedIndex: -1,
    editedItem: {
      id: "",
      admin_id: "",
      deal_id: "",
      date: "",
      year: "",
      type: "",
      target_credit: "",
      balance: "",
      status: ""
    },
    status: [{ text: "Active", value: 1 }, { text: "In Active", value: 0 }],
     type:[
                  { text: "Numbers", value: 'number' },
                  { text: "Amount", value: 'amount' },
              ],
    defaultItem: {
      id: "",
      admin_id: "",
      deal_id: "",
      date: "",
      year: "",
      type: "",
      target_credit: "",
      balance: "",
      status: ""
    },
    filters:
        {
			      page: 1,
            show: 20,
            start:'',
            month:'',
        },
  }),
  props: {
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Target" : "Edit Target";
    }
  },
  watch: {},

  created() 
  {
    this.initialize();
  },
  methods: 
      {
    initialize()
      {
        this.filters.month='';
          this.getTargetListBDE();
      },
      async getTargetListBDE()
      {
            try {
              let { data } = await axios({
                method: "put",
                url: "/app/salelist/bde/" + this.$route.params.id,
                params: this.filters
              });
              this.dataTarget = data;
              this.itemsPerPage=per_page;
              this.pageCount=last_page;
              this.filters.page=current_page
            } catch (e) {}
    },

    editItem(item) 
    {
          this.edit = false;
          this.editedIndex = this.dataTarget.indexOf(item);
          this.editedItem = Object.assign({}, item);
          this.dialog = true;
    },
    deleteItem(item) 
    {
          this.dataIndex = this.dataTarget.indexOf(item);
          this.deleteTitle = "Are you sure you want to delete this item?";
          this.isDelete = !this.isDelete;
    },
    close() 
    {
          this.dialog = false;
          setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
           }, 300);
    },
    async save() 
    {
      if (this.editedIndex > -1) 
      {
          try {
            let { data } = await axios({
              method: "put",
              url: "/app/target/" + this.dataTarget[this.editedIndex].id,
              data: this.editedItem
            });
            Object.assign(this.dataTarget[this.editedIndex], data.data);
            this.close();
          } catch (e) {}
        }
       else 
       {
            if (this.$refs.form.validate()) 
            {
                  try {
                    this.editedItem.id = this.$route.params.id;
                    
                    let { data } = await axios({
                      method: "post",
                      url: "/app/target",
                      data: this.editedItem
                    });
                    this.dataTarget.unshift(data.data);
                    this.close();
                  } catch (e) {}
              }
          else{
                return
             }
      }
    },

    async remove() 
    {
      this.loading = true;
      try {
        let { data } = await axios({
          method: "delete",
          url: "/app/target/" + this.dataTarget[this.dataIndex].id
        });
        if (data.status) {
          this.snacks("Successfully Done", "green");
          this.dataTarget.splice(this.dataIndex, 1);
          this.close();
        } else {
          this.snacks(data.data, "red");
          this.loading = false;
        }
      } catch (e) {
        this.snacks("Operation Failed", "red");
        this.loading = false;
      }
    }
  }
};
</script>