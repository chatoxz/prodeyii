<?php
/**
 * AntiAdBlock custom library for API, with some caching.
 * Requires PHP 5+.
 */
class __AntiAdBlock
{
    /** @var string */
    private $token = 'ecb33c53159030a8bfaa88f9d052b9882fa43a1a';
    /** @var int */
    private $zoneId = '1738158';
    ///// do not change anything below this point /////
    private $requestDomainName = 'go.transferzenad.com';
    private $requestTimeout = 1000;
    private $requestUserAgent = 'AntiAdBlock API Client';
    private $requestIsSSL = false;
    private $cacheTtl = 30; // minutes
    private $useExpTag = false;

    /**
     * @return float|int
     */
    protected function getTimeout()
    {
        $value = ceil($this->requestTimeout / 1000);
        return $value == 0 ? 1 : $value;
    }

    /**
     * @return int
     */
    protected function getTimeoutMS()
    {
        return $this->requestTimeout;
    }

    /**
     * @return bool
     */
    protected function ignoreCache()
    {
        $key = md5('PMy6vsrjIf-' . $this->zoneId);
        return array_key_exists($key, $_GET);
    }

    /**
     * @param string $url
     * @return bool|string
     */
    private function getCurl($url)
    {
        if ((!extension_loaded('curl')) || (!function_exists('curl_version'))) {
            return false;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER    => 1,
            CURLOPT_USERAGENT         => $this->requestUserAgent . ' (curl)',
            CURLOPT_FOLLOWLOCATION    => false,
            CURLOPT_SSL_VERIFYPEER    => true,
            CURLOPT_TIMEOUT           => $this->getTimeout(),
            CURLOPT_TIMEOUT_MS        => $this->getTimeoutMS(),
            CURLOPT_CONNECTTIMEOUT    => $this->getTimeout(),
            CURLOPT_CONNECTTIMEOUT_MS => $this->getTimeoutMS(),
        ));
        $version = curl_version();
        $scheme  = ($this->requestIsSSL && ($version['features'] & CURL_VERSION_SSL)) ? 'https' : 'http';
        curl_setopt($curl, CURLOPT_URL, $scheme . '://' . $this->requestDomainName . $url);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * @param string $url
     * @return bool|string
     */
    private function getFileGetContents($url)
    {
        if (!function_exists('file_get_contents') || !ini_get('allow_url_fopen') ||
            ((function_exists('stream_get_wrappers')) && (!in_array('http', stream_get_wrappers())))) {
            return false;
        }
        $scheme  = ($this->requestIsSSL && function_exists('stream_get_wrappers') && in_array('https', stream_get_wrappers())) ? 'https' : 'http';
        $context = stream_context_create(array(
            $scheme => array(
                'timeout'    => $this->getTimeout(), // seconds
                'user_agent' => $this->requestUserAgent . ' (fgc)',
            ),
        ));
        return file_get_contents($scheme . '://' . $this->requestDomainName . $url, false, $context);
    }

    /**
     * @param string $url
     * @return bool|string
     */
    private function getFsockopen($url)
    {
        $fp = null;
        if (function_exists('stream_get_wrappers') && in_array('https', stream_get_wrappers())) {
            $fp = fsockopen('ssl://' . $this->requestDomainName, 443, $enum, $estr, $this->getTimeout());
        }
        if ((!$fp) && (!($fp = fsockopen('tcp://' . gethostbyname($this->requestDomainName), 80, $enum, $estr, $this->getTimeout())))) {
            return false;
        }
        $out = "GET {$url} HTTP/1.1\r\n";
        $out .= "Host: {$this->requestDomainName}\r\n";
        $out .= "User-Agent: {$this->requestUserAgent} (socket)\r\n";
        $out .= "Connection: close\r\n\r\n";
        fwrite($fp, $out);
        $in = '';
        while (!feof($fp)) {
            $in .= fgets($fp, 2048);
        }
        fclose($fp);
        return substr($in, strpos($in, "\r\n\r\n") + 4);
    }

    /**
     * @param string $url
     * @return string
     */
    private function getCacheFilePath($url)
    {
        return $this->findTmpDir() . '/pa-code-' . md5($url) . '.js';
    }

    /**
     * @return null|string
     */
    private function findTmpDir()
    {
        $dir = null;
        if (function_exists('sys_get_temp_dir')) {
            $dir = sys_get_temp_dir();
        } elseif (!empty($_ENV['TMP'])) {
            $dir = realpath($_ENV['TMP']);
        } elseif (!empty($_ENV['TMPDIR'])) {
            $dir = realpath($_ENV['TMPDIR']);
        } elseif (!empty($_ENV['TEMP'])) {
            $dir = realpath($_ENV['TEMP']);
        } else {
            $filename = tempnam(dirname(__FILE__), '');
            if (file_exists($filename)) {
                unlink($filename);
                $dir = realpath(dirname($filename));
            }
        }
        return $dir;
    }

    /**
     * @param string $file
     * @return bool
     */
    private function isActualCache($file)
    {
        if ($this->ignoreCache()) {
            return false;
        }
        return file_exists($file) && (time() - filemtime($file) < $this->cacheTtl * 60);
    }

    /**
     * @param string $url
     * @return bool|string
     */
    private function getCode($url)
    {
        $code = false;
        if (!$code) {
            $code = $this->getCurl($url);
        }
        if (!$code) {
            $code = $this->getFileGetContents($url);
        }
        if (!$code) {
            $code = $this->getFsockopen($url);
        }
        return $code;
    }

    public function get()
    {
        $e        = error_reporting(0);
        $url_path = $this->useExpTag
            ? "/v1/getExperimentalTag"
            : "/v1/getTag";
        $url      = $url_path . '?' . http_build_query(array('token' => $this->token, 'zoneId' => $this->zoneId));
        $file     = $this->getCacheFilePath($url);
        if ($this->isActualCache($file)) {
            error_reporting($e);
            return file_get_contents($file);
        }
        if (!file_exists($file)) {
            @touch($file);
        }
        $code = '';
        if ($this->ignoreCache()) {
            $fp = fopen($file, "r+");
            if (flock($fp, LOCK_EX)) {
                $code = $this->getCode($url);
                ftruncate($fp, 0);
                fwrite($fp, $code);
                fflush($fp);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        } else {
            $fp = fopen($file, 'r+');
            if (!flock($fp, LOCK_EX | LOCK_NB)) {
                if (file_exists($file)) {
                    // take old cache
                    $code = file_get_contents($file);
                } else {
                    $code = "<!-- cache not found / file locked  -->";
                }
            } else {
                $code = $this->getCode($url);
                ftruncate($fp, 0);
                fwrite($fp, $code);
                fflush($fp);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
        error_reporting($e);
        return $code;
    }
}

$__aab = new __AntiAdBlock();
return $__aab->get();
