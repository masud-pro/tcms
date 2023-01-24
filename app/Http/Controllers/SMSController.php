<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Course;
use App\Models\Option;
use App\Models\Setting;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Jobs\Message\ProcessSMS;
use Illuminate\Support\Facades\Auth;

class SMSController extends Controller {

    // public function __construct() {
    //     $this->middleware( 'check_access:student.index', ['only' => ['index']] );
    //     $this->middleware( 'check_access:student.create', ['only' => ['create' ,'store']] );
    //     $this->middleware( 'check_access:student.edit', ['only' => ['edit', 'update']] );
    //     $this->middleware( 'check_access:student.destroy', ['only' => ['destroy']] );

    //     // 'transactions.user_online_transactions',

    //     // 'file_manager.individual_teacher',

    //     // 'settings.individual_teacher',
    // }

    public function index() {
        $optionId = Option::where( "slug", "remaining_sms" )->pluck( 'id' );

        return view( "ms.sms.all-sms", [
            "smss"         => SMS::latest()->paginate( 15 ),
            "remainingSMS" => Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->first(),
        ] );
    }

    public function create_batch_sms() {
        return view( "ms.sms.batch-sms", [
            'courses' => Auth::user()->addedCourses()->pluck( 'name', 'id' ),
        ] );
    }

    public function calculate_sms_and_remaining_sms() {

    }

    /**
     * @param Request $request
     */
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

        $smsrow        = getSettingValue( 'remaining_sms' ); // Remaining SMS row
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
                $sms['number'] = $response->user->$send_to;

                $sms['message'] = $assessment->name . " " .
                "result: " .
                $response->marks . "/" .
                $response->assignment->marks . " - " .
                env( 'APP_NAME' );

                ProcessSMS::dispatch( $sms );
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

    /**
     * @param Request $request
     */
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
        // $courseUsers = Auth::user()->addedCourses()->latest()->get();
        // $courseUsers2 = Auth::user()->addedCourses()->where('id', $data['course_id'] )->get();

        // dd($courseUsers);

        // $numbers = $courseUsers->count();
        
        // dd($numbers);
        $send_to = $data['send_to'];
// Father or mother
        // foreach ( $courseUsers as $user ) {

        //     if ( $user->$send_to ) {
        //         $numbers[] = $user->$send_to; // Father or mother
        //     }

        // }

    // dd($send_to);

        $smsCount = count($courseUsers)  * $numberOfSmsPerMessage;

        // $smsrow        = Option::where( "slug", "remaining_sms" )->first(); // Remaining SMS row
        $smsrow        = getSettingValue( 'remaining_sms' ); // Remaining SMS row
        $remaining_sms = (int) $smsrow->value;

// Remaining SMS

        if ( $remaining_sms < $smsCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        if ( $smsCount > 0 ) {

            foreach ( $courseUsers as $user ) {

                logger($user->$send_to);

                $sms['number']  = $user->$send_to;
                $sms['message'] = $data['message'];
                ProcessSMS::dispatch( $sms );
            }

            // $numbers = implode( ",", $numbers );
            // $message = $data['message'];

            // // dd( $numbers, $message );
            // dd( 'Not Reached' );

            // $status = SMSController::send_sms( $numbers, $message );

            // // dd( $status );

            // if ( $status ) {

            $remaining_sms = $remaining_sms - $smsCount;

            SMS::create( [
                'for'     => $data['for'],
                'count'   => $smsCount,
                'message' => $data['message'],
            ] );

            $smsrow->update( [
                'value' => $remaining_sms,
            ] );

            return redirect()->route( "sms.index" )->with( "success", "SMS Send Successfully" );
            // } else {
            //     return redirect()->route( "sms.index" )->with( "failed", "Report failed for unknown reasons, Check all students phone no is correct or not!" );
            // }

        } else {
            return redirect()->route( "sms.index" )->with( "failed", "Numbers not found, everyone may be present" );
        }

    }

    /**
     * @param $numbers
     * @param $message
     */
    public static function send_sms( $numbers, $message ) {

        $output = SMSController::sent_sdk( $numbers, $message );

        if ( $output->status == "ok" ) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param  $numbers
     * @param  $message
     * @return mixed
     */
    public static function sent_sdk( $numbers, $message ) {

        $url  = 'https://24smsbd.com/api/bulkSmsApi';
        $data = [
            'sender_id' => 1088,
            'apiKey'    => "Q29kZUVjc3Rhc3k6RWNzdGFzeTQ0",
            'mobileNo'  => $numbers,
            'message'   => $message,
        ];

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
        $data = ['sender_id' => $sender_id,
            'apiKey'             => $apiKey,
            'mobileNo'           => $mobileNo,
            'message'            => $message,
        ];

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