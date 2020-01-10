<template>
    <div>
        <!-- alert error message -->        
        <div  v-if="errorMessage.length > 0" class="alert message_alert alert-danger alert-dismissible fade in">
            <a class="close" data-dismiss="alert" aria-label="close" @click="emptyMessage">&times;</a>
            <strong v-for="(er,index) in errorMessage" :key="index" > {{ er }} </strong>
        </div>
        <!-- alert success message -->
        <div v-if="successMessage.length > 0" class="alert message_alert alert-success alert-dismissible fade in">
            <a class="close" data-dismiss="alert" aria-label="close" @click="emptyMessage">&times;</a>
            <strong v-for="(ss,index) in successMessage" :key="index" > {{ ss }} </strong>
        </div>

       <div class="header-area">
            <div class="container">
                <div class="">
                    <div class="social_icon">
                        <ul>
                            <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" title="Google Plus"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="#" title="Linked In"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    <div class="top_header_menu">
                        <div class="user-menu">
                            <ul>
                                <li class="dropdown">
                                    <router-link  to="#" ><i class="fas fa-language"> </i> {{ $i18n.locale == 'ar' ? $t('arabic') : $t('english')   }}  <img src="/ecommerce/img/down_arrow.png" alt="" title="" class="down_arrow"></router-link>
                                    <ul class="dropdown-menu">
                                        <li><a @click="setLocale('en')">{{ $t('english') }}</a></li>
                                        <li><a @click="setLocale('ar')">{{ $t('arabic') }}</a></li> 
                                    </ul>
                                </li>
                                <!-- <li class="dropdown">
                                    <router-link  to="#" ><i class="fas fa-dollar-sign"></i> USD <img src="/ecommerce/img/down_arrow.png" alt="" title="" class="down_arrow"></router-link>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fas fa-dollar-sign"></i> USD </a></li>
                                        <li><a href="#"><i class="fas">د.إ </i> AED </a></li>
                                    </ul>
                                </li> -->
                                <li class="dropdown">
                                    <router-link  to="#" ><i class="fa fa-user"></i> {{ $t('myAccount') }} <img src="/ecommerce/img/down_arrow.png" alt="" title="" class="down_arrow"></router-link>
                                    <ul class="dropdown-menu">
                                        <li v-if="!isLogin" @click="showModal(1)"><a ><i class="fas fa-lock"></i> {{ $t('login') }}</a></li>
                                        <li v-if="!isLogin" @click="showModal(2)"><a ><i class="fas fa-user-plus"></i> {{ $t('register') }}</a></li>
                                        <li v-if="!isLogin" @click="showModal(3)"><a ><i class="fas fa-lock"></i> {{ $t('forgotPassword') }}</a></li>
                                        <li v-if="isLogin" ><router-link  v-if="isLogin" to="/myAccount"><i class="fa fa-user"></i> {{ $t('myAccount') }}</router-link></li>
                                        <li v-if="isLogin" @click="logOut"><a ><i class="fas fa-sign-out-alt"></i> {{ $t('logOut') }}</a></li> 
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End header area -->
        <div id="example-modal">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div id="msform">
                            {{validationErrors.length}}
                        <div v-if="validationErrors.length > 0">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in validationErrors" :key="index">@{{ value }}</li>
                            </ul>
                        </div>
                        <fieldset class="login_form">
                            <h2><img src="/ecommerce/img/logo.png" alt=" " title=""></h2>
                            <h2 v-if="signUp == 1" class="fs-title">{{ $t('login') }}</h2>
                            <h2 v-if="signUp == 2" class="fs-title">{{ $t('register') }}</h2>
                            <h2 v-if="signUp == 3" class="fs-title">{{ $t('forgotPassword') }}</h2>
                            <div v-if="signUp == 2">
                                <div class="form-group">
                                    <label for="phone_id" class="control-label">{{ $t('firstName') }}</label>
                                    <input type="text" name="firstname" :placeholder="$t('firstName')" data-vv-name="firstname" data-vv-as="First Name" v-validate="'required'"  :class="{'alert-danger': errors.has('firstname')}" v-model="firstName" />
                                </div>
                                <!-- <span>{{ errors.first('firstname') }}</span> -->
                                <div class="form-group">
                                    <label for="phone_id" class="control-label">{{ $t('lastName') }}</label>
                                    <input type="text" name="lname" :placeholder="$t('lastName')"  data-vv-name="lastName" v-validate="'required'"  :class="{'alert-danger': errors.has('lastName')}" v-model="lastName" />
                                </div>
                                <div class="form-group">
                                    <label for="phone_id" class="control-label">{{ $t('mobile') }}</label>
                                    <input type="text" name="phone" :placeholder="$t('mobile')"  data-vv-name="phone" v-validate="'required|numeric'"  :class="{'alert-danger': errors.has('phone')}" v-model="mobileNumber" />
                                </div>
                            </div>
                            <div class="form-group" v-if="signUp != 3">
                                <label for="phone_id" class="control-label">{{ $t('email') }}</label>
                                <input type="email" name="emails" :placeholder="$t('email')"  data-vv-name="email" v-validate="'required|email'"  :class="{'alert-danger': errors.has('email')}" @keyup.enter="userLogin" v-model="email" />
                            </div>
                            <div class="form-group" v-if="signUp != 3">
                                <label for="phone_id" class="control-label">{{ $t('password') }}</label>
                                <input type="password" name="passwords" :placeholder="$t('password')" data-vv-name="password" v-validate="'required'"  :class="{'alert-danger': errors.has('password')}" ref="password" @keyup.enter="userLogin" v-model="password" />
                            </div>
                            
                            <div class="form-group" v-if="signUp == 3" >
                                <label for="phone_id" class="control-label">{{ $t('email') }}</label>
                                <input type="email" name="emails" :placeholder="$t('email')"  data-vv-name="email" v-validate="'required|email'"  :class="{'alert-danger': errors.has('email')}" @keyup.enter="userLogin" v-model="forgotEmail" />
                            </div>

                             <div class="form-group">
                                <label v-if="signUp == 2" for="phone_id" class="control-label">{{ $t('confirmPassowrd') }}</label>
                                <input type="password" name="password" :placeholder="$t('confirmPassowrd')" v-if="signUp == 2" data-vv-name="confirmPassowrd" v-validate="'required|confirmed:password'"  :class="{'alert-danger': errors.has('confirmPassowrd')}" v-model="confirmPassword" />
                            </div>
                            <div class="form-group">
                                <label v-if="signUp == 2" for="phone_id" class="control-label">{{ $t('countryCode') }}</label> 
                                <select name="country" id=""  v-if="signUp == 2" v-model="countryCode">
                                    <option v-for="(count, index) in country" :key="index" :value="count.dial_code" :selected="count.dial_code == 971">  {{ count.dial_code }} - {{ count.name }}</option>
                                </select>
                             </div>
                            <!-- <input v-if="signUp == true" type="button" name="next" class="next action-button" :value="$t('login')" @click="userLogin" />

                            <input v-else type="button" name="next" class="next action-button" :value="$t('register')" @click="userLogin" /> -->
                            <div class="shipping_btn">
                                <button v-if="signUp == 3" type="button" class="" @click="userLogin">{{ $t('sendPasswordResetLink') }}</button>
                                <button type="button" class="" v-if="signUp == 1" @click="userLogin">{{ $t('login') }}</button>

                                <button v-if="signUp == 2" type="button" name="next" @click="userLogin">{{ $t('register') }}</button>
                                    <a @click="signUp = 2" v-if="signUp == 1">{{ $t('register') }}</a>
                                            <a @click="signUp = 1" v-if="signUp == 2">{{ $t('login') }}</a>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions  } from 'vuex'
export default {
    computed: {
        ...mapState([
            'getLocale',
            'isLogin',
            'errorMessage',
            'successMessage',
            'country',

        ]),
    },
    data (){
        return {
            signUp: 1,
            firstName: '',
            lastName: '',
            email: '',
            password: '',
            confirmPassword: '',
            countryCode: 971,
            mobileNumber: '',
            forgotEmail: '',
            forgetPass: false,
            validationErrors: [],
        }
    },
    mounted() {
        if(this.$session.has('locale')) this.setLocale(this.$session.get('locale'));
    },
    methods: {
        ...mapActions([
            'ACTION_SET_LOCALE',
            'ACTION_IS_LOGIN',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
            'ACTION_NULL_MESSAGES',
            'ACTION_CHANGE_RTL',
        ]),
        setLocale (lang) {
            // Set language
            this.$session.set('locale', lang)
            this.$i18n.locale = lang
            this.$validator.locale = lang;
            if (lang == 'ar') {
                this.ACTION_CHANGE_RTL('rtl')
            } else {
                this.ACTION_CHANGE_RTL('ltr')
            }
            this.ACTION_SET_LOCALE(lang)
        },
        logOut () {
            this.$session.clear();
            this.checkLogin()
            this.$router.push('/')
            location.reload();
        },
        showModal(value) {
            // open login model
            this.signUp = value;
            $('#exampleModal').modal('show')
        },
        showModalForgot () {
            $('#forgotPasswordModal').modal('show')
        },
        userLogin () {
            if (this.signUp == 1) {
                this.$validator.validateAll().then(result => {
                    if(result) {
                        axios.post('/api/login', {
                            email: this.email,
                            password: this.password,
                        })
                        .then (response => {
                            var access = 'Bearer ' + response.data.accessToken
                            this.$session.set('accessToken', access)
                            this.$session.set('isLogin', true)
                            this.checkLogin() // call parent function to set login variable
                            $('#exampleModal').modal('hide')
                            location.reload(); // For reload windows
                        })
                        .catch (errorResponse => {
                            this.ACTION_PUSH_ERROR(errorResponse.response.data.message)
                        })
                    }
                })
            } else {
                if(this.signUp == 2) {
                    // register user
                    this.register()
                } else {
                    this.forgotPassword()
                }
            }
        },
        checkLogin () {
            if(this.$session.has('isLogin') && this.$session.get('isLogin') == true) {
                this.ACTION_IS_LOGIN(true)
            } else {
                this.ACTION_IS_LOGIN(false)
            }
        },
        emptyMessage () {
            this.ACTION_NULL_MESSAGES()
        },
        register () {
            this.$validator.validateAll().then(result => {
                if(result) {
                    axios.post('/api/users', {
                        first_name: this.firstName,
                        last_name: this.lastName,
                        email: this.email,
                        password: this.password,
                        confirm_password: this.confirmPassword,
                        country_code: this.countryCode,
                        mobile_number: this.mobileNumber,
                    })
                    .then (response => {
                        var access = 'Bearer ' + response.data.accessToken
                        this.$session.set('accessToken', access)
                        this.$session.set('isLogin', true)
                        this.checkLogin() // call parent function to set login variable
                        $('#exampleModal').modal('hide')
                        location.reload(); // For reload windows
                    })
                    .catch (errorResponse => {
                        if (errorResponse.response.status == 422){
                            this.validationErrors = errorResponse.response.data.errors;
                            if (this.validationErrors.email) {
                                this.ACTION_PUSH_ERROR(this.validationErrors.email[0])
                            }
                        }
                    })
                }
            });
        },
        forgotPassword () {
            // this.$validator.validateAll().then(result => {
            //     if(result) {
                    axios.post('/api/password/create', {
                        email: this.forgotEmail,
                    })
                    .then (response => {
                        $('#exampleModal').modal('hide')
                        this.ACTION_PUSH_SUCCESS(this.$t('emailPasswordLink'))
                        document.getElementById('close').click();
                    })
                    .catch (errorResponse => {
                        this.ACTION_PUSH_ERROR(this.$t('email') + ' ' + this.$t(''))
                    })
            //     }
            // })
        }
    }
}
</script>

<style>

</style>
