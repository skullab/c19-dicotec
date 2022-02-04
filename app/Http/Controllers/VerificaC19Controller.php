<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Herald\GreenPass\Utils\CertificateValidator;
use Herald\GreenPass\Validation\Covid19\ValidationScanMode;
use Herald\GreenPass\Utils\UpdateService;
use Herald\GreenPass\Utils\FileUtils;

class VerificaC19Controller extends Controller
{
    protected $info = [
        'version' => '1.0.1',
    ];

    const C19_CERTIFICATE_FOLDER    = 'c19certificates';
    const SCANMODE_CLASSIC          = 'classic';
    const SCANMODE_SUPER            = 'super';
    const SCANMODE_BOOSTER          = 'booster';
    const SCANMODE_WORK             = 'work';
    const SCANMODE_SCHOOL           = 'school';

    protected $scanmode = [
        VerificaC19Controller::SCANMODE_CLASSIC,
        VerificaC19Controller::SCANMODE_SUPER,
        VerificaC19Controller::SCANMODE_BOOSTER,
        VerificaC19Controller::SCANMODE_WORK,
        VerificaC19Controller::SCANMODE_SCHOOL
    ];

    public function __construct(){
        FileUtils::overrideCacheFilePath(storage_path(VerificaC19Controller::C19_CERTIFICATE_FOLDER));
    }

    public function info(){
        return response()->json($this->info);
    }
    
    public function validation(Request $request){
        
        $validator = Validator::make($request->all(),[
            'qrcode' => ['required','string'],
            'scanmode' => ['required',Rule::in($this->scanmode)],
        ]);

        if($validator->fails()){
            return response()->json(['error' => 'invalid payload'],400);
        }

        $scanModeValidator = null ;
        switch($request->scanmode){
            case VerificaC19Controller::SCANMODE_CLASSIC:
                $scanModeValidator = ValidationScanMode::CLASSIC_DGP;
                break;
            case VerificaC19Controller::SCANMODE_SUPER:
                $scanModeValidator = ValidationScanMode::SUPER_DGP;
                break;
            case VerificaC19Controller::SCANMODE_BOOSTER:
                $scanModeValidator = ValidationScanMode::BOOSTER_DGP;
                break;
            case VerificaC19Controller::SCANMODE_WORK:
                $scanModeValidator = ValidationScanMode::WORK_DGP;
                break;
            case VerificaC19Controller::SCANMODE_SCHOOL:
                $scanModeValidator = ValidationScanMode::SCHOOL_DGP;
                break;
        }

        $gp_qrcode = strval($request->qrcode) ; 
        $gp_validator = new CertificateValidator($gp_qrcode,$scanModeValidator);
        $gp_data = $gp_validator->getCertificateSimple();

        return response()->json($gp_data);
    }

    public static function updateCertificatesSilent(){
        FileUtils::overrideCacheFilePath(storage_path(VerificaC19Controller::C19_CERTIFICATE_FOLDER));
        //aggiorna lo status dei certificati
        UpdateService::updateCertificatesStatus();
        //aggiorna la lista dei certificati
        UpdateService::updateCertificateList();
        //aggiorna le regole di validazione
        UpdateService::updateValidationRules();
        //aggiorna le liste di revoca
        UpdateService::updateRevokeList();
    }

    public function updateCertificates(Request $request){
        VerificaC19Controller::updateCertificatesSilent();
        return response()->json(['message' => 'certificati aggiornati']);
    }
}
