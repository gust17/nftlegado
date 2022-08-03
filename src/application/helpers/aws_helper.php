<?php
use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Aws\S3\S3Client;

function UploadS3($key, $file_path, $bucket){

    try{
        $s3Client = new S3Client([
            'credentials' => array(
                'key'    => $_SERVER['AWS_KEY'] ?? 'AKIASHKUABY75TK3I2J2',
                'secret' => $_SERVER['AWS_SECRET'] ?? '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',
            ),
            'region' => 'us-east-1',
            'version' => '2006-03-01'
        ]);

        $result = $s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $file_path,
        ]);

        return $result;

    }catch(AwsException $e){
        
        return $e->getMessage();
    }
}

function SendQSQ($data){

    $client = new SqsClient([
        'credentials' => array(
            'key'    => $_SERVER['AWS_KEY'] ?? 'AKIASHKUABY7X2XYOUG7',
            'secret' => $_SERVER['AWS_SECRET'] ?? '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',
        ),
        'region' => $_SERVER['AWS_REGION'] ?? 'us-east-1',
        'version' => '2012-11-05'
    ]);
    $params = [
        'DelaySeconds' => 0,
        'MessageBody' => json_encode($data),
        'QueueUrl' => 'https://sqs.us-east-1.amazonaws.com/153184374335/NFTEnviarEmail'
    ];
    try {
        $result = $client->sendMessage($params);

        return true;
        
    } catch (AwsException $e) {
        
        return false;
    }
}

function EnviarEmail($para, $assunto, $mensagem){

    return SendQSQ(array(
        'to'=>$para,
        'subject'=>$assunto,
        'message'=>$mensagem
    ));
}

function EnviarSMS($numero, $mensagem, $page = false){

    $paginas = SystemInfo('twilio_sms_paginas');

    if($page){
    
        $pages = json_decode($paginas, true);

        if(!in_array($page, $pages)){

            return;
        }
    }

    $numero = str_replace(array(' ', '-', '.', '(', ')'), array('', '', '', '', ''), $numero);

    $SnSclient = new SnsClient([
        'region' => $_SERVER['AWS_REGION'] ?? 'us-east-1',
        'version' => '2010-03-31',
        'credentials' => [
            'key'    => $_SERVER['AWS_KEY'] ?? 'AKIASHKUABY7X2XYOUG7',
            'secret' => $_SERVER['AWS_SECRET'] ?? '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',
        ],
    ]);
    
    try {

        $result = $SnSclient->publish([
            // 'TopicArn'=>'arn:aws:sns:us-east-1:423526306601:sms',
            'Message' => $mensagem,
            'PhoneNumber' => $numero,
        ]);
        
        return true;
    } catch (AwsException $e) {
        
        return false;
    }
    
}