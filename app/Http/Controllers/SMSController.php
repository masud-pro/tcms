<?php

namespace App\Http\Controllers;

use App\Jobs\Result\ResultSMS;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Option;
use App\Models\SMS;
use Illuminate\Http\Request;

class SMSController extends Controller {

    public function index() {
        return view( "ms.sms.all-sms", [
            "smss"         => SMS::latest()->paginate( 1 ),
            "remainingSMS" => Option::select( 'value' )->where( 'slug', 'remaining_sms' )->first(),
        ] );
    }

    public function create_batch_sms() {
        return view( "ms.sms.batch-sms", [
            'courses' => Course::all()->pluck( 'name', 'id' ),
        ] );
    }

    public function calculate_sms_and_remaining_sms() {

    }

    public function send_exam_results( Request $request ) {
        $data = $request->validate( [
            'assessment_id' => 'required',
            'to'            => 'required',
        ] );

        $assessment = Assessment::findOrFail( $data['assessment_id'] );

        // First count the characters and find the sms count
        $characters            = strlen( $assessment->name . " " . "result: 1000/1000" . " - " . env( 'APP_NAME' ) );
        $numberOfSmsPerMessage = (int) ceil( $characters / 160 );

        $smsCount = $assessment->responses()->count() * $numberOfSmsPerMessage; // Count the number of sms

        $smsrow        = Option::where( "slug", "remaining_sms" )->first(); // Remaining SMS row
        $remaining_sms = (int) $smsrow->value;

// Remaining SMS
        if ( $remaining_sms < $smsCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        if ( $smsCount > 0 ) {

            $send_to       = $data['to'];
            $loopResponses = $assessment->responses()->whereNotNull( 'marks' )->get();
// Responses to loop

            foreach ( $loopResponses as $response ) {
                $result['number'] = $response->user->$send_to;

                $result['message'] = $assessment->name . " " .
                "result: " .
                $response->marks . "/" .
                $response->assignment->marks . " - " .
                env( 'APP_NAME' );

                ResultSMS::dispatch( $result );
            }

            $remaining_sms = $remaining_sms - $smsCount;

            SMS::create( [
                'for'     => $assessment->name . " Results",
                'count'   => $smsCount,
                'message' => $assessment->name . " " . "result: (individual)" . " - " . env( 'APP_NAME' ),
            ] );

            $smsrow->update( [
                'value' => $remaining_sms,
            ] );

            return redirect()->back()->with( "success", "SMS Send Successfully" );

        } else {
            return redirect()->back()->with( "failed", "Numbers not found or something is wrong" );
        }

    }

    public function send_batch_sms( Request $request ) {
        $data = $request->validate( [
            'for'       => 'required|string',
            'course_id' => 'required|integer',
            'message'   => 'required|string',
            'send_to'   => 'required|string',
        ] );

        $characters = strlen( $data['message'] );

        $numberOfSmsPerMessage = (int) ceil( $characters / 160 );

        $courseUsers = Course::findOrFail( $data['course_id'] )->user;
        $numbers     = [];
        $send_to     = $data['send_to'];
// Father or monther

        foreach ( $courseUsers as $user ) {

            if ( $user->$send_to ) {
                $numbers[] = $user->$send_to; // Father or mother
            }

        }

        $smsCount = count( $numbers ) * $numberOfSmsPerMessage;

        $smsrow        = Option::where( "slug", "remaining_sms" )->first(); // Remaining SMS row
        $remaining_sms = (int) $smsrow->value;

// Remaining SMS

        if ( $remaining_sms < $smsCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        if ( $smsCount > 0 ) {

            $numbers = implode( ",", $numbers );
            $message = $data['message'];

            $status = SMSController::send_sms( $numbers, $message );

            if ( $status ) {

                $remaining_sms = $remaining_sms - $smsCount;

                SMS::create( [
                    'for'     => $data['for'],
                    'count'   => $smsCount,
                    'message' => $message,
                ] );

                $smsrow->update( [
                    'value' => $remaining_sms,
                ] );

                return redirect()->route( "sms.index" )->with( "success", "All guardian reported successfully" );
            } else {
                return redirect()->route( "sms.index" )->with( "failed", "Report failed for unknown reasosns, Check all studnets phone no is correct or not!" );
            }

        } else {
            return redirect()->route( "sms.index" )->with( "failed", "Numbers not found, everyone may be present" );
        }

    }

    public static function send_sms( $numbers, $message ) {

        $output = SMSController::sent_sdk( $numbers, $message );

        if ( $output->status == "ok" ) {
            return true;
        } else {
            return false;
        }

    }

    public static function sent_sdk( $numbers, $message ) {

        $url  = 'https://24smsbd.com/api/bulkSmsApi';
        $data = array(
            'sender_id' => 1088,
            'apiKey'    => "Q29kZUVjc3Rhc3k6RWNzdGFzeTQ0",
            'mobileNo'  => $numbers,
            'message'   => $message,
        );

        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
        $output = curl_exec( $curl );
        curl_close( $curl );

        $output = json_decode( $output );

        return $output;
    }

    public function send() {

        $sender_id = 1088;
        $apiKey    = "Q29kZUVjc3Rhc3k6RWNzdGFzeTQ0";
        $mobileNo  = "01628715444";
        $message   = "SMS From Software";

        $url  = 'https://24smsbd.com/api/bulkSmsApi';
        $data = array( 'sender_id' => $sender_id,
            'apiKey'                  => $apiKey,
            'mobileNo'                => $mobileNo,
            'message'                 => $message,
        );

        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
        $output = curl_exec( $curl );
        curl_close( $curl );

        $output = json_decode( $output );

        if ( $output->status == "ok" ) {
            dd( "sent" );
        } else {
            dd( "failed" );
        }

    }

}
