<div class="clearfix"></div>
<div class="foot">
Design & Developed by: <a href="https://www.appventurez.com/" target="_blank"><strong style="color:#007BFF;">Appventurez</strong><strong>Mobitech</strong> Pvt. Limited</a> through <a href="https://www.dgmhup.gov.in/" target="_blank"><strong>DGMHUP</strong></a> . This portal is maintained &amp; managed by IT Cell, DGMHUP, Uttar Pradesh.
</div>



 

    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/owl.carousel.min.js"></script> 
    <script>
	$(document).ready(function() {
	$('a').each(function(){
	if(location.href === this.href){
	$(this).addClass('active');
	$('a').not(this).addClass('none');
	return false;
	}
	});
	});
	$(function () {
        $(".news").owlCarousel({
            slideSpeed: 300,
            paginationSpeed: 400,
            items: 1,
            autoPlay: !0,
            navigation: !0,
			pagination: false,
			itemsDesktop : [1199,1],
            itemsDesktopSmall : [1027,1],
            navigationText: ["<i class='icon-arrow-left icons'></i>", "<i class='icon-arrow-right icons'></i>"]
        }); 
		
		});
	</script>
    <script src="js/jquery.bootstrap.wizard.js"></script>
    <script src="js/prettify.js"></script>
	<script>
    $(document).ready(function() {
    $('#rootwizard').bootstrapWizard({'tabClass': 'bwizard-steps'});
    window.prettyPrint && prettyPrint()
    });
    </script>
</body>
</html>
