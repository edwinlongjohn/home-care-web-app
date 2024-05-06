<template>
    <template>
    <div class="breadcumb-wrapper" data-bg-src="/assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="space">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">Central Branch</h3>
                        <p class="footer-info"><i class="far fa-location-dot"></i> 12601 Garden Grove Blvd, Garden
                            Grove, CA 92843</p>
                        <p class="footer-info"><i class="far fa-envelope"></i> <a href="mailto:info@contacthp.com"
                                class="info-box_link">info@contacthp.com</a></p>
                        <p class="footer-info"><i class="far fa-phone"></i> <a href="tel:+17145375160"
                                class="info-box_link">+171 4537 5160</a></p>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon"><i class="far fa-clock"></i></div>
                        <div class="media-body">
                            <h3 class="box-title">Opening Hours</h3>
                            <p class="box-text">Mon to sat: 8:00am - 9:00pm</p>
                            <p class="box-schedule">Sunday - Closed</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card active">
                        <h3 class="box-title">USA. Branch</h3>
                        <p class="footer-info"><i class="far fa-location-dot"></i> 1120 15th St BA 8412, Augusta, GA
                            30912, United States</p>
                        <p class="footer-info"><i class="far fa-envelope"></i> <a href="mailto:info@contacusa.com"
                                class="info-box_link">info@contacusa.com</a></p>
                        <p class="footer-info"><i class="far fa-phone"></i> <a href="tel:+17067218623"
                                class="info-box_link">+170 6721 8623</a></p>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon"><i class="far fa-clock"></i></div>
                        <div class="media-body">
                            <h3 class="box-title">Opening Hours</h3>
                            <p class="box-text">Mon to sat: 8:00am - 9:00pm</p>
                            <p class="box-schedule">Sunday - Closed</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">Australia Branch</h3>
                        <p class="footer-info"><i class="far fa-location-dot"></i> 260 Lygon St, Brunswick East VIC
                            3057, Australia</p>
                        <p class="footer-info"><i class="far fa-envelope"></i> <a href="mailto:info@contactaus.com"
                                class="info-box_link">info@contactaus.com</a></p>
                        <p class="footer-info"><i class="far fa-phone"></i> <a href="tel:+61399882015"
                                class="info-box_link">+613 9988 2015</a></p>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon"><i class="far fa-clock"></i></div>
                        <div class="media-body">
                            <h3 class="box-title">Opening Hours</h3>
                            <p class="box-text">Mon to sat: 8:00am - 9:00pm</p>
                            <p class="box-schedule">Monday - Closed</p>
                        </div>
                    </div>
                </div>
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


</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>