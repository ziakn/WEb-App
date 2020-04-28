<template>
<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12" >
          <v-toolbar flat color="white">
            <v-toolbar-title>BDM List</v-toolbar-title>
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
                         <v-text-field 
                        v-model="editedItem.name" 
                        label="BDM"
                        disabled
                        required
                        filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        v-model="editedItem.remark" 
                        label="Remark"
                        :rules="[v => !!v || 'Remark is required']"
                        required
                        filled
                        ></v-text-field>
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
                        v-model="editedItem.target_debit"
                        label="Value"
                        :rules="[v => !!v || 'Amount/Number is required']"
                        type="number"
                        required
                        filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12s md12 >
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
          <v-data-table :headers="headers" :items="dataBDM">
              <template v-slot:item.status="{ item }">
                        <v-chip class="ma-2" color="primary" v-if="item.status==1" > Active </v-chip>
                         <v-chip class="ma-2" color="red" v-else > Disabled </v-chip>
              </template>
              <template v-slot:item.action="{ item }">
                 <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                    <v-btn x-small color="primary" @click="editItem(item)" v-on="on">New Target</v-btn>
                    </template>
                    <span>Set Target To BDM </span>
                  </v-tooltip>
                  <v-tooltip bottom>
                   <template v-slot:activator="{ on }">
                        <v-btn x-small color="primary" @click="targetList(item)" v-on="on">List</v-btn>
                   </template>
                        <span>BDM Target List</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                   <template v-slot:activator="{ on }">
                        <v-btn x-small color="primary" @click="saleList(item)" v-on="on">Sale List</v-btn>
                   </template>
                        <span>BDM Sale List</span>
                  </v-tooltip>
              </template>
            <template v-slot:no-data>
                <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
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
import DeleteModal from "./../common/DeleteModal";
export default {
  components: {
		DeleteModal
	},
  data: () => ({
    	        valid: false,
              menu: false,
              absolute: true,
              loading:false,
              snackbar: false,
              dataIndex: null,
              deleteTitle: "",
              deleteBody: "",
              isDelete: false,
              edit: true,
              dialog: false,
              mode: "",
              timeout: 6000,
              text: "Hello, I'm a snackbar",
              dialog: false,
              date: new Date().toISOString().substr(0, 7),
              dataList: [],
              dataBDM: [
              ],
              headers: [
                { text: "ID", align: "left", value: "id" },
                {text: "Name", value: "name"},
                { text: "Email", value: "email" },
                { text: "Mobile", value: "contact" },
                { text: "status", value: "status" },
                { text: "Action", value: "action" }
              ],
              editedIndex: -1,
              editedItem: {
                name:'',
                admin_id: "",
                bde_id:"",
                deal_id: "",
                date:"",
                year:"",
                remark:"",
                target_debit: "",
                balance:"",
                status:"",
              },
              type:[
                  { text: "Numbers", value: 'number' },
                  { text: "Amount", value: 'amount' },
              ],
              status:[
                  { text: "Active", value: 1 },
                  { text: "In Active", value: 0 },
                ],
              defaultItem: {
                name:'',
                admin_id: "",
                bde_id:"",
                deal_id: "",
                date:"",
                year:"",
                remark:"",
                target_debit: "",
                balance:"",
                status:"",
              }
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
                async initialize() {
                    try {
                        let { data } = await axios({
                        method: "get",
                        url: "/app/target"
                        });
                    this.dataList = data;
                  } catch (e) {}
            try {
                    let { data } = await axios({
                      method: "get",
                      url: "/app/getbdm/target"
                    });
                    this.dataBDM = data;
                  } catch (e) {}
                },
                editItem(item) {
                  this.edit = false;
                  this.editedIndex = this.dataList.indexOf(item);
                  this.editedItem = Object.assign({}, item);
                  this.dialog = true;
                },
                deleteItem(item) {
                  this.dataIndex = this.dataList.indexOf(item);
                  this.deleteTitle = "Are you sure you want to delete this item?";
                  this.isDelete = !this.isDelete;
                },
                close() {
                  this.dialog = false;
                  setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                  }, 300);
                },
                async save() {
                  if (this.editedIndex > -1) {
                    try {
                      let { data } = await axios({
                        method: "put",
                        url: "/app/target/" + this.dataList[this.editedIndex].id,
                        data: this.editedItem
                      });
                      Object.assign(this.dataList[this.editedIndex], data.data);
                      this.close();
                    } catch (e) {
                        this.snacks('Operation Failed','red')
                    }
                  } else {
                    if (this.$refs.form.validate()) {
                    try {
                      
                      let { data } = await axios({
                        method: "post",
                        url: "/app/target/savebdm",
                        data: this.editedItem
                      });
                      this.snacks('Successfully Done','green')
                      this.dataList.unshift(data.data);
                      this.close();
                    } catch (e) {
                        this.snacks('Operation Failed','red')
                    }
                    }
                    else{
                      return
                    }
                  }
                },
                async remove() {
                  this.loading=true;
                  try {
                    let { data } = await axios({
                      method: "delete",
                      url: "/app/target/" + this.dataList[this.dataIndex].id
                    });
                    if (data.status) {
                      this.snacks('Successfully Done','green')
                      this.dataList.splice(this.dataIndex, 1);
                      this.close();				
                    }
                    else
                    {
                      this.snacks(data.data,'red')
                      this.loading = false;
                    }

                  } catch (e) {
                    this.snacks('Operation Failed','red')
                    this.loading = false;
                  }
                },
                targetList(item)
                    {
                        this.$router.push('/dashboard/user/targetbdmlist/'+item.id);
                    },
                saleList(item)
                    {
                        this.$router.push('/dashboard/user/salebdmlist/'+item.id);
                    },
              }
            };
</script>