<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificate;

class CertificateController extends Controller
{
    public function postCertificate(Request $request){

    	$certificate = new Certificate();

    	$certificate->name = $request->input('name');

    	$certificate->save();

    	return response()->json(['certificate' => $certificate], 201);
    }
    public function getCertificates(){

    	$certificates = Certificate::all();

    	$response = [
    		'certificates' => $certificates
    	];

    	return response()->json($response, 200);
    }
    public function getCertificate($id){

    	$certificate = Certificate::find($id);

    	if(!$certificate){

    		return response()->json(['message' => 'Certificate not found'], 404);
    	}

    	return response()->json($certificate, 200);
    }
    public function putCertificate(Request $request, $id){

    	$certificate = Certificate::find($id);

    	if(!$certificate){

    		return response()->json(['message' => 'Certificate not found'], 404);
    	}

    	$certificate->name = $request->input('name');

    	$certificate->save();

    	return response()->json(['certificate' => $certificate], 200);
    }
    public function deleteCertificate($id){

    	$certificate = Certificate::find($id);

    	$certificate->delete();

    	return response()->json(['message' => 'Certificate deleted'], 200);
    }
}