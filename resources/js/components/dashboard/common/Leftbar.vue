<template>
  <div>
    <v-navigation-drawer
      v-model="trigger"
      :clipped="$vuetify.breakpoint.lgAndUp"
      color="cyan"
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
            active-class="cyan darken-4 white--text"
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
              active-class="cyan accent-3  white--text"
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
    user_type_id:null,
    items: [
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "dashboard",
        text: "Dashboard",
        model: false,
       parentAllowed:[1],
        children: [
          { text: "Overview", link: "" , allowed:[1]},
          ]
      },
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "Customer Managment",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Customer List", link: "customer/list" ,allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "Sales People Managment",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Sales People List", link: "sales/list" ,allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "local_shipping",
        text: "Driver Managment",
        model: false,
       parentAllowed:[1],
        children: [
          { text: "Driver List", link: "driver/list" ,allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "local_shipping",
        text: "Vehicle Managment",
        model: false,
      parentAllowed:[1],
        children: [
          { text: "Vehicle Type", link: "vehicle/type" ,allowed:[1]},
          { text: "Vehicle List", link: "vehicle/list" ,allowed:[1]},
        ]
      },
       
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "note",
        text: "Coupon Managment",
        model: false,
      parentAllowed:[1],
        children: [
          { text: "Coupon Type", link: "coupon/type" ,allowed:[1]},
          { text: "Customer Coupon List", link: "coupon/customercouponlist" ,allowed:[1]},
          { text: "Customer Consume Coupon ", link: "coupon/customerconsumecouponlist" ,allowed:[1]},
        ]
      },
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "my_location",
        text: "Zone Managment",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Zone List", link: "zone/list" ,allowed:[1]},
          { text: "Customer zone List", link: "zone/customerzonelist" ,allowed:[1]},
          
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "gesture",
        text: "Route Managment",
        model: false,
       parentAllowed:[1],
        children: [
          { text: "Route List", link: "route/list" ,allowed:[1]},
          { text: "Remainig Customer/Branches", link: "route/remainigcustomerlist" ,allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "settings_applications",
        text: "Reports",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Route", link: "report/routelist" , allowed:[1]},
          { text: "Customer", link: "report/customerlist" , allowed:[1]},
          { text: "Delivery", link: "report/deliverylist" , allowed:[1]},
          { text: "Sale", link: "report/salelist" , allowed:[1]},
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "settings_applications",
        text: "Setting",
        model: false,
        parentAllowed:[1],
        children: [
          { text: "Profile", link: "profile" , allowed:[1]},
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
        if(d==this.user_type_id)
        return d
      }
        return false;
    },
    showChild(child) {
      for( let d of child.allowed)
      {
        if(d==this.user_type_id)
        return true
      }
      return false;
    },

  },
    created() {
    this.user_type_id = this.$store.state.authUser.user_type_id
  },
};
</script>