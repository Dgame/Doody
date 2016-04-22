<?php

namespace App\Client;

use App\Client\Header\HeaderProvider;

/**
 * Class Client
 * @package App\Client
 */
final class Client
{
    /**
     * @var array
     */
    const DEFAULT_OPTIONS = [
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_VERBOSE        => true,
        CURLOPT_HEADER         => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_FAILONERROR    => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => false,
        CURLOPT_HTTPAUTH       => CURLAUTH_ANY,
        CURLOPT_TIMEOUT        => 600,
        CURLOPT_CONNECTTIMEOUT => 180,
        CURLOPT_SSLVERSION     => CURL_SSLVERSION_DEFAULT,
    ];

    /**
     * @var resource
     */
    private $_handle = null;
    /**
     * @var array
     */
    private $_options = [];
    /**
     * @var HeaderProvider|null
     */
    private $_headerProvider = null;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->_handle = curl_init();
        enforce((bool) $this->getHandle(), 'CURL init Fehler');
    }

    /**
     *
     */
    public function __destruct()
    {
        curl_close($this->getHandle());
    }

    /**
     * @return resource
     */
    public function getHandle()
    {
        return $this->_handle;
    }

    /**
     * @param int $option
     *
     * @return mixed
     */
    public function getInfo($option = 0)
    {
        return curl_getinfo($this->getHandle(), (int) $option);
    }

    /**
     * @param int $option
     * @param     $value
     *
     * @return $this
     */
    public function setOption(int $option, $value)
    {
        $this->_options[$option] = true;

        curl_setopt($this->getHandle(), $option, $value);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }

        return $this;
    }

    /**
     * @param bool $host
     * @param bool $peer
     *
     * @return $this
     */
    public function verifySSL(bool $host, bool $peer)
    {
        return $this->setOption(CURLOPT_SSL_VERIFYHOST, $host ? 2 : 0)
            ->setOption(CURLOPT_SSL_VERIFYPEER, $peer);
    }

    /**
     * @param int $timeout
     * @param int $connection_timeout
     *
     * @return $this
     */
    public function setTimeout(int $timeout, int $connection_timeout)
    {
        return $this->setOption(CURLOPT_TIMEOUT, $timeout)
            ->setOption(CURLOPT_CONNECTTIMEOUT, $connection_timeout);
    }

    /**
     * @param array $header
     *
     * @return Client
     */
    public function setHeaderProvider(array $header)
    {
        return $this->setOption(CURLOPT_HTTPHEADER, $header);
    }

    /**
     * @return bool
     */
    public function hasHeaderProvider()
    {
        return $this->_headerProvider !== null;
    }

    /**
     * @return HeaderProvider
     */
    public function getHeaderProvider()
    {
        if (!$this->hasHeaderProvider()) {
            $this->_headerProvider = new HeaderProvider();
        }

        return $this->_headerProvider;
    }

    /**
     * @param bool $fetch
     *
     * @return Client
     */
    public function fetchHeader(bool $fetch)
    {
        return $this->setOption(CURLOPT_HEADER, $fetch);
    }

    /**
     * @param bool $verbose
     *
     * @return Client
     */
    public function verbose(bool $verbose)
    {
        return $this->setOption(CURLOPT_VERBOSE, $verbose);
    }

    /**
     * @param bool $post
     *
     * @return Client
     */
    public function usePost(bool $post)
    {
        return $this->setOption(CURLOPT_POST, $post);
    }

    /**
     * @return Client
     */
    public function useDefaults()
    {
        return $this->setOptions(self::DEFAULT_OPTIONS);
    }

    /**
     * @return $this
     */
    public function setDefaults()
    {
        foreach (self::DEFAULT_OPTIONS as $option => $value) {
            if (!array_key_exists($option, $this->_options)) {
                $this->setOption($option, $value);
            }
        }

        return $this;
    }

    /**
     * @param string $url
     * @param        $data
     *
     * @return mixed
     */
    public function send(string $url, $data)
    {
        $this->setDefaults();
        $this->setOption(CURLOPT_URL, $url)
            ->setOption(CURLOPT_POSTFIELDS, $data);

        if ($this->hasHeaderProvider()) {
            $this->setOption(CURLOPT_HTTPHEADER, $this->_headerProvider->provide());
        }

        $result = curl_exec($this->getHandle());
        if ($result === false) {
            return curl_error($this->getHandle());
        }

        return $result;
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function receive(string $url)
    {
        $this->setDefaults();
        $this->setOption(CURLOPT_URL, $url);

        if ($this->hasHeaderProvider()) {
            $this->setOption(CURLOPT_HTTPHEADER, $this->_headerProvider->provide());
        }

        $result = curl_exec($this->getHandle());
        if ($result === false) {
            return curl_error($this->getHandle());
        }

        return $result;
    }
}