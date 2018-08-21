<?php 

/**
 * Use this method to access the SparkPost API
 */
function sparkpost($method, $uri, $payload = [], $headers = [])
{
    $defaultHeaders = [ 'Content-Type: application/json' ];

    $curl = curl_init();
    $method = strtoupper($method);

    $finalHeaders = array_merge($defaultHeaders, $headers);

    $url = 'https://api.sparkpost.com:443/api/v1/'.$uri;

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if ($method !== 'GET') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $finalHeaders);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}



$to_email_arr=[];
$to_emails=['to1@example.com','cc1@example.com','to2@example.com','cc2@example.com','bcc1@example.com','bcc2@example.com'];

foreach ($to_emails as $key => $value)
{
    $to_email_arr[]=['email'=>$value];
}
$address=[];
foreach($to_email_arr as $recipient_key=>$recipient_data){
    $address[]=['address'=>$recipient_data];
}

$payload = [
    'options' => [
        'sandbox' => false,
    ],
    'content' => [
        'from' => [
            'name' => 'SparkPost Team',
            'email' => 'sales@wehoster.com',
        ],
        'headers'=>[
            "CC"=>"<cc@example.com>"
        ],
        'subject' => 'Sending an email with SparkPost',
        'html' => '<html><body><h1>Sending mail with PHP+SparkPost+cURL!</h1></body></html>',
    ],
    'recipients' =>$address 
];

$headers = [ 'Authorization: SPARK-KEY' ];
echo "<pre>";
echo "Sending email...\n";
$email_results = sparkpost('POST', 'transmissions', $payload, $headers);

echo "Email results:\n"; 
echo json_encode(json_decode($email_results, false), JSON_PRETTY_PRINT);
echo "\n\n";

echo "Listing sending domains...\n";
$sending_domains_results = sparkpost('GET', 'sending-domains', [], $headers);

echo "Sending domain results:\n"; 
echo json_encode(json_decode($sending_domains_results, false), JSON_PRETTY_PRINT);
echo "\n";

$sample_address=[
        [
            'address' => [
                'name' => 'name',
                'email' => 'to1@example.com',
            ],
        ],
        [
            'address' => [
                'name' => 'name',
                'email' => 'to2@example.com',
            ],
        ],
        [
            'address' => [
                'name' => 'name',
                'email' => 'cc1@example.com',
            ],
        ],
        [
            'address' => [
                'name' => 'name',
                'email' => 'cc2@example.com',
            ],
        ],
        [
            'address' => [
                'name' => 'name',
                'email' => 'bcc1@example.com',
            ],
        ],
        [
            'address' => [
                'name' => 'name',
                'email' => 'bcc2@example.com',
            ],
        ],
    ];