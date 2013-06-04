<?php

/**
 * Twitter DataSource
 *
 * Used for reading and writing to Twitter, through models.
 *
 */
App::uses('HttpSocket', 'Network/Http');
require '../../vendors/twitter/tmhOAuth.php';
require '../../vendors/twitter/tmhUtilities.php';

class TwitterSource extends DataSource {

    protected $_schema = array(
        'tweets' => array(
            'id' => array(
                'type' => 'integer',
                'null' => true,
                'key' => 'primary',
                'length' => 11,
            ),
            'tweet_id_str' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 40
            ),
            'text' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
            'user_secret' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
            'user_token' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
            'status' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
        )
    );

    public function __construct($config) {
        parent::__construct($config);
        $this->consumer_key = $config['consumer_key'];
        $this->consumer_secret = $config['consumer_secret'];
        $this->user_token = $config['user_token'];
        $this->user_secret = $config['user_secret'];
    }

    public function listSources() {
        return array('tweets');
    }

    public function read($model, $queryData = array()) {
        $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => $this->consumer_key,
                    'consumer_secret' => $this->consumer_secret,
                    'user_token' => $this->user_token,
                    'user_secret' => $this->user_secret,
                ));
        pr('ok');
        if (isset($queryData['resource']))
            $resource = $queryData['resource'];
        else
            $resource = 'user_timeline';

        $code = $tmhOAuth->request('GET', $tmhOAuth->url('1/' . $resource, 'json'), $queryData);

        $response = json_decode($tmhOAuth->response['response']);

        return $response;
    }

    public function create($model, $fields = array(), $values = array()) {
        $data = array_combine($fields, $values);
        $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => $this->consumer_key,
                    'consumer_secret' => $this->consumer_secret,
                    'user_token' => $this->user_token,
                    'user_secret' => $this->user_secret,
                ));

        if (isset($data ['tweet_id_str'])) {
            $tweet_id_str = $data ['tweet_id_str'];
            $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/retweet/' . $tweet_id_str), '');
        } else {
            $status ['status'] = $data ['status'];

            $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), $status);
        }

        if ($code == 200) {
            $response = json_decode($tmhOAuth->response['response']);
            $model->setInsertId($response);
            return true;
        }
        else
            echo '<!--
                ';
        echo $code;
        echo '
            ';
        print_r(json_decode($tmhOAuth->response['response']));
        echo '
            -->';
        return false;
    }

    public function describe($model) {
        return $this->_schema['tweets'];
    }

}

