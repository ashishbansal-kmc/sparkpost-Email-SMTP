<?php 

class Sparkpost
{
    
    public $baseUrl;
    public $headers=[];
    public $client;
    public $settings=[];
    public $data=[];
    public $method_name=[];

    public function __construct($key)
    {
        $this->baseUrl="https://api.sparkpost.com";
        $this->settings['api-key'] = $key;
        $this->headers=[
                  'Authorization'=>$this->settings['api-key'],
                  'Content-Type'=>'application/json',
                  'Accept' => 'application/json'
        ];
        /* $this->client is object of GuzzleHttp\Client class */
        $this->client = new \GuzzleHttp\Client();
        $this->validation=[];
        $this->data['options']=['open_tracking'=>true,'click_tracking'=>true,'transactional'=>true];
    }
    public function setName($name="")
    {
       try
       {  
            if(!empty($name))
            {  
                $this->data['content']['from']['name']=$name;
            }
        }
        catch(\Exception $e){
            $status=400; 
            $response=['status' => 0,'errors'=>$e->getMessage()];
            return response()->json($response,$status);
        } 
    }
    public function setFrom($from=""){
       try
       {
            if(!empty($from))
            {  
                $this->data['content']['from']['email'] = $from;
            }
       }catch(\Exception $e){
            $status=400; 
            $response=['status' => 0,'errors'=>$e->getMessage()];
            return response()->json($response,$status);
        }
    }
    /* Set Subject*/
    public function setSubject($subject=""){
        try
        { 
            if(!empty($subject))
            { 
                $this->data['content']['subject'] = $subject;
            }  
         }catch(\Exception $e){
            $status=400; 
            $response=['status' => 0,'errors'=>$e->getMessage()];
            return response()->json($response,$status);
        }
    }
    public function setEmails($recipients=array())
    {
        try
        {   
            if(!empty($recipients) && count($recipients)>0 && is_array($recipients))
            { 
                foreach($recipients as $recipient_key=>$recipient_data){
                    if(array_key_exists('email',$recipient_data))
                    {
                        $address[]=['address'=>$recipient_data];
                    }
                }
                if(!empty($address) && is_array($address) && count($address)>0)
                {   
                   $this->data['recipients']=$address;
                }
            }  
        }catch(\Exception $e){
            $status=400; 
            $response=['status' => 0,'errors'=>$e->getMessage()];
            return response()->json($response,$status);
        }   
    }


    public function setHeaders($data){
        $this->data['content']['headers']['CC']=$data;
    }

    public function sendMail($num_rcpt_errors=3)
    {
        try
        {   
            $api_url="/api/v1/transmissions?num_rcpt_errors=".$num_rcpt_errors;
            $response=$this->client->post($this->baseUrl.$api_url,
                [
                   'headers'=>$this->headers,     
                   'body'=>json_encode($this->data)
                ]
            );
            if($response->getStatusCode()==200)
            {
                $return_data=['status'=>1,'message'=>'Mail have been sent','result'=>json_decode((string)$response->getBody())->results];
                $status=200;
            }
            else
            {
                $return_data=['status'=>0,'message'=>'Mail have not been sent'];
                $status=404;
            }          
            return response()->json($return_data,$status);
        }
        catch(\Exception $e){
            $status=400; 
            $response=['status' => 0,'errors'=>$e->getMessage()];
            return response()->json($response,$status);
        }
    }
}

$to_email_arr=[];
$header_emails='cc1@example.com,cc2@example.com';

$to_emails=['to1@example.com','cc1@example.com','to2@example.com','cc2@example.com','bcc1@example.com','bcc2@example.com'];

foreach ($to_emails as $key => $value)
{
    $to_email_arr[]=['email'=>$value];
}
$address=[];
foreach($to_email_arr as $recipient_key=>$recipient_data){
    $address[]=['address'=>$recipient_data];
}

$key='SPARK-KEY';
$spark_mail=new Sparkpost($key);
$spark_mail->setFrom('test@example.com');// set valid domain email id
$spark_mail->setName('CIMET');
$spark_mail->setSubject('test email');
$spark_mail->setHeaders($header_emails);
$spark_mail->setEmails($to_email_arr);
$response=$spark_mail->sendMail();
echo "<pre>";
print_r($response);
?>