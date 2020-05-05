<template>
  <div>
    <v-navigation-drawer
      v-model="trigger"
      :clipped="$vuetify.breakpoint.lgAndUp"
      color="accent"
      dark
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
            active-class="black white--text"
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
              active-class="deep-purple white--text"
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
          <v-btn block href="/logoutuser">Logout</v-btn>
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
    items: [
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "dashboard",
        text: "Dashboard",
        model: false,
        parentAllowed:[1,2,3,4,5,6],
        children: [
          { text: "Overview", link: "" , allowed:[1,2,3,4,5,6]},
          ]
      },
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "Manage User",
        model: false,
        parentAllowed:[1,2,3],
        children: [
          { text: "User List", link: "user/list" , allowed:[1,2] },
          { text: "User Password", link: "user/password" , allowed:[1,2]},
          { text: "Assign Machine", link: "user/assignmachine" , allowed:[1,2]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "done_all",
        text: "Production Overview",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Closed", link: "deal/closed" , allowed:[1]},
          { text: "Follow Up", link: "deal/followup" , allowed:[1]},
          { text: "Not Intrested", link: "deal/notintrested" , allowed:[1]},
          { text: "Cancel (Revoked)", link: "deal/cancel" , allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "home_work",
        text: "CheckList OR Create",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Machine List", link: "task/list" , allowed:[1]},
        ]
      },
       
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "attach_money",
        text: "Sacn Or AddDocument",
        model: false,
        parentAllowed:[1,5],
        children: [
          { text: "Add Doc", link: "document/add" , allowed:[1,5] },  
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "settings_applications",
        text: "Setting",
        model: false,
        parentAllowed:[1,2,3,4,5,6],
        children: [
          { text: "Profile", link: "profile" , allowed:[1,2,3,4,5,6]},
          { text: "Permission", link: "permission" , allowed:[1,2,3,4,5,6]},
        ]
      },

    ]
  }),
  methods: {
    handleGoToMenu(d) {
      return d;
    },
    handleGoToMenus(item) {
      for( let d of item.parentAllowed)
      {
        if(d==this.userType)
        return d
      }
        return false;
    },
    showChild(child) {
      for( let d of child.allowed)
      {
        if(d==this.userType)
        return true
      }
      return false;
    },

  },
    created() {
    this.userType = this.$store.state.authUser.userType
  },
};
</script>