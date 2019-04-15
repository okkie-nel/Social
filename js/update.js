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
               success: function(data)
               {
                    if (data === "YES") {
                        window.location.replace("profile.php");
                    }else{
                          alert(data);
                    }
               }
             });
    });    
});

function passwhash(form, password, oldpassword) { 
    var hashpass = document.createElement("input");
    var oldhashpass = document.createElement("input");
    
    form.appendChild(oldhashpass);
    oldhashpass.name = "old_hashpass";
    oldhashpass.type = "hidden";
    oldhashpass.value = hex_sha512(oldpassword.value);
    
    form.appendChild(hashpass);
    hashpass.name = "hashpass";
    hashpass.type = "hidden";
    hashpass.value = hex_sha512(password.value);
}


