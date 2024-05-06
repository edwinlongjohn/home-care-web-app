<template>

    <div class="breadcumb-wrapper" data-bg-src="/assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Phone Verification</h1>
                <ul class="breadcumb-menu">
                    <li><router-link :to="{name:'home'}"></router-link> Home</li>
                    <li>phone verification</li>
                </ul>
            </div>
        </div>
    </div>
   
    <div class="space-bottom">
        <div class="container">
            <form @submit.prevent="HandlePhoneCode" 
                class="contact-form " data-bg-src="/assets/img/bg/contact_form_bg.png">
                <div class="input-wrap">
                    <h2 class="sec-title">Enter Sms Pin</h2>
                    <div class="row">
                        <div class="form-group col-12"><input type="text" class="form-control" v-model="phone_code" id="name"
                                placeholder="Your Name"> <i class="fal fa-user"></i></div>
                       
                        <div class="form-btn col-12"><button class="th-btn btn-fw">Submit Code</button></div>
                    </div>
                  
                </div>
            </form>
        </div>
    </div>
  
</template>

<script setup>

</script>




