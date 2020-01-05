 $('#panier').ajaxForm(function(responseText) { 
                           alert(responseText);  
                $.fancybox({
//                'content' : responseText,
                'width'             : '70%',
            'height'            : '70%',
            'autoScale'         : false,
            'transitionIn'      : 'elastic',
            'transitionOut'     : 'elastic',
            'type'              : 'iframe',
            href : 'panier.php'
                    });
            
            }); 