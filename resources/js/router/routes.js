import Layout from '../layout/Layout.vue'
import Login from '../views/auth/Login.vue'
import Dashboard from '../views/dashboard/Dashboard.vue'
//project-type
import ListProjectTypes from '../views/project-type/ListProjectTypes.vue'
import FormProjectType from '../views/project-type/FormProjectType.vue'
//project
import ListProjects from '../views/project/ListProjects.vue'
import FormProject from '../views/project/FormProject.vue'
import ShowProject from '../views/project/ShowProject.vue'
//material-type
import ListMaterialTypes from '../views/material-type/ListMaterialTypes.vue'
import FormMaterialType from '../views/material-type/FormMaterialType.vue'
//material
import ListMaterials from '../views/material/ListMaterials.vue'
import FormMaterial from '../views/material/FormMaterial.vue'

export default [
  {
    path: '/',
    name: 'home',
    component: Layout,
    redirect: '/dashboard',
    meta: { requiresAuth: true },
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: '/project-types',
        name: 'ProjectTypes',
        redirect: '/project-types',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListProjectTypes',
            component: ListProjectTypes
          },
          {
            path: 'create',
            name: 'CreateProjectType',
            component: FormProjectType
          },
          {
            path: ':id/edit',
            name: 'EditProjectType',
            component: FormProjectType
          }
        ]
      },
      {
        path: '/projects',
        name: 'Projects',
        redirect: '/projects',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListProjects',
            component: ListProjects
          },
          {
            path: 'create',
            name: 'CreateProject',
            component: FormProject
          },
          {
            path: ':id/edit',
            name: 'EditProject',
            component: FormProject
          },
          {
            path: ':id/show',
            name: 'ShowProject',
            component: ShowProject
          }
        ]
      },
      {
        path: '/material-types',
        name: 'MaterialTypes',
        redirect: '/material-types',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListMaterialTypes',
            component: ListMaterialTypes
          },
          {
            path: 'create',
            name: 'CreateMaterialType',
            component: FormMaterialType
          },
          {
            path: ':id/edit',
            name: 'EditMaterialType',
            component: FormMaterialType
          }
        ]
      },
      {
        path: '/materials',
        name: 'Materials',
        redirect: '/materials',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListMaterials',
            component: ListMaterials
          },
          {
            path: 'create',
            name: 'CreateMaterial',
            component: FormMaterial
          },
          {
            path: ':id/edit',
            name: 'EditMaterial',
            component: FormMaterial
          }
        ]
      },
    ]
  },

  {
    path: '/login', 
    name: 'login', 
    component: Login, 
    meta: { 
      redirectIfLogged: true 
    } 
  }
]
