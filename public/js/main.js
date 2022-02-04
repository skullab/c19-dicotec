var html5QrcodeScanner = null;

function validateSubmit(event, webcamDecodeText = null ){
    if(event)event.preventDefault();
    var input = document.getElementById('input-qrcode');
    var code = webcamDecodeText == null ? input.value : webcamDecodeText ;
    input.value = '';
    if(code === ''){
        Swal.fire({
            title: 'Errore',
            text: 'Campo QRCODE vuoto !',
            icon: 'error',
            showConfirmButton:false,
            timer:DISPLAY_TIME
        }).then(function(){
            setTimeout(function(){
                document.getElementById('btnValidate').blur();
                document.getElementById('input-qrcode').focus();
            },500);
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
        }).then(function(){
            setTimeout(function(){
                document.getElementById('btnValidate').blur();
                document.getElementById('input-qrcode').focus();
            },500);
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
            }).then(function(){
                setTimeout(function(){
                    document.getElementById('btnValidate').blur();
                    document.getElementById('input-qrcode').focus();
                },500);
            });
            break;
        case 'NOT_VALID':
            Swal.fire({
                title: 'CERTIFICATO NON VALIDO',
                text: name,
                icon: 'error',
                showConfirmButton:false,
                timer:DISPLAY_TIME
            }).then(function(){
                document.getElementById('input-qrcode').focus();
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
            }).then(function(){
                setTimeout(function(){
                    document.getElementById('btnValidate').blur();
                    document.getElementById('input-qrcode').focus();
                },500);
            });
    }
}

function onWebcamScanSuccess(decodedText, decodedResult){
    console.log("qrcode found: " + decodedText);
    validateSubmit(null,decodedText);
}

function onWebcamScanFailure(error){
    // console.log(error);
}

function enableWebcam(){

    if(html5QrcodeScanner == null){
        html5QrcodeScanner = new Html5QrcodeScanner(
            "webcam", 
            {   
                fps: 10, 
                qrbox: {
                    width:250,
                    height:250,
                } 
            }, 
            /* verbose= */ false);
        html5QrcodeScanner.render(onWebcamScanSuccess, onWebcamScanFailure);
    }else{
        html5QrcodeScanner.clear();
        html5QrcodeScanner = null ;
    }

    setTimeout(function(){
        document.getElementById('btnEnableWebcam').blur();
        document.getElementById('input-qrcode').focus();
    },500);

}

function updateCert(){
    Swal.fire('Aggiornamento in corso');
    Swal.showLoading();
    axios.post(API_UPDATE_URL).then(function(response){
        Swal.close();
        Swal.fire({
            title: 'Aggiornamento completato !',
            icon: 'success',
            showConfirmButton:false,
            timer:DISPLAY_TIME
        }).then(function(){
            setTimeout(function(){
                document.getElementById('btnUpdateCert').blur();
                document.getElementById('input-qrcode').focus();
            },500);
        });
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
    document.getElementById('btnUpdateCert').addEventListener('click',updateCert);
});