
<div class="foot" style="position: absolute; bottom: 0; width:100%">
Design & Developed by: <a href="https://www.appventurez.com/" target="_blank"><strong style="color:#007BFF;">Appventurez</strong><strong> Mobitech</strong> Pvt. Limited</a> through <a href="https://www.dgmhup.gov.in/" target="_blank"><strong>DGMHUP</strong></a> . This portal is maintained &amp; managed by <strong>IT Cell DGMHUP,</strong> Uttar Pradesh.
</div>
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- <script>
        $(document).ready(function () {
            $("#showlogin").click(function () {
                $("#login").toggle('show');
                $("#registration").toggle('hide');

            });
            $("#showregister").click(function () {
                $("#registration").toggle('show');
                $("#login").toggle('hide');

            });

        });
    </script> -->
    <script>
        function reset(){
            var element = document.getElementById("login-form");
            element.reset()
        }
        function validateForm(){
            let email=document.getElementById('email').value;
            let password=document.getElementById('password').value;
            let loginSubmit=document.getElementById('login-submit');
            const pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if(!email){
                alert("Email is required");
            }
            if(!password){
                alert("Password is required");
            }
          
        }
    </script>





    
</body>

</html>