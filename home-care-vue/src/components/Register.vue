<template>
    <div class="breadcumb-wrapper" data-bg-src="/assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Register</h1>
                <ul class="breadcumb-menu">
                    <li>
                        <router-link :to="{name:'home'}">Home</router-link>
                    </li>
                    <li>Register</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="space-bottom">
        <div class="container ">
            <form class="contact-form" @submit.prevent="handleRegisteration" data-bg-src="/assets/img/bg/contact_form_bg.png">
                <div class="input-wrap">
                    <h2 class="sec-title">Register Now</h2>
                    <div class="row">
                        <div class="form-group col-12"><input type="text" class="form-control" v-model="form.full_name"
                                id="name" placeholder="Your Name"> <i class="fal fa-user"></i></div>
                        <div class="form-group col-12"><input type="email" class="form-control" v-model="form.email"
                                id="email" placeholder="Email Address"> <i class="fal fa-envelope"></i></div>
                        <div class="form-group col-12"><select v-model="form.country" id="subject" class="form-select">
                                <option value="" disabled="disabled" selected="selected">Select Country</option>
                                <option v-for="(country, index) in countries" :key="index" class="text-dark"  :value="{id:country.id, phonecode:country.phonecode}">{{country.name}} phone-code:{{country.phonecode}}</option>
                               
                            </select> <i class="fal fa-chevron-down"></i>
                        </div>
                        <div class="form-group col-12">
                            <label for="number"><span class="text-success" v-if="form.country">{{form.country.phonecode}}</span></label>
                            <input type="tel" class="form-control" v-model="form.phone_number"
                                id="number" placeholder="start with phone code above e.g 2349018096086"> <i class="fal fa-phone mt-2"></i>
                        </div>
                        <div class="form-group col-12"><select v-model="form.user_type" id="type" class="form-select">
                                <option value="" disabled="disabled" selected="selected" >Select User Type
                                </option>
                                <option value="client">Client</option>
                                <option value="home_care_worker">Home Care Worker</option>
                            </select> <i class="fal fa-chevron-down"></i></div>
                        <div class="form-group col-12"><select v-model="form.verification_type" id="verification"
                                class="form-select">
                                <option value="" disabled="disabled" selected="selected" >How do you want to be
                                    verified?</option>
                                <option value="phone">Phone Number</option>
                                <option value="email">Email</option>
                            </select> <i class="fal fa-chevron-down"></i></div>

                        <div class="form-group col-12"><input type="password" class="form-control" v-model="form.password"
                                id="password" placeholder="Password"> <i class="fal fa-eye"></i></div>
                        <div class="form-group col-12"><input type="password" class="form-control" v-model="form.password_confirmation"
                                id="confirm_password" placeholder="Confirm password"> <i class="fal fa-eye"></i></div>
                        <div class="form-btn col-12"><button class="th-btn btn-fw ">{{form.loading ? 'processing' : 'Register'}}</button></div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </div>
            </form>
        </div>
    </div>

</template>

<script setup>
    import {
        ref,
        onMounted
    } from 'vue';
    import { useRouter } from 'vue-router';
    
    const router = useRouter();
    import axios from 'axios';
    const countries = ref();
    const form = ref({
        loading: false,
        email: '',
        full_name: '',
        user_type: '',
        verification_type: '',
        phone_number: '',
        country: '',
        password: '',
        password_confirmation: '',

    })

    onMounted(async () => {
        const data = await axios.get('/api/countries')
        console.log(data.data.countries);
        countries.value = data.data.countries;
        
        
    });
    const getToken = async () =>{
        await  axios.get('/sanctum/csrf-cookie')
    }
    const handleRegisteration = async () => {
         form.value.loading = true,
         await getToken();
         await axios.post('/register', {
            email: form.value.email,
            password: form.value.password,
            full_name: form.value.full_name,
            phone: form.value.phone_number,
            verification_type: form.value.verification_type,
            phone: form.value.phone_number,
            password_confirmation: form.value.password_confirmation,
            country_code: form.value.country.id,
            user_type:form.value.user_type,
         }).then((res)=>{
            if(res.data.success){
                //console.log(res.data.user);
               
                const user = res.data.user;
                if(user.verificationType == 'email'){
                    router.push = '/email-code';
                }
                if(user.verificationType == 'phone'){
                    router.push = '/phone-code';
                }
               
            }

         }).catch((err)=>{
            console.log(err);
         }).finally(()=>{
            form.value.loading = false;
         });
         
    }
</script>