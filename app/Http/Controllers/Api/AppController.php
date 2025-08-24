<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Partner;
use App\Models\File;
use App\Models\Form;
class AppController extends Controller
{
    public function homeData(){
        try {
            $partners = Partner::all();
            $banners = Banner::all();
            $response = [
                'status' => Response::HTTP_OK,
                'result' => 'success',
                'message' => 'Partners and Banners retrieved successfully',
                'data' => [
                    'partners' => $partners,
                    'banners' => $banners,
                ],
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'result' => 'failure',
                'message' => $th->getMessage(),
                'data' => null,
            ];

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function searchFile(Request $request){
        try {
            $file = File::with('ledger')->where('hv_code',$request->code)->first();

            $response = [
                'status' => Response::HTTP_OK,
                'result' => 'success',
                'message' => 'File data retrieved successfully',
                'data' => [
                    'file' => $file,

                ],
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'result' => 'failure',
                'message' => $th->getMessage(),
                'data' => null,
            ];

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function customer_query(Request $request){
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'phone_no' => 'required|string|max:20',
            ]);

            Form::create([
                'first_name'=>$validatedData['first_name'],
                'last_name'=>$request->last_name,
                'city'=>$validatedData['city'],
                'phone_no'=>$validatedData['phone_no'],
                'email'=>$request->email,
            ]);

            $response = [
                'status' => Response::HTTP_OK,
                'result' => 'success',
                'message' => 'Form has been submit successfully',
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'result' => 'failure',
                'message' => $th->getMessage(),
            ];

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
