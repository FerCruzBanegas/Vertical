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
//income-type
import ListIncomeTypes from '../views/income-type/ListIncomeTypes.vue'
import FormIncomeType from '../views/income-type/FormIncomeType.vue'
//income
import ListIncomes from '../views/income/ListIncomes.vue'
import FormIncome from '../views/income/FormIncome.vue'
import ShowIncome from '../views/income/ShowIncome.vue'
//expense-type
import ListExpenseTypes from '../views/expense-type/ListExpenseTypes.vue'
import FormExpenseType from '../views/expense-type/FormExpenseType.vue'
//expense
import ListExpenses from '../views/expense/ListExpenses.vue'
import FormExpense from '../views/expense/FormExpense.vue'
import ShowExpense from '../views/expense/ShowExpense.vue'
//people
import ListPeople from '../views/people/ListPeople.vue'
import FormPeople from '../views/people/FormPeople.vue'
//user
import ListUsers from '../views/user/ListUsers.vue'
import FormUser from '../views/user/FormUser.vue'

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
      {
        path: '/income-types',
        name: 'IncomeTypes',
        redirect: '/income-types',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListIncomeTypes',
            component: ListIncomeTypes
          },
          {
            path: 'create',
            name: 'CreateIncomeType',
            component: FormIncomeType
          },
          {
            path: ':id/edit',
            name: 'EditIncomeType',
            component: FormIncomeType
          }
        ]
      },
      {
        path: '/incomes',
        name: 'Incomes',
        redirect: '/incomes',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListIncomes',
            component: ListIncomes
          },
          {
            path: 'create',
            name: 'CreateIncome',
            component: FormIncome
          },
          {
            path: ':id/edit',
            name: 'EditIncome',
            component: FormIncome
          },
          {
            path: ':id/show',
            name: 'ShowIncome',
            component: ShowIncome
          }
        ]
      },
      {
        path: '/expense-types',
        name: 'ExpenseTypes',
        redirect: '/expense-types',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListExpenseTypes',
            component: ListExpenseTypes
          },
          {
            path: 'create',
            name: 'CreateExpenseType',
            component: FormExpenseType
          },
          {
            path: ':id/edit',
            name: 'EditExpenseType',
            component: FormExpenseType
          }
        ]
      },
      {
        path: '/expenses',
        name: 'Expenses',
        redirect: '/expenses',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListExpenses',
            component: ListExpenses
          },
          {
            path: 'create',
            name: 'CreateExpense',
            component: FormExpense
          },
          {
            path: ':id/edit',
            name: 'EditExpense',
            component: FormExpense
          },
          {
            path: ':id/show',
            name: 'ShowExpense',
            component: ShowExpense
          }
        ]
      },
      {
        path: '/people',
        name: 'People',
        redirect: '/people',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListPeople',
            component: ListPeople
          },
          {
            path: 'create',
            name: 'CreatePeople',
            component: FormPeople
          },
          {
            path: ':id/edit',
            name: 'EditPeople',
            component: FormPeople
          }
        ]
      },
      {
        path: '/users',
        name: 'Users',
        redirect: '/users',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListUsers',
            component: ListUsers
          },
          {
            path: 'create',
            name: 'CreateUser',
            component: FormUser
          },
          {
            path: ':id/edit',
            name: 'EditUser',
            component: FormUser
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
