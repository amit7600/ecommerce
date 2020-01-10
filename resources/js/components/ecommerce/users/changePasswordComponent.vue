<template>
	<div>
        <h2 class="fs-title">
            <img src="/ecommerce/img/title_icon1.png" alt="" title=""> 
             {{ $t('changePassword') }}
            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
        </h2>
        <form @submit.prevent="onSubmit">
            <div v-if="errorMessage.length > 0">
                <ul class="alert-danger" v-for="(error, index) in errorMessage" :key="index">
                    <li v-for="(er, index) in error" :key="index"> {{er[0]}} </li>
                </ul>
            </div>
            <div class="my_profile">
                <div class="form-group">
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('oldpassword') }}</label>
                        <input type="password" name="oldpassword" data-vv-name="oldpassword" :class="{'alert-danger': errors.has('oldpassword')}" v-validate="'required'" v-model="old_password" class="form-" :placeholder="$t('oldpassword')">
                    </div>
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('newpassword') }}</label>
                        <input type="password" name="newpassword" data-vv-name="newpassword" :class="{'alert-danger': errors.has('newpassword')}" v-validate="'required'" v-model="password" class="form-" :placeholder="$t('newpassword')">
                    </div>
                </div>
                <div class="form-group">
                    <div class="width_half">
                        <label for="phone_id" class="control-label">{{ $t('confirmPassowrd') }}</label>
                        <input type="password" name="confirmPassowrd" data-vv-name="confirmPassowrd" :class="{'alert-danger': errors.has('confirmPassowrd')}" v-validate="'required'" v-model="password_confirmation" class="form-" :placeholder="$t('confirmPassowrd')">
                    </div>
                </div>
                <div class="form-group my_acount_btn">
                    <button type="submmit" class="btn_account">{{ $t('update') }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";
export default {
    data(){
        return{
            old_password : '',
            password     : '',
            password_confirmation : '',
            errorMessage : []
        }
    },
    created () {
        this.ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS('myChangePass')
    },
    methods:{
        ...mapActions([
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
            'ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS',
        ]),
        onSubmit(){
            this.errorMessage = []
            this.$validator.validateAll().then(result => {
                if(result){
                    axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
                    axios.post('/api/changePassword',{
                        old_password : this.old_password,
                        password : this.password,
                        password_confirmation : this.password_confirmation
                    }).then(response => {
                        if(response.data.success){
                        this.ACTION_PUSH_SUCCESS(response.data.message)
                        this.old_password = '';
                        this.password     = '';
                        this.password_confirmation = '';
                        }else{
                            this.ACTION_PUSH_ERROR(response.data.message)
                        }
                        console.log(response.data)
                        
                    }).catch(error => {
                        console.log(error.response.data.errors)
                        this.errorMessage.push(error.response.data.errors)
                        this.ACTION_PUSH_ERROR(error.response.data.message)
                    })
                }
            })
        }
    }
}
</script>

<style>

</style>
