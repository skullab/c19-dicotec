function validateSubmit(event){
    if(event)event.preventDefault();
    var input = document.getElementById('input-qrcode');
    var code = input.value ;
    input.value = '';
    if(code === ''){
        Swal.fire({
            title: 'Errore',
            text: 'Campo QRCODE vuoto !',
            icon: 'error',
            showConfirmButton:false,
            timer:DISPLAY_TIME
        });
        return;
    }
    var mode = document.querySelector('input[name="scanmode"]:checked').value;
    axios.post(API_VALIDATION_URL,{
        qrcode:code,
        scanmode:mode
    }).then(function(response){
       validateResponse(response.data);
    }).catch(function(err){
        Swal.fire({
            title: 'Errore',
            text: err,
            icon: 'error',
            showConfirmButton:false,
            timer:DISPLAY_TIME
        });
    });
}
function validateResponse(data){
    console.log(data);
    var person = data.person ;
    var name = '';
    if(person){
        name = person.familyName + ' ' + person.givenName ;
    }
    switch (data.certificateStatus){
        case 'VALID':
            Swal.fire({
                title: 'CERTIFICATO VALIDO',
                text: name,
                icon: 'success',
                showConfirmButton:false,
                timer:DISPLAY_TIME
            });
            break;
        case 'NOT_VALID':
            Swal.fire({
                title: 'CERTIFICATO NON VALIDO',
                text: name,
                icon: 'error',
                showConfirmButton:false,
                timer:DISPLAY_TIME
            });
            break;
        case 'NOT_EU_DCC':
        default:
            Swal.fire({
                title: 'Errore',
                text: 'Codice QR CODE in formato non valido',
                icon: 'error',
                showConfirmButton:false,
                timer:DISPLAY_TIME
            });
    }
}
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('input-qrcode').focus();
    document.getElementById('form-verifica').addEventListener('submit',validateSubmit);
    var els = document.getElementsByName('scanmode');
    els.forEach((el)=>{
        el.addEventListener('change',function(){
            document.getElementById('input-qrcode').focus();
        });
    });
    var qrcode = document.getElementById('input-qrcode');
});