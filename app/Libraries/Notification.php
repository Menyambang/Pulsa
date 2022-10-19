<?php


namespace App\Libraries;

use App\Models\UserModel;
use Config\Services;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Notification
{
    // Firebase Auth Token Notif
    const AUTH = 'AAAAb-a5RW8:APA91bHP16gMFs_zCTGRjex7AMIE1ps7Mn_fTivBWEDTSmgAxpWA8UeAF41vW7KJjXyzoc4uLJxSAjtKLdLF3g7p64w4TeRrRWlVjxGBcPlRjX-97mLrHehCROyFpaTVpyDGHPB_CVrZ';

    public static function sendTelegramBot($pesan, $group = "-640921921")
    {
        $bot_token = "2115355665:AAEKm7Osq0Cf_xa2aOr8vfI9UFwSvHvPfEk";

        $aplikasi = strtoupper('Menyambang');
        $pesan = urlencode("[ <code>{$aplikasi}</code> ]\n{$pesan}");

        $url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage?parse_mode=HTML&chat_id={$group}&text={$pesan}";
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public static function sendWa($toNumber, $message){
        $options['baseURI'] = 'http://167.172.92.147:9090';
        $options['debug'] = WRITEPATH . '/logs/log_wa.txt';
        $options['http_errors'] = false;
        
        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }
        $curl = \Config\Services::curlrequest($options);
        
        $curl->setForm([
            'number' => $toNumber,
            'message' => $message,
        ]);
        $response = $curl->request('POST', '/send-message');

        if ($response->getStatusCode() == 200) {
            $jsonArray = $response->getBody();
            return $jsonArray;
        } else {
            return json_decode($response->getBody(), true);
            return [
                'code' => $response->getStatusCode(),
                'message' => json_decode($response->getBody(), true),
                'data' => null,
            ];
        }
    }
   
    /**
     * sendEmail
     * 
     * Fungsi untuk mengirim email
     *
     * @param  string $email
     * @param  string $subject
     * @param  string $pesan
     * @param  bool $debug
     * 
     * @return bool
     */
    public static function sendEmail($email, $subject, $pesan, $debug = false)
    {
        $mail = new PHPMailer(true);

        try {

            $host       = 'srv99.niagahoster.com';
            $username   = 'notification@menyambang.id';
            $password   = 'menyambang007';
            $name       = 'Menyambang.id';
            
            //Server settings
            if ($debug) {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            }

            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->Host       = $host;
            $mail->Username   = $username;
            $mail->Password   = $password;

            //Recipients
            $mail->setFrom($username, $name);
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $pesan;

            return $mail->send();
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e,
            ];
        }
    }
    
    static function sendNotif($email = 'ahmadjuhdi007@gmail.com', $title = 'Judul', $message = 'Pesan'){

        $options['headers']['Authorization'] = "key=".self::AUTH;
        $curl = \Config\Services::curlrequest($options);

        $userModel = new UserModel();
        $token = $userModel->find($email)->firebaseToken ?? '-';

        $data = array(
            'title' => $title,
            'body' => $message,
            'content_available' => false,
            'priority' => 'high',
            // "image" => "https://dailyspin.id/wp-content/uploads/2021/01/genshin-impact-event-10000-primogems.jpg",
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
        );

        $curl->setJson([
            "to" => $token,
            // ANDROID IDLE
            'notification' => $data,
            'data' => $data,
            // IOS
            "aps" => [
                "alert" => [
                    'title' => $title,
                    'body' => $message,
                ],
                "badge" => 1,
              ],
        ]);

        $res = $curl->request('POST', 'https://fcm.googleapis.com/fcm/send');

        return $res->getBody();
    }

    static function sendBroadcastNotif($title = 'Judul', $message = 'Pesan', $image, $topik = 'general'){

        $options['headers']['Authorization'] = "key=".self::AUTH;
        $options['http_errors'] = false;
        $curl = \Config\Services::curlrequest($options);

        $data = array(
            'title' => $title,
            'body' => $message,
            'content_available' => false,
            'priority' => 'high',
            "image" => $image,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
        );

        $curl->setJson([
            "to" => "/topics/$topik",
            // ANDROID IDLE
            'notification' => $data,
            'data' => $data,
            // IOS
            "aps" => [
                "alert" => [
                    'title' => $title,
                    'body' => $message,
                ],
                "badge" => 1,
              ],
        ]);

        $res = $curl->request('POST', 'https://fcm.googleapis.com/fcm/send');

        return $res->getBody();
    }
}
