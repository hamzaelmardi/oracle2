(function($) {
  $(document).ready(function () {
    $('#conx').click( function() {
 var login = $('#login').val();
        var pass = $('#password').val();  
        var er = false;

  function formValidation(arr){
    arr.forEach(function(el) {
        if ($.trim($('#'+el).val()).length == 0) {
          $('.'+el).css('display','block');
          er = true;
        } else {
          $('.'+el).css('display','none');
        }
    });
  }
var fields = ['login','password']
formValidation(fields)
  if( er == true){
     return false;
    }
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {'action': 'load_comments','login': login,'pass': pass},
          success:function(result){
            var json = JSON.parse(result);
              if(json.code1==200){

                const role = json.role
                console.log(role)
                if(role.includes("fournisseur")){
              var redirect = window.location.origin+'/sntl/info'
              window.location.href = redirect
                }
                else if(role.includes("client")){
                    var redirect = window.location.origin+'/sntl/client' 
              window.location.href = redirect
                }
            }else{
              Swal.fire({
              icon: 'warning',
              text: json.message,
              timer: 3000
             })
            }
          }
        })});
  });
})(jQuery);

(function($) {
  $(document).ready(function () {
    $('#inscription').click( function() {
        var nom = $('#nom').val();
        var code = $('#code').val();
        var login = $('#login').val();
        var password = $('#password').val();
        var email = $('#email').val();   
        var prenom = $('#prenom').val();   
        var cin = $('#cin').val();
        var tel = $('#tel').val();
        var er = false;

  function formValidation(arr){
    arr.forEach(function(el) {
        if ($.trim($('#'+el).val()).length == 0) {
          $('.'+el).css('display','block');
          er = true;
        } else {
          $('.'+el).css('display','none');
        }
    });
  }
var fields = ['nom','prenom','cin','code','email','tel','login','password']
formValidation(fields)
  if( er == true){
     return false;
    }
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {'action': 'insert_fourn','nom': nom,'code': code,'login': login,'password': password,'email': email,'prenom': prenom,'cin': cin,'tel': tel},
          success:function(result){
            var json = JSON.parse(result);
              if(json.code1==200){
                var redirect = window.location.origin+'/sntl/connexion-2'
             window.location.href = redirect
            }else{
              Swal.fire({
              icon: 'error',
              text: json.message,
              timer: 3000
             })
            }
          }
        })});
  });
})(jQuery);

(function($) {
  $(document).ready(function () {
    $('#inscription1').click( function() {
        var raison = $('#raison').val();
        var code1 = $('#code1').val();
        var login1 = $('#login1').val();
        var password = $('#password1').val();   
        var registre = $('#registre').val();
        var tel1 = $('#tel1').val();
    var emailm = $('#emailm').val();
         var er = false;

  function formValidation(arr){
    arr.forEach(function(el) {
        if ($.trim($('#'+el).val()).length == 0) {
          $('.'+el).css('display','block');
          er = true;
        } else {
          $('.'+el).css('display','none');
        }
    });
  }
var fields = ['raison','registre','code1','tel1','login1','password1','emailm']
formValidation(fields)
  if( er == true){
     return false;
    }
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {'action': 'insert_morale','raison': raison,'code1': code1,'login1': login1,'password': password,'registre': registre,'tel1': tel1,'emailm': emailm},
          success:function(result){
            var json = JSON.parse(result);
              if(json.code1==200){
                var redirect = window.location.origin+'/sntl/connexion-2'
             window.location.href = redirect
            }else{
            Swal.fire({
              icon: 'error',
              text: json.message,
              timer: 3000
             })
            }
          }
        })});
  });
})(jQuery);

(function($) {
  $(document).ready(function () {
    $('#inscriptioncli').click( function() {
        var rs = $('#rs').val();
        var nom2 = $('#nom2').val();
        var prenom2 = $('#prenom2').val();
        var code2 = $('#code2').val();
        var login2 = $('#login2').val();
        var password = $('#password').val();   
        var email2 = $('#email2').val();
        var tel2 = $('#tel2').val();
         var er = false;

  function formValidation(arr){
    arr.forEach(function(el) {
        if ($.trim($('#'+el).val()).length == 0) {
          $('.'+el).css('display','block');
          er = true;
        } else {
          $('.'+el).css('display','none');
        }
    });
  }
var fields = ['rs','prenom2','nom2','code2','tel2','login2','password','email2']
formValidation(fields)
  if( er == true){
     return false;
    }
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {'action': 'insert_client','rs': rs,'code2': code2,'nom2': nom2,'prenom2': prenom2,'login2': login2,'password': password,'email2': email2,'tel2': tel2},
          success:function(result){
            var json = JSON.parse(result);
              if(json.code1==200){
              var redirect = window.location.origin+'/sntl/connexion-2'
            window.location.href = redirect
            }else{
              Swal.fire({
              icon: 'error',
              text: json.message,
              timer: 3000
             })
            }
          }
        })});
  });
})(jQuery);


