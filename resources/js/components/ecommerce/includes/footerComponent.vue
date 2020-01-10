<template>
    <div>
        <div class="footer-top-area">
            <div class="container">
                <div class="row">
                    <div class="footer_colum">
                        <div class="footer-about-us">
                            <img src="/ecommerce/img/logo_footer.png" alt="" title="">
                            <p>Lorem ipsum dolor amet cons adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                            <div class="footer-social">
                                <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" target="_blank" title="Google Plus"><i class="fab fa-google-plus-g"></i></a>
                                <a href="#" target="_blank" title="Linked In"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer_colum">
                        <div class="footer-menu">
                            <h2 class="footer-wid-title">
                                <img src="/ecommerce/img/f_title_icon.png" alt="" title=""> &nbsp;  
                                {{ $t('menu') }} &nbsp;
                                <img src="/ecommerce/img/f_title_icon_mirror.png" alt="" title="">
                            </h2>
                            <ul>
                                <li><a href="#">{{ $t('home') }}</a></li>
                                <li><a href="#">{{ $t('about') }}</a></li>
                                <li><a href="#">{{ $t('dryFruits') }}</a></li>
                                <li><a href="#">{{ $t('snacks') }}</a></li>
                                <li><a href="#">{{ $t('contactUs') }}</a></li>
                            </ul>                        
                        </div>
                    </div>
                    
                    <div class="footer_colum">
                        <div class="footer-menu">
                            <h2 class="footer-wid-title">
                                <img src="/ecommerce/img/f_title_icon.png" alt="" title=""> &nbsp;  
                                {{ $t('contactInfo') }} &nbsp;
                                <img src="/ecommerce/img/f_title_icon_mirror.png" alt="" title="">
                            </h2>
                            <ul class="contact-info">
                                <li> <i class="fas fa-location-arrow icon-footer"></i><a href="#">205 Lorem ipsum,<br/>Herba Street Front USA</a></li>
                               <li>  <i class="fas fa-phone icon-footer"></i><a href="#">foodinfo@gmail.com</a></li>
                               <li>  <i class="far fa-envelope icon-footer"></i><a href="#">120-452-12356</a></li>
                            </ul>                        
                        </div>
                    </div>
                    
                    <!-- <div class="footer_colum">
                        <div class="footer-newsletter">
                            <h2 class="footer-wid-title"><img src="/ecommerce/img/f_title_icon.png" alt="" title=""> &nbsp;  
                               Newsletter &nbsp;
                                <img src="/ecommerce/img/f_title_icon_mirror.png" alt="" title=""></h2>
                            <p>Enter your email and we’ll send you latest information plans.</p>
                            <div class="newsletter-form">
                                <form action="#">
                                    <input type="email" placeholder="Enter Your Email">
                                    <input type="submit" value="Send">
                                </form>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div> <!-- End footer top area -->
        
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="copyright">
                        <p>{{ $t('copyRight') }} &copy; {{ $t('allRightReserved') }}</p>
                    </div>
                     <div class="site_by">
                        <p>{{ $t('designAndDeveloperdBy') }}: <a href="http://www.d9ithub.com" target="_blank">D9ithub Software Solutions</a></p>
                    </div>
                </div>
            </div>
        </div> <!-- End footer bottom area -->
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
