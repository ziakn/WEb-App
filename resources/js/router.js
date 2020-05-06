import Vue from "vue";
import Router from 'vue-router'
import dashboard from './components/dashboard/overview/Home.vue'
import task from './components/dashboard/task/Home.vue'
import user from './components/dashboard/user/Home.vue'
import document from './components/dashboard/document/Home.vue'


import userlist from './components/dashboard/user/List.vue'
import userpassword from './components/dashboard/user/Password.vue'
import userassignmachine from './components/dashboard/user/AssignMachine.vue'
import profile from './components/dashboard/profile/Profile.vue'
import permission from './components/dashboard/profile/Permission.vue'
import pages from './components/dashboard/profile/Pages.vue'
import documentadd from './components/dashboard/document/Add.vue'


import tasklist from './components/dashboard/task/List.vue'
import taskadd from './components/dashboard/task/Add.vue'
import taskedit from './components/dashboard/task/Edit.vue'
import taskdetail from './components/dashboard/task/Detail.vue'
import dashboardoverview from './components/dashboard/overview/OverView.vue'



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
                    path: 'password',
                    component: userpassword,       //for super admin, bdm ,bde
                    meta: {
                        title: 'Password',
                        type: adminBdeBdmOnly,
                    }
                },
                {
                    path: 'assignmachine',
                    component: userassignmachine,       //for super admin, bdm ,bde
                    meta: {
                        title: 'Assign',
                        type: adminBdeBdmOnly,
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
            path: '/dashboard/permission',
            name: 'Permission',
            component: permission,
            meta: {
                 title: 'Permission',
                 type: allOnly, 
                }
        },
        {
            path: '/dashboard/pageslist/:id',
            name: 'Pages',
            component: pages,
            meta: {
                 title: 'pages',
                 type: allOnly, 
                }
        },
        {
            path: '/dashboard/task',
            component: task,
            meta: {
                title: 'task',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: tasklist,
                    meta: {
                        title: 'task list',
                        type: adminOnly,
                    }
                },
                {
                    path: 'add',
                    component: taskadd,
                    meta: {
                        title: 'task Add',
                        type: adminOnly,
                    }
                },
                {
                    path: 'edit/:id',
                    component: taskedit,
                    meta: {
                        title: 'task Edit',
                        type: adminOnly,
                    }
                },
                {
                    path: 'detail/:id',
                    component: taskdetail,
                    meta: {
                        title: 'task detail',
                        type: adminOnly,
                    }
                },
            ]
        },
        

        {
            path: '/dashboard/document',
            component: document,
            meta: {
                title: 'Docuemnt',
                type: adminAcountantOnly,
            },
            children: [
                {
                    path: 'add',
                    component: documentadd,
                    meta: {
                        title: 'Document',
                        type: adminAcountantOnly,
                    }
                },
              
              
            ]
        },

    

    
       
    
       


      
 
        

        
        

       ]
})