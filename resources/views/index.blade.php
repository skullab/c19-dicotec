<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

                <div class="mb-3 w-100">
                    <input type="text" name="qrcode" class="form-control" id="input-qrcode">
                    <input type="hidden" value="classic" name="scanmode">
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
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="scanmode" value="work">
                        <label class="form-check-label">WORK</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="scanmode" value="school">
                        <label class="form-check-label">SCHOOL</label>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-100">VERIFICA</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
<script>
    var API_VALIDATION_URL = "{{ route('api.validation') }}";
    var DISPLAY_TIME = 3000 ;
</script>
</html>