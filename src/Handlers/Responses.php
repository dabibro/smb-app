<?php
/*
if ((!defined('CONST_INCLUDE_KEY')) || (CONST_INCLUDE_KEY !== 'd4e2ad09-b1c3-4d70-9a9a-0e6149302486')) {
	// If someone tries to browse directly to this PHP file, send 404 and exit. It can only included
	// as part of our API.
	header("Location: /404.html", TRUE, 404);
	echo file_get_contents('../404.html');
	die;
}
*/

namespace App\Handlers;
class Responses
{
    public static function getResponse($varRespCode)
    {

        switch ($varRespCode) {

            case '200':
                $success = TRUE;
                $response = '200';
                $responseDescription = 'The request has succeeded';
                break;

            case '201':
                $success = TRUE;
                $response = '201';
                $responseDescription = 'Limited success. One or more batch requests failed for the command executed.';
                break;

            case '204':
                $success = TRUE;
                $response = '204';
                $responseDescription = 'The request was successful, but the result is empty.';
                break;

            case '400':
                $success = FALSE;
                $response = '400';
                $responseDescription = 'Bad Request. One or more required parameters were missing or invalid';
                break;

            case '401':
                $success = FALSE;
                $response = '401';
                $responseDescription = 'Forbidden. User does not exist.';
                break;

            case '402':
                $success = FALSE;
                $response = '402';
                $responseDescription = 'Forbidden. Authorization token does not exist.';
                break;

            case '403':
                $success = FALSE;
                $response = '403';
                $responseDescription = 'Forbidden. Request is missing valid credentials.';
                break;

            case '405':
                $success = FALSE;
                $response = '405';
                $responseDescription = 'Looking for something? You can search for other things or contact us.';
                break;

            case '500':
                $success = FALSE;
                $response = '500';
                $responseDescription = 'Internal Server Error. The server encountered an unexpected condition which prevented it from fulfilling the request.';
                break;

            default:
                $success = TRUE;
                $response = '000';
                $responseDescription = 'Unknown application response request.';

        } // end switch

        // return array for when the API needs to return the passed params
        $returnArray = array('success' => $success, 'response' => $response, 'responseDescription' => $responseDescription);
        return $returnArray;

    }

    //--------------------------------------------------------------------------------------------------------------------
    public static function displayResponse($response)
    {
        extract($response);
        if (empty($success)) {
            if (!empty($message)) $responseDescription = $message;
            echo('<div class="alert alert-danger small"><b><i class="fal fa-exclamation-triangle mr-2"></i>' . $response . ' : </b> ' . $responseDescription . '</div>');
        } else {

        }
    }

    //--------------------------------------------------------------------------------------------------------------------

    public static function alertResponse($message = "", $alert = "")
    {

        switch ($alert):
            case "danger" :
                $response = "<div class=\"alert alert-danger bg-gradient-red\"><i class=\"feather icon-alert-triangle mr-2\"></i> " . $message . " <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button></div>";
                break;
            case "success" :
                $response = "<div class=\"alert alert-success bg-gradient-green\"><i class=\"fal fa-check-circle\"></i> " . $message . " <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button></div>";
                break;
            case "warning" :
                $response = "<div class=\"alert alert-warning bg-gradient-green\"><i class=\"fal fa-exclamation-circle\"></i> " . $message . " </div>";
                break;
            case "info" :
                $response = "<div class=\"alert alert-info bg-gradient-green\"><i class=\"fal fa-info-circle\"></i> " . $message . " <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button></div>";
                break;
            default:
                $response = "<div class=\"alert alert-primary bg-gradient-primary\"><i class=\"fal fa-question-circle\"></i> " . $message . " <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button></div>";
                break;
        endswitch;
        return $response;
    }

}