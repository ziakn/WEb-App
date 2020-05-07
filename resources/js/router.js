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




Vue.use(Router)
export default new Router({
    mode: "history",
    routes: [ 
        {
            path: '/dashboard',
            component: dashboard,
            meta: {
                title: 'Dashboard',
            },
            children: [
                {
                    path: '/',
                    component: dashboardoverview,    // for super admin
                    meta: {
                        title: 'Overview',
                    }
                },
              
            ]
        },
        {
            path: '/dashboard/user',
            component: user,
            meta: {
                title: 'User',
            },
            children: [
                {
                    path: 'list',
                    component: userlist,             //for super admin, bdm, bde
                    meta: {
                        title: 'List',
                    }
                },
                {
                    path: 'password',
                    component: userpassword,       //for super admin, bdm ,bde
                    meta: {
                        title: 'Password',
                    }
                },
                {
                    path: 'assignmachine',
                    component: userassignmachine,       //for super admin, bdm ,bde
                    meta: {
                        title: 'Assign',
                    }
                },
                {
                    path: 'permission',
                    name: 'Permission',
                    component: permission,
                    meta: {
                         title: 'Permission',
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
                }
        },
       
        {
            path: '/dashboard/pageslist/:id',
            name: 'Pages',
            component: pages,
            meta: {
                 title: 'pages',
                }
        },
        {
            path: '/dashboard/task',
            component: task,
            meta: {
                title: 'task',
            },
            children: [
                {
                    path: 'list',
                    component: tasklist,
                    meta: {
                        title: 'task list',
                    }
                },
                {
                    path: 'add',
                    component: taskadd,
                    meta: {
                        title: 'task Add',
                    }
                },
                {
                    path: 'edit/:id',
                    component: taskedit,
                    meta: {
                        title: 'task Edit',
                    }
                },
                {
                    path: 'detail/:id',
                    component: taskdetail,
                    meta: {
                        title: 'task detail',
                    }
                },
            ]
        },
        

        {
            path: '/dashboard/document',
            component: document,
            meta: {
                title: 'Docuemnt',
            },
            children: [
                {
                    path: 'add',
                    component: documentadd,
                    meta: {
                        title: 'Document',
                    }
                },
              
              
            ]
        },

    

    
       
    
       


      
 
        

        
        

       ]
})