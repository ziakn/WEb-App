<template>
  <div>
    <v-navigation-drawer
      v-model="trigger"
      :clipped="$vuetify.breakpoint.lgAndUp"
     
      class="elevation-2"
      app
    >
      <v-list shaped dense>
        <template v-for="(item,index) in items" >
          <v-row v-if="item.heading" :key="item.heading"  align="center">
            <v-col cols="6">
              <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
            </v-col>
            <v-col cols="6" class="text-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-col>
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="index"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon
            v-show="handleGoToMenus(item)"
            active-class="red lighten-3"
          >
            <template v-slot:activator>
              <v-list-item  >
                <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              :to="handleGoToMenu('/dashboard/'+child.link)"
                 v-show="showChild(child)"
            >
            <v-flex>
              <v-list-item-action v-if="child.icon">
                <v-icon >{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title >{{ child.text }}</v-list-item-title>
              </v-list-item-content>
              </v-flex>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="item.text" >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn color="primary" block href="/logoutuser">Logout</v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  props: {
    trigger: true
  },
  data: () => ({
    drawer: null,
    userType:null,
    dataUser:[],
    i:0,
    items: [
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "dashboard",
        text: "Production",
        model: false,
         parentAllowed:'',
        children: [
          { text: "Overview", link: "" , },
          ]
      },
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "Manage User",
        model: false,
        parentAllowed:'',
        children: [
          { text: "User List", link: "user/list" ,  },
          { text: "User Password", link: "user/password" , },
          { text: "Assign Machine", link: "user/assignmachine" , },
           { text: "Permission", link: "user/permission" , },
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "home_work",
        text: "CheckList OR Create",
        model: false,
         parentAllowed:'',
        children: [
          { text: "Machine List", link: "task/list" , },
        ]
      },
       
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "attach_money",
        text: "Sacn Or AddDocument",
        model: false,
         parentAllowed:'',
        children: [
          { text: "Add Doc", link: "document/add" ,  },  
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "settings_applications",
        text: "Setting",
        model: false,
         parentAllowed:'',
        children: [
          { text: "Profile", link: "profile" , },
         
        ]
      },

    ]
  }),
  created() 
    {
    this.userType = this.$store.state.authUser.id
    this.initialize();

    },
  methods: 
  {

    async initialize() {
      try 
      {
        let { data } = await axios({
          method: "get",
          url: "/app/getuserpages/"+this.userType
        });
        this.dataUser = data;
        this.items[0].parentAllowed=this.dataUser.production_overview
        this.items[1].parentAllowed=this.dataUser.manage_user
        this.items[2].parentAllowed=this.dataUser.checklist_or_create
        this.items[3].parentAllowed=this.dataUser.scan_or_document
        this.items[4].parentAllowed=this.dataUser.setting
      } catch (e) {}

    },
    handleGoToMenu(d) 
    {
      return d;
    },
    handleGoToMenus(item) 
    {
      
        if(item.parentAllowed==1)
        {
          return true
        }
        return false;
    },
    showChild(child)
    {
      
        return child
      
    },

  },
    

};
</script>