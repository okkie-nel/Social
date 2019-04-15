$(document).ready(function(){ 
    $(".form").submit(function(e) { 
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
               type: "POST",
               url: url,
               data: new FormData( this ),
          processData: false,
          contentType: false,
            beforeSend: function (xhr) {
                if ( $('.error').is(":visible")) {
                    $('.error').toggle();
                }  
            },
               success: function(data)
               {
                    if (data === "YES") {
                        window.location.replace("profile.php");
                    }else{
                        
                          $('.error').html(data);
                          $('.error').toggle();
                    }
               }
             });
});
     
     
 });

function passwhash(form, password, passwordconf) { 
    var hashpass = document.createElement("input");
 
    form.appendChild(hashpass);
    hashpass.name = "hashpass";
    hashpass.type = "hidden";
    hashpass.value = hex_sha512(password.value);
  
    
  
    
}


