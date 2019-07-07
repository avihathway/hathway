<?php include 'head.php';?>
<?php 

error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	$name = trim($_POST['contactName']);
	$email = trim($_POST['email']);
	$comments = trim($_POST['comments']);
	$Phone = trim($_POST['Phone']);
	
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
		
		$emailTo = 'contact@dicson.in';
		$subject = 'Submitted message from '.$name;
		//$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \nEmail: $email \nPhone: $Phone \n\nComments: $comments";
		//$headers = 'From: '.$emailTo;
		$headers  = "From: <$emailTo>\r\n";
		$headers .= "Reply-To: <$email>\r\n";
		$headers .= "Cc: smartdicson@gmail.com\r\n";

		mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>
<div id="single_page">
	<span class="page_mask"></span>
	<div class="scroll_page_banner">
    	<div class="scroll_page map">
        	<span class="scroll_banner_mask"></span>
        	<div class="scroll_content">
        		<h2>Contact Me</h2>
                <h3>Smart designer & Pixel perfect Front end developer</h3>
            </div>
        </div>
    </div>
    <div class="page_section space with_contact">
    	<div class="page_container">
        	<div class="form_section fl">
            	<?php if(isset($emailSent) && $emailSent == true) { ?>
                    <p class="info">Your email was sent. Dicson!</p>
                <?php } else { ?>
                <div id="contact-form">
            		<?php if(isset($hasError) || isset($captchaError) ) { ?>
                        <p class="alert">Error submitting the form</p>
                    <?php } ?>
                    <form class="contact_me fl" id="contact-us" action="Contact-me.php" method="post">
                    	<div class="form_input">
                            <div class="row">
                                <label>Name:</label>
                                <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt c_name requiredField">
                                <?php if($nameError != '') { ?>
                                    <br /><span class="error"><?php echo $nameError;?></span> 
                                <?php } ?>
                            </div>
                            <div class="row">
                                <label>Phone No:</label>
                                <input type="text" id="Phone" name="Phone" type="text" pattern="[0-9]{8,18}" autocomplete="off"  maxlength="13">
                                
                            </div>
                            <div class="row">
                                <label>Email Id:</label>
                                <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField c_email email" pattern="[^ @]*@[^ @]*">
                                <?php if($emailError != '') { ?>
                                    <br /><span class="error"><?php echo $emailError;?></span>
                                <?php } ?>
                            </div>
                            <div class="row txt">
                                <label>Message:</label>
                                <textarea name="comments" id="commentsText" class="txtarea c_textarea requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                                <?php if($commentError != '') { ?>
                                    <br /><span class="error"><?php echo $commentError;?></span> 
                                <?php } ?>
                            </div>
                            <div class="bottons">
                                <div class="bottonsmask fr">
                                    <input type="submit" id="sub_btn" class="subbutton" name="Submit" value="Send Message">
                                    <input type="hidden" name="submitted" id="submitted" value="true" />
                                </div>
                            </div>
                        	<div class="clear"></div>
                        </div>
                        <div id="form_action"></div>
                    </form>
                </div>
            	<?php } ?>
                <div class="clear"></div>
            </div>
            <div class="dicson_QR fr">
            	<img src="<?php echo HOST; ?>images/dicson-QR.png" alt="Dicson QR" />
            </div>
        <div class="clear"></div>
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
	$('.contact_me input, .contact_me textarea').on('blur', function(){
		if( !this.value ) {
			$(this).parent('div').removeClass('move');
		}else{$(this).parent('div').addClass('move');}
	}).on('focus', function(){
	  $(this).parent('div').addClass('move');
	});
	$('form#contact-us').submit(function() {
			$('form#contact-us .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					var labelText = $(this).prev('label').text();
						$(this).focus(function(){
							$(this).parent('div').removeClass('inputError');
						});
					//$('#form_action').append('<span class="error">Your forgot to enter your '+labelText+'.</span>');
					$(this).parent('div').addClass('inputError');
					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						var labelText = $(this).prev('label').text();
						$('#form_action').append('<span class="error">Sorry! You\'ve entered an invalid '+labelText+'.</span>');
						$(this).addClass('inputError');
						hasError = true;
					}
				}
			});
			if(!hasError) {
			$('#sub_btn').attr('disabled', 'disabled');
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					$('.form_input').fadeOut("slow", function() {				   
						$(this).before('<p class="tick"><span class="thanks">Thanks!.</span><br>Your email has been delivered <span>Dicson.</span></p>');
					});
				});
			}
			
			return false;	
		});
});
</script>
<?php include 'page-footer.php';?>