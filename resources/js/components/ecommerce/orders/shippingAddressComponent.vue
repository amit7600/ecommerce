<template>
   <div> 
     <!-- start of form for shipping adddress -->
     <h2 class="fs-title">
        <img src="/ecommerce/img/title_icon1.png" alt="" title="">
                {{ $t('shippingAddress') }}
        <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
        <button type="button" class="create_btn" @click="resetData" data-toggle="modal" data-target="#myModal">{{$t('create')}}</button>
    </h2>
     <form id="shipping_form" class="shipping_form" @submit.prevent="storeShippingAddress">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $t('createShippingAddress') }}</h4>
                </div>
                <div class="modal-body">
                
                    <div class="fast_last">
                        <div class="form-group"> <!-- Full Name -->
                            <label for="full_name_id1" class="control-label">{{ $t('firstName') }}</label>
                            <input type="text" class="form-control" id="full_name_id1" name="full_name" :placeholder="$t('firstName')" data-vv-name="firstName" v-validate="'required'"  :class="{'alert-danger': errors.has('firstName')}" v-model="firstName"/>
                        </div>	

                        <div class="form-group "> <!-- Full Name -->
                            <label for="full_name_id" class="control-label">{{ $t('lastName') }}</label>
                            <input type="text" class="form-control" id="full_name_id" name="full_name" :placeholder="$t('lastName')" data-vv-name="lastName" v-validate="'required'"  :class="{'alert-danger': errors.has('lastName')}" v-model="lastName"/>
                        </div>
                    </div>

                        <div class="form-group"> <!-- Street 1 -->
                            <label for="street1_id" class="control-label">{{ $t('streetAddress1') }}</label>
                            <input type="text" class="form-control" id="street1_id" name="street1" :placeholder="$t('address')" data-vv-name="address" v-validate="'required'"  :class="{'alert-danger': errors.has('address')}" v-model="address"/>
                            
                        </div>					
                                                
                        <div class="form-group"> <!-- area 2 -->
                            <label for="area_id" class="control-label">{{ $t('streetAddress2') }}</label>
                            <input type="text" class="form-control" id="area_id" name="area"   :placeholder="$t('area')" data-vv-name="area"  v-model="area"/>
                        </div>	
                        <div class="fast_last">
                            <div class="form-group"> <!-- landmark  -->
                                <label for="landmark_id" class="control-label">{{ $t('landmark') }}</label>
                                <input type="text" class="form-control" id="landmark_id" name="landmark" :placeholder="$t('landmark')" v-model="landmark"/>
                            </div>                    
                            <div class="form-group"> <!-- State Button -->
                                <label for="state_id" class="control-label">{{ $t('state') }}</label>
                                <input type="text" class="form-control" id="state_id"  data-vv-name="state" :placeholder="$t('state')"  v-validate="'required'"  :class="{'alert-danger': errors.has('state')}" v-model="state">					
                            </div>
                        </div>  
                        <div class="fast_last">
                            <div class="form-group"> <!-- City-->
                                <label for="city_id" class="control-label">{{ $t('city') }}</label>
                                <input type="text" class="form-control" id="city_id" name="city" :placeholder="$t('city')" data-vv-name="city" v-validate="'required'"  :class="{'alert-danger': errors.has('city')}" v-model="city"/>
                                
                            </div>
                            <div class="form-group"> <!-- address type Button -->
                                <label for="addressType_id" class="control-label">{{ $t('addressType') }}</label>
                            <select  id="addressType_id" data-vv-name="addressType" v-validate="'required'"  :class="{'alert-danger': errors.has('addressType')}" v-model="addressType">
                            <option value="">{{ $t('selectAddressType') }}</option>
                            <option value="home">{{ $t('home') }}</option>
                            <option value="office">{{ $t('office') }}</option>
                            </select>
                            </div>
                        </div>
                        <div class="fast_last">
                            <div class="form-group"> <!-- Zip Code-->
                                <label for="zip_id" class="control-label">{{ $t('pinCode') }}</label>
                                <input type="text" class="form-control" id="zip_id" name="pincode" :placeholder="$t('pinCode')" data-vv-name="pinCode" v-validate="'required'"  :class="{'alert-danger': errors.has('pinCode')}" v-model="pinCode"/>

                            </div>	

                            <div class="form-group"> <!-- phone-->
                                <label for="phone_id" class="control-label">{{ $t('mobile') }}</label>
                                <input type="text" class="form-control" id="phone_id" name="lname" :placeholder="$t('mobile')" data-vv-name="mobile" v-validate="'required'"  :class="{'alert-danger': errors.has('mobile')}" v-model="mobile"/>

                            </div>	
                        </div>  
                        
                           
                        
               
                </div>
                <div class="modal-footer shipping_btn">
                <button type="button" class="btn btn-default" id="close_model" data-dismiss="modal">{{ $t('close') }}</button>
                
                <button type="submit" class=" " :value="$t('save')" v-if="shippingId == ''">{{ $t('save') }}</button>
                
                <button type="submit" class=" "  name="next" :value="$t('save')" v-if="shippingId">{{ $t('update') }}</button>
                       
                </div>
            </div>
            
            </div>
        </div>
    </form>  
       
      <!-- End of form address -->

      <!-- start card detail address -->
      <div>
         <div class="">
          <div class="detail_address_view">
                <div class="item" v-for="(shipp, index) in shippingAddress" :key="index">
                <div class="card">
                    <!-- <div class="pull-right">
                        <button type="button" @click="$parent.addShippingAddress(shipp.id, shipp)" class="btn btn-default btn-read" >
                        {{ $t('add') }}
                        </button>
                        <button type="button" class="btn btn-default btn-read" @click="editShippingAddress(shipp.id)" >
                        {{ $t('edit') }}
                        </button>
                    </div> -->
                    <div class="content_ship_address">
                        <h4> <b> {{ $t('name') }}:</b> <i>{{shipp.first_name}} {{shipp.last_name}}</i> </h4>
                        <h4> <b> {{ $t('address') }} :</b> <i>{{shipp.address}}</i></h4>
                        <h4> <b> {{ $t('city') }} : </b><i>{{shipp.city}}</i></h4>
                        <h4> <b> {{ $t('mobile') }} :</b> <i>{{shipp.mobile_number}}</i></h4>  
                        <h4> <b> {{ $t('addressType') }} :</b> <i>{{shipp.address_type}}</i></h4>
                        <h4> <b> {{ $t('landmark') }} :</b> <i>{{shipp.landmark}}</i></h4>
                        <!-- <h4><b>{{ $t('email') }}:</b> <i>asasasa@gmail.com</i></h4> -->
                    </div>
                        <div class="btn_shipping" v-if="isSaveShippingAddressButtonShow">
                         <button type="button" @click="$parent.addShippingAddress(shipp.id, shipp)" class="btn btn-default btn-read" >
                        {{ $t('save') }} <i class="far fa-save"></i>
                        </button>     
                        </div> 
                        <div class="btn_shipping">
                        <button type="button" class="btn btn-default btn-read" @click="editShippingAddress(shipp.id)" data-toggle="modal" data-target="#myModal">
                        {{ $t('edit') }}   <i class="far fa-edit"></i>
                        </button>
                        </div>
                         <div class="btn_shipping">
                        <button type="button" @click="deleteAddress(shipp.id, index)" class="btn btn-default btn-read" >
                        {{ $t('delete') }} <i class="fas fa-trash-alt"></i>
                        </button>
                        </div>
                </div>
                </div>
            </div>
         </div>  
      </div>
      <!-- End detail address  -->
   </div>
</template>
<script>
   import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
   export default {
       computed: {
           ...mapState([
               'isSaveShippingAddressButtonShow'
           ]),
       },
       data () {
           return {
               firstName: '',
               lastName: '',
               fullName: '',
               mobile: '',            
               address: '',
               area: '',
               landmark: '',
               city: '',
               state: '',
               addressType: '',
               pinCode: '',
               shippingAddress: [],
               create: false,
               shippingId: '',
           }
       },
       mounted () {
           this.getShippingAddress(); // Get shipping adderss
       },
       created () {
           this.ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS('myShipping');
       },
       methods: {
           ...mapActions ([
               'ACTION_PUSH_SUCCESS',
               'ACTION_PUSH_ERROR',
               'ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS',
           ]),
           getShippingAddress () {
               axios.get('/api/shippingAddress', {
                   headers: {
                       Authorization: this.$session.get('accessToken'),
                   }
               })
               .then(response => {
                   this.shippingAddress = response.data.data
                   if(this.shippingAddress.length == 0) {
                       this.create = true
                   }
               })
           },
           storeShippingAddress () {
               if (this.shippingId == '') {
                    this.$validator.validateAll().then(result => {
                        if(result) {
                            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
                            axios.post('/api/shippingAddress', {
                                first_name: this.firstName,
                                last_name: this.lastName,
                                mobile_number: this.mobile,
                                address: this.address,
                                area: this.area,
                                landmark: this.landmark,
                                city: this.city,
                                state: this.state,
                                address_type: this.addressType,
                                pincode: this.pinCode,
                            })
                            .then(response => {
                                this.shippingAddress.push(response.data.data)
                                    this.create = false
                                this.ACTION_PUSH_SUCCESS('Shipping Address stored successfully.')
                                document.getElementById("close_model").click();
                            })
                            .catch(errorResponse => {
                                console.log(errorResponse.response, 'error')
                            })
                        }
                    });
               } else {
                   this.updateShippingAddress();
               }
           },
           editShippingAddress (shippingId) {
               var shippingEdit = this.shippingAddress.find(todo => todo.id === shippingId)
               this.firstName = shippingEdit.first_name
               this.lastName = shippingEdit.last_name
               this.mobile = shippingEdit.mobile_number
               this.address = shippingEdit.address
               this.area = shippingEdit.area
               this.landmark = shippingEdit.landmark
               this.city = shippingEdit.city
               this.state = shippingEdit.state
               this.addressType = shippingEdit.address_type
               this.pinCode = shippingEdit.pincode
               this.shippingId = shippingId
               this.create = true
           },
           updateShippingAddress () {
               this.$validator.validateAll().then(result => {
                   if(result) {
                       axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
                       axios.put('/api/shippingAddress/' + this.shippingId, {
                            first_name: this.firstName,
                            last_name: this.lastName,
                            mobile_number: this.mobile,
                            address: this.address,
                            area: this.area,
                            landmark: this.landmark,
                            city: this.city,
                            state: this.state,
                            address_type: this.addressType,
                            pincode: this.pinCode,
                       })
                       .then(response => {
                           this.shippingAddress = []
                           this.shippingAddress = response.data.data
                           this.ACTION_PUSH_SUCCESS('Shipping Address update successfully.')
                           this.create = false
                           document.getElementById("close_model").click();
                       })
                       .catch(errorResponse => {
                           console.log(errorResponse.response, 'error')
                       })
                   }
               });
           },
           resetData () {
                var shippingEdit = ''
                this.first_name = ''
                this.last_name = ''
                this.mobile = ''
                this.address = ''
                this.area = ''
                this.landmark = ''
                this.city = ''
                this.state = ''
                this.addressType = ''
                this.pinCode = ''
                this.shippingId = ''
           },
           deleteAddress (id, index) {
               
               if (confirm(this.$t('alertDeleteMessage'))) {
                   
                    axios.delete('/api/shippingAddress/' + id, {
                        headers: {
                            Authorization: this.$session.get('accessToken'),
                        }
                    })
                    .then (response => {
                        console.log(response.data)
                        this.shippingAddress.splice(index , 1)
                        this.ACTION_PUSH_SUCCESS(this.$t('shippingAddressDeletedSuceessfully'))
                    })
                    .catch (errorResponse => {
                        console.log(errorResponse, 'errorResponse')
                    })
               }
           },
       }
   }
</script>
<style>
</style>