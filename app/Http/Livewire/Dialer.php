<?php

namespace App\Http\Livewire;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;
use Livewire\Component;

class Dialer extends Component
{
    public $call_button_message = 'Call';

    public $phone_number = '';

    public function render()
    {
        return view('livewire.dialer');
    }
    public function addNumber($number)
    {
        if(strlen($this->phone_number) <= 10){
            $this->phone_number .= $number;
        }
    }
    public function makePhoneCall()
    {

        $this->call_button_message = 'Dialing ...';
        try {
            $client = new Client(
                env('TWILIO_ACCOUNT_SID'),
                env('TWILIO_AUTH_TOKEN')
            );

            try{
                $client->calls->create(
                    $this->phone_number,
                    env('TWILIO_NUMBER'),
                    array(
                        "url" => "http://demo.twilio.com/docs/voice.xml")
                );
                $this->call_button_message = 'Call Connected!';
            }catch(\Exception $e){
                $this->call_button_message = $e->getMessage();
            }
        } catch (ConfigurationException $e) {
            $this->call_button_message = $e->getMessage();
        }
    }


}
