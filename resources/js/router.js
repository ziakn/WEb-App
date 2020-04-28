import Vue from "vue";
import Router from 'vue-router'
import dashboard from './components/dashboard/overview/Home.vue'
import customer from './components/dashboard/customer/Home.vue'
import zone from './components/dashboard/zone/Home.vue'
import coupon from './components/dashboard/coupon/Home.vue'
import driver from './components/dashboard/driver/Home.vue'
import vehicle from './components/dashboard/vehicle/Home.vue'
import route from './components/dashboard/route/Home.vue'
import sales from './components/dashboard/sales/Home.vue'
import report from './components/dashboard/report/Home.vue'

import dashboardoverview from './components/dashboard/overview/OverView.vue'
import customerlist from './components/dashboard/customer/List.vue'
import zonelist from './components/dashboard/zone/List.vue'
import zonecustomerzonelist from './components/dashboard/zone/CustomerZoneList.vue'
import zonecustomerzonebranchlist from './components/dashboard/zone/CustomerZoneBranchList.vue'
import couponcustomercouponlist from './components/dashboard/coupon/CustomerCouponList.vue'
import couponcustomerconsumecouponlist from './components/dashboard/coupon/CustomerConsumeCouponList.vue'
import reportcouponcustomerconsumecouponlist from './components/dashboard/coupon/ReportCustomerConsumeCouponList.vue'
import coupontype from './components/dashboard/coupon/Type.vue'
import driverlist from './components/dashboard/driver/List.vue'
import profile from './components/dashboard/profile/Profile.vue'
import vehicletype from './components/dashboard/vehicle/Type.vue'
import vehiclelist from './components/dashboard/vehicle/List.vue'
import routelist from './components/dashboard/route/List.vue'
import routecustomerlist from './components/dashboard/route/CustomerList.vue'
import routeremainigcustomerlist from './components/dashboard/route/RemainigCustomerList.vue'
import saleslist from './components/dashboard/sales/List.vue'
import reportroutelist from './components/dashboard/report/Route.vue'
import reportroutereport from './components/dashboard/report/RouteReport.vue'
import reportroutecustomerreport from './components/dashboard/report/RouteCustomerReport.vue'
import reportcustomerlist from './components/dashboard/report/Customer.vue'
import reportcustomerdelivery from './components/dashboard/report/CustomerDelivery.vue'
import reportcustomerpurchase from './components/dashboard/report/CustomerPurchase.vue'
import reportdeliverylist from './components/dashboard/report/Delivery.vue'
import reportsalelist from './components/dashboard/report/Sale.vue'



let adminOnly=[1]

Vue.use(Router)
export default new Router({
    mode: "history",
    routes: [ 
        {
            path: '/dashboard',
            component: dashboard,
            meta: {
                title: 'Dashboard',
                type: adminOnly,
            },
            children: [
                {
                    path: '/',
                    component: dashboardoverview,    // for super admin
                    meta: {
                        title: 'Overview',
                        type: adminOnly,
                    }
                },
              
            ]
        },
        {
            path: '/dashboard/customer',
            component: customer,
            meta: {
                title: 'Customer',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: customerlist,         
                    meta: {
                        title: 'List',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/sales',
            component: sales,
            meta: {
                title: 'Sales',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: saleslist,         
                    meta: {
                        title: 'List',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/driver',
            component: driver,
            meta: {
                title: 'Driver',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: driverlist,         
                    meta: {
                        title: 'List',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/zone',
            component: zone,
            meta: {
                title: 'Zone',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: zonelist,         
                    meta: {
                        title: 'List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerzonelist',
                    component: zonecustomerzonelist,         
                    meta: {
                        title: 'Customer ZoneList',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerzonebranchlist/:id',
                    component: zonecustomerzonebranchlist,         
                    meta: {
                        title: 'Customer Zone Branch List',
                        type: adminOnly,
                    }
                },
            ]
        },
        {
            path: '/dashboard/coupon',
            component: coupon,
            meta: {
                title: 'Coupon',
                type: adminOnly,
            },
            children: [
                {
                    path: 'type',
                    component: coupontype,         
                    meta: {
                        title: 'Type',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customercouponlist',
                    component: couponcustomercouponlist,         
                    meta: {
                        title: 'Coupon List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerconsumecouponlist',
                    component: couponcustomerconsumecouponlist,        
                    meta: {
                        title: 'Customer Consume Coupon List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerconsumecouponreport/:id',
                    component: reportcouponcustomerconsumecouponlist,         
                    meta: {
                        title: 'Customer Add Consume Coupon List',
                        type: adminOnly,
                    }
                }
            ]
        },

        {
            path: '/dashboard/vehicle',
            component: vehicle,
            meta: {
                title: 'Vehicle',
                type: adminOnly,
            },
            children: [
                {
                    path: 'type',
                    component: vehicletype,         
                    meta: {
                        title: 'Type',
                        type: adminOnly,
                    }
                },
                {
                    path: 'list',
                    component: vehiclelist,         
                    meta: {
                        title: 'Vehicle List',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/route',
            component: route,
            meta: {
                title: 'Vehicle',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: routelist,         
                    meta: {
                        title: 'Route List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerlist/:id',
                    component: routecustomerlist,         
                    meta: {
                        title: 'Customer Route List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'remainigcustomerlist',
                    component: routeremainigcustomerlist,         
                    meta: {
                        title: 'Remainig  List',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/report',
            component: report,
            meta: {
                title: 'Report',
                type: adminOnly,
            },
            children: [
                {
                    path: 'routelist',
                    component: reportroutelist,         
                    meta: {
                        title: 'Route List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'routereport/:id',
                    component: reportroutereport,         
                    meta: {
                        title: 'Route Report',
                        type: adminOnly,
                    }
                },
                {
                    path: 'routecustomerreport/:id',
                    component: reportroutecustomerreport,         
                    meta: {
                        title: 'Route Customer Report',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerlist',
                    component: reportcustomerlist,         
                    meta: {
                        title: 'Customer List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerconsume/:id',
                    component: reportcustomerdelivery,         
                    meta: {
                        title: 'Customer Consume List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'customerpurchase/:id',
                    component: reportcustomerpurchase,         
                    meta: {
                        title: 'Customer Purchase List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'deliverylist',
                    component: reportdeliverylist,         
                    meta: {
                        title: 'Customer Delivery List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'salelist',
                    component: reportsalelist,         
                    meta: {
                        title: 'Sale List',
                        type: adminOnly,
                    }
                },
               
            ]
        },

        {
            path: '/dashboard/profile',
            name: 'Profile',
            component: profile,
            meta: {
                 title: 'Profile',
                 type: adminOnly, 
                }
        },


        
       ]
})