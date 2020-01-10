import Vue from 'vue';
import Router from 'vue-router';

import HomeComponent from './components/ecommerce/homeComponent.vue';
import CartComponent from './components/ecommerce/orders/cartComponent';
import CheckOutComponent from './components/ecommerce/orders/checkoutComponent';
import OrderSuccessComponent from './components/ecommerce/orders/orderSuccessComponent';
import MyAccountComponent from './components/ecommerce/users/myAccountComponent';
import CategoryComponent from './components/ecommerce/products/categoryComponent';
import SearchComponent from './components/ecommerce/products/searchComponent';
import ProductDetailsComponent from './components/ecommerce/products/productDetailsComponent';
import ChildHomeComponent from './components/ecommerce/includes/childHomeComponent';
import ShippingAddressComponent from './components/ecommerce/orders/shippingAddressComponent';
import MyProfileComponent from './components/ecommerce/users/MyProfileComponent';
import ChangePasswordComponent from './components/ecommerce/users/changePasswordComponent';
import MyOrdersComponent from './components/ecommerce/users/myOrdersComponent';
import OrderDetailComponent from './components/ecommerce/orders/orderDetailComponent';
import SubCategoryComponent from './components/ecommerce/products/subCategoryComponent'



Vue.use(Router)

// export start
export default new Router({
    routes: [
        {
          path: '/',
          component: HomeComponent,
          children: [
            {
              path: '/',
              name: 'ChildHomeComponent',
              component: ChildHomeComponent
            },
            {
              path: '/cart',
              name: 'CartComponent',
              component: CartComponent
            },
            {
              path: '/checkout',
              name: 'CheckOutComponent',
              component: CheckOutComponent,
            },
            {
              path: '/orderSuccess',
              name: 'OrderSuccessComponent',
              component: OrderSuccessComponent,
            },
            {
              path: '/myAccount',
              // name: 'MyAccountComponent',
              component: MyAccountComponent,
              children: [
                {
                  path: '/myAccount',
                  name: 'MyProfileComponent',
                  component: MyProfileComponent,
                },
                {
                  path: 'shippingAddress',
                  name: 'ShippingAddressComponent',
                  component: ShippingAddressComponent,
                },
                {
                  path: 'changePassword',
                  name: 'ChangePasswordComponent',
                  component: ChangePasswordComponent,
                },
                {
                  path: 'myOrders',
                  name: 'MyOrdersComponent',
                  component: MyOrdersComponent,
                },
                {
                  path: 'orderDetails/:id',
                  name: 'OrderDetailComponent',
                  component: OrderDetailComponent,
                }

              ]

            },
            {
              path: '/categories',
              name: 'CategoryComponent',
              component: CategoryComponent,
            },
            {
              path: '/categories/:id',
              name: 'SubCategoryComponent',
              component: SubCategoryComponent,
            },
            {
              path: '/product-details/:id',
              name: 'ProductDetailsComponent',
              component: ProductDetailsComponent,
            },
            {
              path: '/search/:id',
              name: 'SearchComponent',
              component: SearchComponent,
            },
          ]
        },
        
    ],
    mode: 'history',
})
// export end