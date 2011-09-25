<?php if(!class_exists('raintpl')){exit;}?><html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="tpl/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="tpl/js/additional-methods.min.js"></script>
        <script type="text/javascript" src="tpl/js/jquery.form.js"></script>
        <link rel="stylesheet" type="text/css" href="tpl/stylesheets/main.css" />
        <script>
            $(document).ready(function() {
                $("body").css("display", "none");
                
                $("body").fadeIn(1000);
                
                $("a.transition").click(function(event){
                    event.preventDefault();
                    linkLocation = this.href;
                    $("body").fadeOut(1000, redirectPage);
                });
                
                function redirectPage() {
                    window.location = linkLocation;
                }
                
                jQuery.validator.addMethod("mac", function(value, element) { 
                    regex=/^([0-9a-f]{2}([:-])){5}([0-9a-f]{2})$|^([0-9a-f]{2}([.])){5}([0-9a-f]{2})$|^([0-9a-f]{12})$/i;
                    if (regex.test(value)){
                            var clean_mac = value.replace(/:/gi,'');
                            var valid2 = $.ajax({
                                    url: "ajax.php?type=validmac&mac=" + clean_mac,
                                    async: false
                                }).responseText;
                            valid2 = jQuery.parseJSON(valid2);
                            return valid2.status;
                    }
                    else{
                            return false;
                    }
                }, "Please specify a valid mac address");
                
                jQuery.validator.addMethod("ext", function(value, element) { 
                    var valid = $.ajax({
                                    url: "ajax.php?type=validext&ext=" + value,
                                    async: false
                                }).responseText;
                    valid = jQuery.parseJSON(valid);
                    return valid.status;
                }, "This extension is already in use");
                
                
                jQuery("#add").validate();
                jQuery('#add').ajaxForm(function(responseText, statusText, xhr, $form) { 
                    jQuery('#add').resetForm();
                    if(statusText == 'success') {
                        var response = jQuery.parseJSON(responseText);
                        $('#message').html(response.status);
                        $('#status').append('Added Blah to Blah </br>');
                        $('#mac').focus();
                    }
                });
            });
        </script>
    </head>
        <body>