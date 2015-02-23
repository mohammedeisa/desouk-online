<?php

namespace DesoukOnline\SocialBundle\Controller;

use Buzz\Test\Message\ResponseTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Facebook;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/face_tokens")
     */
    public function indexAction()
    {
        $request = $this->container->get('request');
        $result = null;
        if ($request->get('code')) {
            $result = $request->get('code');
        }
        if ($request->get('access_token')) {
            $result = $request->get('access_token');
        }
        $result = 'tttttttttttttttttttttttttttttttttt';
        return new Response(
            $result
        );
    }

    /**
     * @Route("/facebook_share")
     * @Template()
     */
    public function shareAction()
    {

        $appId = '940214735998249';
        $secret = 'fcf5623af71275b7d67e411157fb8970';
        $pageID = '1542806685977419';
        $redirectUrl = 'http://localhost/app_dev.php/face_tokens';
        $scope = 'manage_pages,offline_access,publish_stream,publish_actions';

        $token = 'CAANXHs1aDSkBAFnYIiyA9KJI8emp3RXJ2UGiKfszAwq40EYPpML7pNqLnQM0ynoFrc2nmwRQS0vHrNFq3ZApjfeEm124Is9gvExAw9ZAIbI26jjQkVAIYHZAXny3ULEraVXcy6GcfDtUjUjkltYvaJP5CiLnvbQT9ymaHvXJb1nttND6OY9xXAyvv3biohelEjpeBIx6OZAaDzLs6Nfvm28B7MW4QS0ZD';
        FacebookSession::setDefaultApplication($appId, $secret);

// If you already have a valid access token:
        $session = new FacebookSession($token);
        if ($session) {
            try {
                $response = (new FacebookRequest(
                    $session, 'POST', '/' . $pageID . '/feed', array(
                        'link' => 'www.desoukonline.com',
                        'message' => 'User provided message'
                    )
                ))->execute()->getGraphObject();

                echo "Posted with id: " . $response->getProperty('id');

            } catch (FacebookRequestException $e) {

                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }
    }

    /**
     * @Route("/facebook_login")
     * @Template()
     */
    public function facebookLoginAction()
    {

        $app_id = "940214735998249";
        $app_secret = "fcf5623af71275b7d67e411157fb8970";
        $my_url = "http://localhost/app_dev.php/facebook_login";

        // known valid access token stored in a database
        $access_token = "CAANXHs1aDSkBAKomOD0tVACaVVKWpZC6tRcjV0XCPH0i3Nf5HWaJ6nxRvAbRJZBlLNbyPyxjb1mRxrUDfNg9ZC6r4RGO1cC1wHmzLml1b2uPu3ydt1euuOqLJPGEXJ52EUZBPP2egPRE2lFqTL8PZAtxy1TjNey2KQTKYAAH0QlIukWmWZBZBQRMUBZCpbonfH0GbQ6MF5KLXTBuafxVs2S1joFgV58xANIZD";

        $code = $_REQUEST["code"];

        // If we get a code, it means that we have re-authed the user
        //and can get a valid access_token.
        if (isset($code)) {
            $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                . $app_id . "&redirect_uri=" . urlencode($my_url)
                . "&client_secret=" . $app_secret
                . "&code=" . $code . "&display=popup";
            $response = file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);
            $access_token = $params['access_token'];
        }


        // Attempt to query the graph:
        $graph_url = "https://graph.facebook.com/me?"
            . "access_token=" . $access_token;
        $response = curl_get_file_contents($graph_url);
        $decoded_response = json_decode($response);

        //Check for errors
        if ($decoded_response->error) {
            // check to see if this is an oAuth error:
            if ($decoded_response->error->type == "OAuthException") {
                // Retrieving a valid access token.
                $dialog_url = "https://www.facebook.com/dialog/oauth?"
                    . "client_id=" . $app_id
                    . "&redirect_uri=" . urlencode($my_url);
                echo("<script> top.location.href='" . $dialog_url
                    . "'</script>");
            } else {
                echo "other error has happened";
            }
        } else {
            // success
            echo("success" . $decoded_response->name);
            echo($access_token);
        }

        // note this wrapper function exists in order to circumvent PHP’s
        //strict obeying of HTTP error codes.  In this case, Facebook
        //returns error code 400 which PHP obeys and wipes out
        //the response.
        function curl_get_file_contents($URL)
        {
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $URL);
            $contents = curl_exec($c);
            $err = curl_getinfo($c, CURLINFO_HTTP_CODE);
            curl_close($c);
            if ($contents) return $contents;
            else return FALSE;
        }

        return new Response(var_dump($this->container->get('request')));
    }


    public function getAppCode($appId, $secret)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'facebook-php-4.0.0');

        $url = 'https://www.facebook.com/dialog/oauth?client_id=' . $appId . '&redirect_uri=http://localhost/app_dev.php/face_tokens&scope=manage_pages,offline_access,publish_stream,publish_actions';
        curl_setopt($ch, CURLOPT_URL, $url);
        $curlResult = curl_exec($ch);
        curl_close($ch);

        $response_params = array();
        parse_str($curlResult, $response_params);
        $appCode = $response_params;
        return $appCode;
    }

    public function getAppAccessToken($appId, $secret, $code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'facebook-php-4.0.0');

        $url = 'https://graph.facebook.com/oauth/access_token?client_id=' . $appId . '&redirect_uri=http://localhost/app_dev.php/face_tokens&client_secret=' . $secret . '&code=' . $code;

        curl_setopt($ch, CURLOPT_URL, $url);
        $curlResult = curl_exec($ch);
        $response_params = array();
        parse_str($curlResult, $response_params);
        $accessToken = $response_params['access_token'];
        return $accessToken;
    }


    // Grab the access token from the FB API
    function getFacebookToken($client_id, $scope, $uri)
    {
        // You need to sniff out the client ID below with Charles and switch it for the app that you're targetting
        // Sniff out the permissions that the app is requesting with Charles too. They should be comma separated
        $url = 'https://www.facebook.com/dialog/oauth?client_id=' . $client_id . '&redirect_uri=' . urlencode($uri) . '&scope=' . $scope . '&response_type=token';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $data = curl_exec($ch);
        $curl_info = curl_getinfo($ch);

        // Get the headers and then the HTTP code
        $headers = substr($data, 0, $curl_info['header_size']);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Make sure that the HTTP redirects to a location that has an access token in the URL
        if ($code == 302) {
            preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $headers, $matches);
            $break = explode("access_token=", $matches[1]);

            if (count($break) == 2) {
                // Split the URL once more to get the access token value
                $exp = explode("&", $break[1]);
                $token = $exp[0];
            } else {
                $token = 'Failed';
            }
        } else {
            $token = 'Failed';
        }

        return $token;
    }


}


