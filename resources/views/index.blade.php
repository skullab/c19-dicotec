<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <title>verifica C19 - Dicotec</title>
</head>
<body>
    <div class="container mt-5 position-relative d-flex flex-column justify-content-center h-100">
        <div class="d-flex justify-content-center c19-logo">
            <img src="{{ asset('images/verificaC19.png') }}" class="img-fluid" />
        </div>
        <div class="d-flex justify-content-center">
            <form action="" method="post" id="form-verifica">

                <div class="row">
                    <div class="col-2">
                        <button id="btnEnableWebcam" type="button" class="btn btn-primary" onclick="enableWebcam()"><i class="fa-solid fa-camera"></i></button>
                    </div>
                    <div class="col-10">
                        <input type="text" name="qrcode" class="form-control" id="input-qrcode">
                        <input type="hidden" value="classic" name="scanmode">
                    </div>
                </div>

                <div class="mb-3 w-100">
                    <div id="webcam" class="webcam"></div>
                </div>
                
                <div class="d-flex justify-content-center gap-3 mb-3 scan-mode">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="scanmode" value="classic" checked>
                        <label class="form-check-label">CLASSICO</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="scanmode" value="super">
                        <label class="form-check-label">RAFFORZATO</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="scanmode" value="booster">
                        <label class="form-check-label">BOOSTER</label>
                    </div>
                    <div class="form-check hidden">
                        <input type="radio" class="form-check-input" name="scanmode" value="work">
                        <label class="form-check-label">WORK</label>
                    </div>
                    <div class="form-check hidden">
                        <input type="radio" class="form-check-input" name="scanmode" value="school">
                        <label class="form-check-label">SCHOOL</label>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center gap-3">
                    <button id="btnValidate" type="submit" class="btn btn-success w-100">VERIFICA</button>
                    <button id="btnUpdateCert" type="button" class="btn btn-primary w-100">AGGIORNA CERTIFICATI</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
<script>
    var API_VALIDATION_URL = "{{ route('api.validation') }}";
    var API_UPDATE_URL = "{{ route('api.update-certificates') }}";
    var DISPLAY_TIME = 3000 ;
</script>
</html>