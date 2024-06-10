<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/66459c57981b6c564770f1af/1htvuldml';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
    <!--End of Tawk.to Script-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .social-media-section {
        background-color: #09473c;
        position: sticky;
        top: 0;
        z-index: 1020; /* Ensure it stays on top */
        padding: 20px 0; /* Increased vertical padding */
    }
    .social-media-section .social-icons,
    .social-media-section .auth-buttons {
        display: flex;
        align-items: center;
    }
    .social-media-section .social-icons a {
        color: white;
        margin-right: 15px;
    }
    .social-media-section .auth-buttons button {
        margin-left: 15px;
        background-color: #fff;
        color: #09473c;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
</style>

@if($pageName == 'foodOrder' || $pageName == 'hairOrder')
<style type="text/css">
    .navbar {
        margin-top: 55px; /* Adjust margin-top to push the menu down */
    }
</style>
@else
<style type="text/css">
    .navbar {
        margin-top: 85px; /* Adjust margin-top to push the menu down */
    }
</style>
@endif

<!-- Social Media Section -->
<div class="social-media-section" id="topnav-menu" style="border-bottom: 1px solid #fff">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="social-icons">
            <a href="mailto:afroservesall.gmail.com" target="_blank" class="text-white">
                <i class="fas fa-envelope"></i>
            </a>
            @if($pageName != 'hair' && $pageName != 'hairOrder')
            <a href="https://www.instagram.com/Ounjexpress" target="_blank" class="text-white">
                <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if($pageName != 'food' && $pageName != 'foodOrder')
            <a href="https://www.instagram.com/thetravellingafrohairdresser" target="_blank" class="text-white">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.tiktok.com/@Dtravelingafrohairdreser" target="_blank" class="text-white">
                <i class="fab fa-tiktok"></i>
            </a>
            @endif
        </div>
        <div class="auth-buttons">
            @if($pageName != 'hairOrder' && $pageName != 'foodOrder')
            <a href="{{ url('/customer') }}" class="btn btn-outline-light waves-effect btn-label waves-light mx-2 my-2 ms-lg-2"><i class="mdi mdi-login label-icon"></i> Login</a>
            <a href="{{ url('/customer/register') }}" class="btn btn-outline-warning waves-effect btn-label waves-light mx-2 my-2 ms-lg-2"><i class="mdi mdi-account-plus label-icon"></i> Register</a>
            @endif
        </div>
    </div>
</div>
