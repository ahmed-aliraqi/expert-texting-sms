<?php
namespace Aliraqi\ET;

/**
 * Class SMS
 *
 * @package Aliraqi\ET
 */
class SMS
{
    /**
     * The api configration.
     *
     * @var array
     */
    private $config = [];

    /**
     * The url for send message.
     *
     * @var string
     */
    private $sendUrl;

    /**
     * The url for get balance.
     *
     * @var string
     */
    private $balanceUrl;

    /**
     * The url for message status.
     *
     * @var string
     */
    private $statusUrl;

    /**
     * The url for List all unread received messages.
     *
     * @var string
     */
    private $unreadInboxUrl;

    /**
     * The response result.
     *
     * @var object
     */
    private $response;

    /**
     * The data for sms message
     *
     * @var array
     */
    private $data = [
        'type' => 'text',
    ];

    /**
     * SMS constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->config = config('sms_et');

        // Set default sender user.
        $data['from'] = $this->config['username'];

        // Create data array.
        $this->data = array_merge($this->data, $data);

        // Set default response.
        $this->response = (object) ['ErrorMessage' => true];

        $this->sendUrl = 'https://www.experttexting.com/ExptRestApi/sms/json/Message/Send';

        $this->balanceUrl = 'https://www.experttexting.com/ExptRestApi/sms/json/Account/Balance';

        $this->statusUrl = 'https://www.experttexting.com/ExptRestApi/sms/json/Message/Status';

        $this->unreadInboxUrl = 'https://www.experttexting.com/ExptRestApi/sms/json/Message/UnreadInbox';

    }


    /**
     * The username how will send message.
     *
     * @param $from
     */
    public function from($from)
    {
        $this->data['from'] = $from;

        return $this;
    }

    /**
     * The username how will recive message.
     *
     * @param $from
     */
    public function to($to)
    {
        $this->data['to'] = $to;

        return $this;
    }

    /**
     * The body of the text message.
     *
     * @param $message
     */
    public function message($message)
    {
        $this->data['text'] = $message;

        return $this;
    }

    /**
     * This can be omitted for text (default), but is required when sending a Unicode message (unicode) message.
     *
     * @param $type
     */
    public function type($type)
    {
        $this->data['type'] = $type;

        return $this;
    }

    /**
     * Send the SMS message.
     *
     * @return bool|string
     */
    public function send()
    {
        // Generate the api url.
        $url = $this->sendUrl.'?'.http_build_query(array_merge($this->config, $this->data));

        // Get response json result.
        $response = file_get_contents($url);

        return json_decode($response);
    }

    /**
     * Retrieve your current account balance.
     *
     * @return object
     */
    public function getBalance()
    {
        // Generate the api url.
        $url = $this->balanceUrl.'?'.http_build_query($this->config);

        // Get response json result.
        $response = file_get_contents($url);

        $this->response = json_decode($response);

        return $this;
    }

    /**
     * Search a previously sent message for a given message id.
     *
     * @param integer $messageId
     *
     */
    public function getStatus($messageId)
    {
        // Generate the api url.
        $url = $this->statusUrl.'?'.http_build_query(array_merge($this->config, ['message_id' => $messageId]));

        // Get response json result.
        $response = file_get_contents($url);

        $this->response = json_decode($response);

        return $this;
    }

    /**
     * List all unread received messages.
     *
     * @return object
     */
    public function getUnreadInbox()
    {
        // Generate the api url.
        $url = $this->unreadInboxUrl.'?'.http_build_query($this->config);

        // Get response json result.
        $response = file_get_contents($url);

        $this->response = json_decode($response);

        return $this;
    }

    /**
     * Determine if the request has any errors.
     *
     * @return bool
     */
    public function hasError()
    {
        return ! ! $this->response->ErrorMessage;
    }

    /**
     * Determine if the request has not errors.
     *
     * @return bool
     */
    public function hasSuccess()
    {
        return ! ! $this->response->ErrorMessage === false;
    }

    /**
     * Get the response object.
     *
     * @return object
     */
    public function getResponse()
    {
        return $this->response;
    }

    //public function __debugInfo() {
    //    return [
    //        'response' => $this->response,
    //        'hasError' => $this->hasError(),
    //        'hasSuccess' => $this->hasSuccess(),
    //    ];
    //}
}