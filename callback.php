<?php 
    require_once 'config.php';
    require_once 'vendor/autoload.php';
    use GuzzleHttp\Client;
    
    if(isset($_GET['code'])) {    

    try {
        $client = new Client(['base_uri' => 'https://www.linkedin.com']);
        $response = $client->request('POST', '/oauth/v2/accessToken', [
            'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => REDIRECT_URL,
                    "client_id" => CLIENT_ID,
                    "client_secret" => CLIENT_SECRET,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $access_token = $data['access_token']; // store this token somewhere
        $user_id = get_user_id();
        // print_r($user_id);
        share_post();
    } catch(Exception $e) {
        echo $e->getMessage();
    }

}


    function get_user_id() {
        global $access_token;
        try {
            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('GET', '/v2/me', [
                'headers' => [
                    "Authorization" => "Bearer " . $access_token,
                ],
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            $linkedin_profile_id = $data['id']; // store this id somewhere
            return $linkedin_profile_id;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function share_post() {
        global $access_token;
        global $user_id;
        $link = 'https://dev.to/tomy/template-literal-types-in-typescript-4-1-46n2';
        $sharer = "https://www.linkedin.com/shareArticle?mini=true&url=".$link;
        
        echo "<script>window.open('$sharer', 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0')</script>";
    }


?> 