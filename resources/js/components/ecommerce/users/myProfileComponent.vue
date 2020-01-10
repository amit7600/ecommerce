<template>
	<div>
        <h2 class="fs-title">
            <img src="/ecommerce/img/title_icon1.png" alt="" title=""> 
             {{ $t('myProfile') }}
            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
        </h2>
        <form @submit.prevent="onSubmit">
            <div class="my_profile">
                <div class="form-group">
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('firstName') }}</label>
                        <input type="text" name="firstname" v-model="first_name" data-vv-name="firstname" :class="{'alert-danger': errors.has('firstname')}" v-validate="'required'" class="form-" :placeholder="$t('firstName')">
                    </div>
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('lastName') }}</label>
                        <input type="text" name="lastName" v-model="last_name" data-vv-name="lastName" :class="{'alert-danger': errors.has('lastName')}" v-validate="'required'" class="form-" :placeholder="$t('lastName')">
                    </div>
                </div>
                <div class="form-group">
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('email') }}</label>
                        <input type="text" name="email" v-model="email" class="form-" data-vv-name="email" :class="{'alert-danger': errors.has('email')}" v-validate="'required'" :placeholder="$t('email')" readonly>
                    </div>
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('mobile') }}</label>
                        <input type="text" name="mobile" v-model="mobile_number" data-vv-name="mobile" :class="{'alert-danger': errors.has('mobile')}" v-validate="'required'" class="form-" :placeholder="$t('mobile')">
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <label for="phone_id" class="control-label">{{ $t('countryCode') }}</label>
                        <select name="country" id="country"  v-if="!signUp " data-vv-name="country" :class="{'alert-danger': errors.has('country')}" v-validate="'required'" v-model="countryCode">
                            <option v-for="(count, index) in country" :key="index" :value="count.dial_code" :selected="count.dial_code == 971">  {{ count.dial_code }} - {{ count.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group my_acount_btn">
                    <button type="submit" class="btn_account">{{ $t('update') }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";
export default {
    computed: {
        ...mapState([
            'country'
        ]),
    },
    data () {

        return {
            signUp: false,
            countryCode: '',
            first_name: '',
            last_name: '',
            email: '',
            mobile_number:'',
        }
    },
    created(){
        this.userData();
        this.ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS('myAccount')
    },
    methods:{
        ...mapActions([
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
            'ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS',
        ]),
        onSubmit(){

            this.$validator.validateAll().then(result =>{
                if(result){
                    axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
                    axios.post('/api/myProfileUpdate',{
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email: this.email,
                        mobile_number: this.mobile_number,
                        country_code : this.countryCode
                    }).then(response => {
                        this.ACTION_PUSH_SUCCESS(this.$t('profileUpdatedSuccessfully'))
                        this.userData();
                    }).catch(error => {
                        console.log(error)
                    })
                }
            })
        },
        userData(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.get('/api/userData')
            .then(response => {
                this.first_name =  response.data.data.first_name;
                this.last_name =  response.data.data.last_name;
                this.email = response.data.data.email;
                this.mobile_number = response.data.data.mobile_number;
                this.countryCode = response.data.data.country_code;
            })
        },
    }

}
</script>

<style>

</style>
