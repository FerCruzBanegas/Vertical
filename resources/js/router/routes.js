import Layout from '../layout/Layout.vue'
import Login from '../views/auth/Login.vue'
import Dashboard from '../views/dashboard/Dashboard.vue'
import Report from '../views/report/Report.vue'
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
//profile
import ListProfiles from '../views/profile/ListProfiles.vue'
import FormProfile from '../views/profile/FormProfile.vue'
//user
import ListUsers from '../views/user/ListUsers.vue'
import FormUser from '../views/user/FormUser.vue'
import Password from '../views/user/Password.vue'

import NotFoundComponent  from '../components/404.vue'
import DeniedComponent  from '../components/403.vue'

export default [
  {
    path: '/',
    name: 'Home',
    component: Layout,
    redirect: '/dashboard',
    meta: { requiresAuth: true },
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
      },
      {
        path: '/reports',
        name: 'Report',
        component: Report,
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
            component: ListProjectTypes,
            meta: {
              AccessControlList: 'project-types.index',
            }
          },
          {
            path: 'create',
            name: 'CreateProjectType',
            component: FormProjectType,
            meta: {
              AccessControlList: 'project-types.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditProjectType',
            component: FormProjectType,
            meta: {
              AccessControlList: 'project-types.update',
            }
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
            component: ListProjects,
            meta: {
              AccessControlList: 'projects.index',
            }
          },
          {
            path: 'create',
            name: 'CreateProject',
            component: FormProject,
            meta: {
              AccessControlList: 'projects.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditProject',
            component: FormProject,
            meta: {
              AccessControlList: 'projects.update',
            }
          },
          {
            path: ':id/show',
            name: 'ShowProject',
            component: ShowProject,
            meta: {
              AccessControlList: 'projects.show',
            }
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
            component: ListMaterialTypes,
            meta: {
              AccessControlList: 'material-types.index',
            }
          },
          {
            path: 'create',
            name: 'CreateMaterialType',
            component: FormMaterialType,
            meta: {
              AccessControlList: 'material-types.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditMaterialType',
            component: FormMaterialType,
            meta: {
              AccessControlList: 'material-types.update',
            }
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
            component: ListMaterials,
            meta: {
              AccessControlList: 'materials.index',
            }
          },
          {
            path: 'create',
            name: 'CreateMaterial',
            component: FormMaterial,
            meta: {
              AccessControlList: 'materials.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditMaterial',
            component: FormMaterial,
            meta: {
              AccessControlList: 'materials.update',
            }
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
            component: ListIncomeTypes,
            meta: {
              AccessControlList: 'income-types.index',
            }
          },
          {
            path: 'create',
            name: 'CreateIncomeType',
            component: FormIncomeType,
            meta: {
              AccessControlList: 'income-types.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditIncomeType',
            component: FormIncomeType,
            meta: {
              AccessControlList: 'income-types.update',
            }
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
            component: ListIncomes,
            meta: {
              AccessControlList: 'incomes.index',
            }
          },
          {
            path: 'create',
            name: 'CreateIncome',
            component: FormIncome,
            meta: {
              AccessControlList: 'incomes.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditIncome',
            component: FormIncome,
            meta: {
              AccessControlList: 'incomes.update',
            }
          },
          {
            path: ':id/show',
            name: 'ShowIncome',
            component: ShowIncome,
            meta: {
              AccessControlList: 'incomes.show',
            }
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
            component: ListExpenseTypes,
            meta: {
              AccessControlList: 'expense-types.index',
            }
          },
          {
            path: 'create',
            name: 'CreateExpenseType',
            component: FormExpenseType,
            meta: {
              AccessControlList: 'expense-types.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditExpenseType',
            component: FormExpenseType,
            meta: {
              AccessControlList: 'expense-types.update',
            }
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
            component: ListExpenses,
            meta: {
              AccessControlList: 'expenses.index',
            }
          },
          {
            path: 'create',
            name: 'CreateExpense',
            component: FormExpense,
            meta: {
              AccessControlList: 'expenses.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditExpense',
            component: FormExpense,
            meta: {
              AccessControlList: 'expenses.update',
            }
          },
          {
            path: ':id/show',
            name: 'ShowExpense',
            component: ShowExpense,
            meta: {
              AccessControlList: 'expenses.show',
            }
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
            component: ListPeople,
            meta: {
              AccessControlList: 'people.index',
            }
          },
          {
            path: 'create',
            name: 'CreatePeople',
            component: FormPeople,
            meta: {
              AccessControlList: 'people.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditPeople',
            component: FormPeople,
            meta: {
              AccessControlList: 'people.update',
            }
          }
        ]
      },
      {
        path: '/profiles',
        name: 'Profiles',
        redirect: '/profiles',
        component: {
          render (c) { return c('router-view') }
        },
        children: [
          {
            path: '',
            name: 'ListProfiles',
            component: ListProfiles,
            meta: {
              AccessControlList: 'profiles.index',
            }
          },
          {
            path: 'create',
            name: 'CreateProfile',
            component: FormProfile,
            meta: {
              AccessControlList: 'profiles.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditProfile',
            component: FormProfile,
            meta: {
              AccessControlList: 'profiles.update',
            }
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
            component: ListUsers,
            meta: {
              AccessControlList: 'users.index',
            }
          },
          {
            path: 'create',
            name: 'CreateUser',
            component: FormUser,
            meta: {
              AccessControlList: 'users.create',
            }
          },
          {
            path: ':id/edit',
            name: 'EditUser',
            component: FormUser,
            meta: {
              AccessControlList: 'users.update',
            }
          },
          {
            path: ':id/password',
            name: 'Password',
            component: Password,
            meta: {
              AccessControlList: 'users.update',
            }
          }
        ]
      },
    ]
  },
  {
    path: '/login', 
    name: 'Login', 
    component: Login, 
    meta: { 
      redirectIfLogged: true 
    } 
  },
  { path: '*', component: NotFoundComponent  },
  { path: '/unauthorized', name: 'Unauthorized', component: DeniedComponent }
]
