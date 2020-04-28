import Vue from "vue";
import Router from 'vue-router'
import dashboard from './components/dashboard/overview/Home.vue'
import project from './components/dashboard/project/Home.vue'
import ledger from './components/dashboard/ledger/Home.vue'
import product from './components/dashboard/product/Home.vue'
import excellsheet from './components/dashboard/excel/Home.vue'
import dealtelesale from './components/dashboard/dealtelesale/Home.vue'
import excellsheetbde from './components/dashboard/excelbde/Home.vue'
import targetbde from './components/dashboard/targetbde/Home.vue'
import targetbdm from './components/dashboard/targetbdm/Home.vue'
import appoinmentrefer from './components/dashboard/appoinmentfixed/Home.vue'
import workflow from './components/dashboard/appoinmentfixed/Home.vue'
import deal from './components/dashboard/deal/Home.vue'
import user from './components/dashboard/user/Home.vue'
import customerproduct from './components/dashboard/customer/Home.vue'
import chating from './components/dashboard/chat/Home.vue'

import userlist from './components/dashboard/user/List.vue'
import usertype from './components/dashboard/user/Type.vue'
import userpassword from './components/dashboard/user/Password.vue'
import usertargetbde from './components/dashboard/user/TargetBDE.vue'
import usertargetbdm from './components/dashboard/user/TargetBDM.vue'
import usertargetbdelist from './components/dashboard/user/TargetBDEList.vue'
import usertargetbdmlist from './components/dashboard/user/TargetBDMList.vue'
import usersalebdelist from './components/dashboard/user/SaleBDEList.vue'
import usersalebdmlist from './components/dashboard/user/SaleBDMList.vue'
import profile from './components/dashboard/profile/Profile.vue'
import projectlist from './components/dashboard/project/List.vue'
import projectadd from './components/dashboard/project/Add.vue'
import projectedit from './components/dashboard/project/Edit.vue'
import projectdetail from './components/dashboard/project/Detail.vue'
import productlist from './components/dashboard/product/List.vue'
import productadd from './components/dashboard/product/Add.vue'
import productedit from './components/dashboard/product/Edit.vue'
import excellsheetlist from './components/dashboard/excel/List.vue'
import excellsheetassign from './components/dashboard/excel/Assign.vue'
import excellsheetbdelist from './components/dashboard/excelbde/List.vue'
import dealtelesaleclosed from './components/dashboard/dealtelesale/Closed.vue'
import appoinmentreferlist from './components/dashboard/appoinmentfixed/List.vue'
import appoinmentreferdealclosed from './components/dashboard/appoinmentfixed/DealClosed.vue'
import appoinmentrefernotintrested from './components/dashboard/appoinmentfixed/NotIntrested.vue'
import workflowlist from './components/dashboard/workflowbdm/List.vue'
import workflowdealclosed from './components/dashboard/workflowbdm/DealClosed.vue'
import workflownotintrested from './components/dashboard/workflowbdm/NotIntrested.vue'
import dashboardoverview from './components/dashboard/overview/OverView.vue'
import dealclosed from './components/dashboard/deal/DealClosed.vue'
import dealfollowup from './components/dashboard/deal/DealFollowUp.vue'
import dealnotintrested from './components/dashboard/deal/DealNotIntrested.vue'
import dealcancel from './components/dashboard/deal/DealCancel.vue'
import ledgerhead from './components/dashboard/ledger/Head.vue'
import ledgerlist from './components/dashboard/ledger/List.vue'
import ledgersaleclosedlist from './components/dashboard/ledger/SaleClosedList.vue'
import targetbdelist from './components/dashboard/targetbde/List.vue'
import targetbdmlist from './components/dashboard/targetbdm/List.vue'
import customerproductlist from './components/dashboard/customer/ProductList.vue'
import customerproductinvoicelist from './components/dashboard/customer/InvoiceList.vue'
import customerproductseparateinvoicelist from './components/dashboard/customer/CustomerInvoiceList.vue'

import chatingchat from './components/dashboard/chat/Chat.vue'
import chatingprivate from './components/dashboard/chat/Private.vue'



let allOnly=[1,2,3,4,5,6]
let adminAcountantOnly=[1,5]
let adminBdeBdmOnly=[1,2,3]
let adminOnly=[1]
let bdmOnly=[2]
let bdeOnly=[3]
let telesaleOnly=[4]
let customerOnly=[6]

Vue.use(Router)
export default new Router({
    mode: "history",
    routes: [ 
        {
            path: '/dashboard',
            component: dashboard,
            meta: {
                title: 'Dashboard',
                type: allOnly,
            },
            children: [
                {
                    path: '/',
                    component: dashboardoverview,    // for super admin
                    meta: {
                        title: 'Overview',
                        type: allOnly,
                    }
                },
              
            ]
        },
        {
            path: '/dashboard/user',
            component: user,
            meta: {
                title: 'User',
                type: adminBdeBdmOnly,
            },
            children: [
                {
                    path: 'list',
                    component: userlist,             //for super admin, bdm, bde
                    meta: {
                        title: 'List',
                        type: adminBdeBdmOnly,
                    }
                },
                {
                    path: 'type',
                    component: usertype,              //for super admin,
                    meta: {
                        title: 'Type',
                        type: adminOnly,
                    }
                },
                {
                    path: 'password',
                    component: userpassword,       //for super admin, bdm ,bde
                    meta: {
                        title: 'Password',
                        type: adminBdeBdmOnly,
                    }
                },
                {
                    path: 'targetbdm',
                    component: usertargetbdm,         // for super admin
                    meta: {
                        title: 'User Target',
                        type: adminOnly,
                    }
                },
                {
                    path: 'targetbdmlist/:id',
                    component: usertargetbdmlist,      
                    meta: {
                        title: 'User Target list',
                        type: adminOnly,
                    }
                },
                {
                    path: 'salebdmlist/:id',
                    component: usersalebdmlist,
                    meta: {
                        title: 'User Sale list',
                        type: adminOnly,
                    }
                },
                {
                    path: 'targetbde',
                    component: usertargetbde,         //for bdm
                    meta: {
                        title: 'User Target',
                        type: bdmOnly,
                    }
                },
                {
                    path: 'targetbdelist/:id',
                    component: usertargetbdelist,      
                    meta: {
                        title: 'User Target list',
                        type: bdmOnly,
                    }
                },
                {
                    path: 'salebdelist/:id',
                    component: usersalebdelist,
                    meta: {
                        title: 'User Sale list',
                        type: bdmOnly,
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
                 type: allOnly, 
                }
        },
      
        {
            path: '/dashboard/project',
            component: project,
            meta: {
                title: 'Project',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: projectlist,
                    meta: {
                        title: 'Project list',
                        type: adminOnly,
                    }
                },
                {
                    path: 'add',
                    component: projectadd,
                    meta: {
                        title: 'Project Add',
                        type: adminOnly,
                    }
                },
                {
                    path: 'edit/:id',
                    component: projectedit,
                    meta: {
                        title: 'Project Edit',
                        type: adminOnly,
                    }
                },
                {
                    path: 'detail/:id',
                    component: projectdetail,
                    meta: {
                        title: 'Project detail',
                        type: adminOnly,
                    }
                },
            ]
        },
        

        {
            path: '/dashboard/ledger',
            component: ledger,
            meta: {
                title: 'Ledger',
                type: adminAcountantOnly,
            },
            children: [
                {
                    path: 'head',
                    component: ledgerhead,
                    meta: {
                        title: 'Ledger Head',
                        type: adminAcountantOnly,
                    }
                },
                {
                    path: 'list',
                    component: ledgerlist,
                    meta: {
                        title: 'Ledger List',
                        type: adminAcountantOnly,
                    }
                },
                {
                    path: 'saleclosedlist',
                    component: ledgersaleclosedlist,
                    meta: {
                        title: 'Ledger Sale Closed List',
                        type: adminAcountantOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/product',
            component: product,
            meta: {
                title: 'Product',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: productlist,
                    meta: {
                        title: 'Product list',
                        type: adminOnly,
                    }
                },
                {
                    path: 'add',
                    component: productadd,
                    meta: {
                        title: 'Product Add',
                        type: adminOnly,
                    }
                },
                {
                    path: 'edit/:id',
                    component: productedit,
                    meta: {
                        title: 'Product Edit',
                        type: adminOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/customerproduct',
            component: customerproduct,
            meta: {
                title: 'Product',
                type: customerOnly,
            },
            children: [
                {
                    path: 'list',
                    component: customerproductlist,
                    meta: {
                        title: 'Product list',
                        type: customerOnly,
                    }
                },
                {
                    path: 'invoicelist',
                    component: customerproductinvoicelist,
                    meta: {
                        title: 'Product list',
                        type: customerOnly,
                    }
                },
                {
                    path: 'customerinvoicelist/:id',
                    component: customerproductseparateinvoicelist,
                    meta: {
                        title: 'Product list',
                        type: customerOnly,
                    }
                },
            ]
        },
       
        {
            path: '/dashboard/chating',
            component: chating,
            meta: {
                title: 'Product',
                type: allOnly,
            },
            children: [
                {
                    path: 'chat',
                    component: chatingchat,
                    meta: {
                        title: 'chat',
                        type: allOnly,
                    }
                },
                {
                    path: 'private',
                    component: chatingprivate,
                    meta: {
                        title: 'chat',
                        type: allOnly,
                    }
                },
            ]
        },
       
        {
            path: '/dashboard/excellsheet',
            component: excellsheet,
            meta: {
                title: 'Excell',
                type: telesaleOnly,
            },
            children: [
                {
                    path: 'list',
                    component: excellsheetlist,
                    meta: {
                        title: 'Excell list',
                        type: telesaleOnly,
                    }
                },
                {
                    path: 'assign',
                    component: excellsheetassign,
                    meta: {
                        title: 'Assign',
                        type: telesaleOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/dealtelesale',
            component: dealtelesale,
            meta: {
                title: 'Deal',
                type: telesaleOnly,
            },
            children: [
                {
                    path: 'closed',
                    component: dealtelesaleclosed,
                    meta: {
                        title: 'Closed',
                        type: telesaleOnly,
                    }
                },
            ]
        },
        {
            path: '/dashboard/targetbde',
            component: targetbde,
            meta: {
                title: 'Target',
                type: bdeOnly,
            },
            children: [
                {
                    path: 'list',
                    component: targetbdelist,
                    meta: {
                        title: 'Target list',
                        type: bdeOnly,
                    }
                },
            ]
        },
        {
            path: '/dashboard/excellsheetbde',
            component: excellsheetbde,
            meta: {
                title: 'Excell',
                type: bdeOnly,
            },
            children: [
                {
                    path: 'list',
                    component: excellsheetbdelist,
                    meta: {
                        title: 'Excell list',
                        type: bdeOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/appoinmentrefer',
            component: appoinmentrefer,
            meta: {
                title: 'Appoinemnt Fixed',
                type: bdeOnly,
            },
            children: [
                {
                    path: 'list',
                    component: appoinmentreferlist,
                    meta: {
                        title: 'Appoinment list',
                        type: bdeOnly,
                    }
                },
                {
                    path: 'dealclosed',
                    component: appoinmentreferdealclosed,
                    meta: {
                        title: 'Deal Closed',
                        type: bdeOnly,
                    }
                },
                {
                    path: 'notintrested',
                    component: appoinmentrefernotintrested,
                    meta: {
                        title: 'Not Intrested',
                        type: bdeOnly,
                    }
                },
                
            ]
        },

        {
            path: '/dashboard/workflow',
            component: workflow,
            meta: {
                title: 'Appoinemnt Fixed',
                type: bdmOnly,
            },
            children: [
                {
                    path: 'list',
                    component: workflowlist,
                    meta: {
                        title: 'Deal list',
                        type: bdmOnly,
                    }
                },
                {
                    path: 'dealclosed',
                    component: workflowdealclosed,
                    meta: {
                        title: 'Deal Closed',
                        type: bdmOnly,
                    }
                },
                {
                    path: 'notintrested',
                    component: workflownotintrested,
                    meta: {
                        title: 'Not Intrested',
                        type: bdmOnly,
                    }
                },
            ]
        },
        {
            path: '/dashboard/targetbdm',
            component: targetbdm,
            meta: {
                title: 'Target',
                type: bdmOnly,
            },
            children: [
                {
                    path: 'list',
                    component: targetbdmlist,
                    meta: {
                        title: 'Target list',
                        type: bdmOnly,
                    }
                },
            ]
        },

        {
            path: '/dashboard/deal',
            component: deal,
            meta: {
                title: 'Appoinemnt Fixed',
                type: adminOnly,
            },
            children: [
                {
                    path: 'closed',
                    component: dealclosed,
                    meta: {
                        title: 'Deal Closed',
                        type: adminOnly,
                    }
                },
                {
                    path: 'followup',
                    component: dealfollowup,
                    meta: {
                        title: 'Deal Follow UP',
                        type: adminOnly,
                    }
                },
                {
                    path: 'notintrested',
                    component: dealnotintrested,
                    meta: {
                        title: 'Deal Not Intrested',
                        type: adminOnly,
                    }
                },
                {
                    path: 'cancel',
                    component: dealcancel,
                    meta: {
                        title: 'Deal Not Intrested',
                        type: adminOnly,
                    }
                },
            ]
        },
       ]
})